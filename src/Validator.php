<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation;

use sFire\DataControl\Translators\StringTranslator;
use sFire\Http\Request;
use sFire\Validation\Collection\CollectionAbstract;
use sFire\Validation\Collection\FieldCollection;
use sFire\Validation\Collection\FileCollection;
use sFire\Validation\Combine\Combine;
use sFire\Validation\Combine\CombineCollection;
use sFire\Validation\Errors\ErrorCollection;
use sFire\Validation\Errors\ValidationError;
use sFire\Validation\Exception\InvalidArgumentException;
use sFire\Validation\Exception\RuntimeException;
use sFire\Validation\Rules\Custom;
use sFire\Validation\Rules\RuleAbstract;


/**
 * Class Validator
 * @package sFire\Validation
 */
class Validator {


    /**
     * Contains all the field collections with their rules, middleware, etc.
     * @var array
     */
    private array $fieldCollection = [];


    /**
     * Contains all the custom rules defined with the "extend" method
     * @var array
     */
    private array $extendCollection = [];


    /**
     * Contains the result of the validation if validation has been executed.
     * null means that validation has not executed before, true/false means the validation has passed or failed and has been executed
     * @var null|bool
     */
    private ?bool $validated = null;


    /**
     * Contains the data that needs to be validated
     * @var array
     */
    private array $validationData = [];


    /**
     * Contains all the cached paths lookups
     * @var array
     */
    private array $cachedValues = [];


    /**
     * Contains all the middleware that needs to be executed
     * @var array
     */
    private array $middleware = [];


    /**
     * Contains if validation should be enabled or disabled globally when a first validation error occurs
     * @var bool
     */
    private bool $bail = false;


    /**
     * Contains all the unique field names with their collection type (field, combined, file)
     * @var array
     */
    private array $fieldNames = [];


    /**
     * Contains an instance of StringTranslator
     * @var null|StringTranslator
     */
    private ?StringTranslator $translator = null;


    /**
     * Contains an instance of Message
     * @var null|Message
     */
    private ?Message $message = null;


    /**
     * Contains an instance of CombineCollection
     * @var null|CombineCollection
     */
    private ?CombineCollection $combine = null;


    /**
     * Contains an instance of ValidatedData
     * @var null|ValidatedData
     */
    private ?ValidatedData $validatedData = null;


    /**
     * Contains an instance of ErrorCollection
     * @var null|ErrorCollection
     */
    private ?ErrorCollection $errors = null;


	/**
	 * Constructor
	 * @param null|array $validationData [optional] The source of the data that needs to be validated
	 */
	public function __construct(array $validationData = null) {

        $this -> validationData = $validationData ?? $_POST;
        $this -> translator     = new StringTranslator($this -> validationData);
        $this -> validatedData  = new ValidatedData();
        $this -> message        = new Message();
        $this -> combine        = new CombineCollection();
        $this -> errors         = new ErrorCollection();
    }


    /**
     * Adds new field validation
     * @param string ...$fieldNames
     * @return FieldCollection
     */
	public function field(string ...$fieldNames): FieldCollection {

	    $fieldCollection = new FieldCollection($fieldNames);
	    $fieldCollection -> bail($this -> bail);
	    $this -> fieldCollection[] = $fieldCollection;
	    $this -> addFieldNames($fieldNames, FieldCollection::class);

        return $fieldCollection;
    }


    /**
     * Adds new uploaded file validation
     * @param string ...$fieldNames
     * @return FileCollection
     */
    public function file(string ...$fieldNames): FileCollection {

        $fileCollection = new FileCollection($fieldNames);
        $fileCollection -> bail($this -> bail);
        $this -> fieldCollection[] = $fileCollection;
        $this -> addFieldNames($fieldNames, FileCollection::class);

        return $fileCollection;
    }


    /**
     * Extends validation functions by creating a custom defined method or function for validation
     * @param string $name The name of the rule
     * @return Extend
     */
    public function extend(string $name): Extend {

	    $extend = new Extend();
        $this -> extendCollection[$name] = $extend;

        return $extend;
    }


    /**
     * Adds new validation middleware
     * @param string ...$class
     * @return self
     */
    public function middleware(string ...$class): self {

        $this -> middleware = array_merge($class, $this -> middleware);
        return $this;
    }


    /**
     * Combines multiple fields to be as one for validation
     * @param string ...$fields
     * @return Combine
     */
    public function combine(string ...$fields): Combine {
	    return new Combine($this -> combine, $fields);
    }


    /**
     * Adds custom error messages
     * @param array $messages
     * @return void
     */
    public function messages(array $messages): void {
        $this -> message -> set($messages);
    }


    /**
     * Enables or disables validation globally when a first validation error occurs
     * @param bool $bail
     * return void
     */
    public function bail(bool $bail = true): void {
        $this -> bail = $bail;
    }


    /**
     * Returns whenever the validation failed or not
     * @return bool Returns true if validation fails, false otherwise
     */
    public function fails(): bool {
	    return !$this -> execute();
    }


    /**
     * Returns whenever the validation passes or not
     * @return bool Returns true if validation passes, false otherwise
     */
    public function passes(): bool {
        return $this -> execute();
    }


    /**
     * Returns an instance of ValidationErrors for retrieving error messages
     * @return ErrorCollection
     */
    public function errors(): ErrorCollection {
        return $this -> errors;
    }


    /**
     * Returns an instance of ValidatedData for retrieving error messages
     * @return null|ValidatedData
     */
    public function getValidatedData(): ?ValidatedData {
        return $this -> validatedData;
    }


    /**
     * Executes all the given validation rules for all given fields and returns if validation passes or not
     * @return bool Returns true if validation passes, false otherwise
     */
    public function execute(): bool {

        //Check if validation already executed before
        if(null !== $this -> validated) {
            return $this -> validated;
        }

	    $passed = true;

	    foreach($this -> fieldCollection as $fieldItem) {

	        /** @var CollectionAbstract $fieldItem */
            $fieldNames = $fieldItem -> getFieldNames();
            $ruleSets   = $fieldItem -> getRuleCollection();
            $middleware = $this -> getMiddleware($fieldItem);

            foreach($fieldNames as $fieldName) {
                
                //Find the values for each field in a combine instance and process them
                $this -> fillCombineValues($fieldName);

                //Retrieve the value and path for the given field name
                $path = $this -> getPath($fieldName);

                foreach($path as $info) {

                    //Add the value to the validated data after executing the middleware
                    if(null !== $info['path']) {

                        //Execute middleware
                        foreach($middleware as $middlewareClass) {
                            $info['value'] = $this -> executeMiddleware($middlewareClass, $fieldName, $info['value']);
                        }

                        $this -> addValidatedData($info['path'], $fieldName, $info['value'], $fieldItem);
                    }

                    foreach($ruleSets as $ruleSet) {

                        /** @var RuleSet $ruleSet */
                        $class = $ruleSet -> getNamespace();

                        /** @var RuleAbstract $rule */
                        $rule  = new $class(...$ruleSet -> getParameters());
                        $rule -> setValidationData($this -> validationData);
                        $rule -> setFieldName($fieldName);

                        //Set custom message if found
                        $message = $this -> message -> find($fieldName, $rule -> getName());

                        if(null !== $message) {
                            $rule -> setMessage($message);
                        }

                        $valid = $this -> executeRule($rule, $info['value']);

                        //Check if the rule is valid or not
                        if(false === $valid) {

                            $this -> addValidationError($info['path'] ?? [$fieldName], $info['value'], $rule);
                            $passed = false;

                            //Break the loop if bailing is globally enabled
                            if(true === $fieldItem -> isBail()) {
                                break;
                            }
                        }

                        //Break the loop if the rule should bail the rest
                        if(true === $rule -> isBail()) {
                            break;
                        }
                    }
                }
            }
        }

	    $this -> validated = $passed;
	    return $passed;
    }


    /**
     * Adds a new value to the validated values
     * @param array $path
     * @param string $field
     * @param mixed $value
     * @param CollectionAbstract $collection
     * @return void
     */
    private function addValidatedData(array $path, string $field, $value, CollectionAbstract $collection): void {

        if($combine = $this -> combine -> get($field)) {

            $this -> validatedData -> add($path, $value, $combine);

            foreach($combine -> getFieldNames() as $fieldName) {

                $path = $this -> getPath($fieldName);

                foreach($path as $value) {

                    if(null !== $value['path'] && null !== $value['value']) {
                        $this -> addValidatedData($value['path'], $fieldName, $value['value'], $collection);
                    }
                }
            }

            return;
        }

        $this -> validatedData -> add($path, $value, $collection);
    }


    /**
     * Adds a new validation error
     * @param array $fieldPath An array with the path to the field
     * @param mixed $value
     * @param RuleAbstract $rule
     * @return void
     */
    private function addValidationError(array $fieldPath, $value, RuleAbstract $rule): void {

        $error = new ValidationError();
        $error -> setValue($value);
        $error -> setFieldPath($fieldPath ?? []);
        $error -> setRule($rule);

        $this -> errors -> add($error);
    }


    /**
     * Checks if a given field name is being used for validating other types
     * @param array $fieldNames An array with field names
     * @param string $collectionNamespace The namespace of the type of validation
     * @return void
     * @throws InvalidArgumentException
     */
    private function addFieldNames(array $fieldNames, string $collectionNamespace): void {

        foreach($fieldNames as $fieldName) {

            $type = ($this -> fieldNames[$fieldName] ?? null);

            if($type !== null && $type !==  $collectionNamespace) {
                throw new InvalidArgumentException(sprintf('Field name "%s" already used and must be unique for all type of fields. Try to change the field name.', $fieldName));
            }

            $this -> fieldNames[$fieldName] = $collectionNamespace;
        }
    }


    /**
     * Returns the value based on a given field name
     * @param string $fieldName
     * @return mixed
     */
    private function getValue(string $fieldName) {
        return $this -> translator -> get($fieldName);
    }


    /**
     * Finds the values for each field in a combine instance and process them
     * @param string $field
     * @return void
     */
    private function fillCombineValues(string $field): void {

        //Check if the field name is a known combine instance
        if($combine = $this -> combine -> get($field)) {

            foreach($combine -> getFieldNames() as $fieldName) {

                //Retrieve the value from the validation data
                $value = $this -> getValue($fieldName);

                //Execute middleware for each field name in the combine
                foreach($combine -> getMiddleware() as $middleware) {
                    $value = $this -> executeMiddleware($middleware, $fieldName, $value);
                }

                //Set the new value per field name in the combine
                $combine -> setValue($fieldName, $value);
            }
        }
    }


    /**
     * Returns the middleware instances based on a given field item collection
     * @param CollectionAbstract $fieldItem
     * @return array
     */
    private function getMiddleware(CollectionAbstract $fieldItem): array {

        $middleware = $fieldItem -> getMiddleware();

        if(null !== $middleware) {

            if(count($middleware) > 0) {
                return $middleware;
            }

            return $this -> middleware;
        }

        return [];
    }


    /**
     * Executes given middleware to change a given value
     * @param string $middleware
     * @param string $fieldName
     * @param mixed $value
     * @return mixed
     * @throws InvalidArgumentException
     */
    private function executeMiddleware(string $middleware, string $fieldName, $value) {

        /** @var MiddlewareAbstract $middleware */
        $middleware = new $middleware();

        if(false === $middleware instanceof MiddlewareAbstract) {
            throw new InvalidArgumentException(sprintf('Argument 1 passed to %s() must be a result of an instance of %s', __METHOD__, MiddlewareAbstract::class));
        }

        $middleware -> setValue($value);
        $middleware -> setFieldname($fieldName);

        if($combine = $this -> combine -> get($fieldName)) {
            $middleware -> setCombine($combine);
        }

        $middleware -> before();
        return $middleware -> getValue();
    }


    /**
     * Executes a single given rule and returns if the validation passed or not
     * @param RuleAbstract $rule
     * @param mixed $value The value that needs to be validated
     * @return bool Returns true when validation passed, false otherwise
     * @throws RuntimeException
     */
    private function executeRule(RuleAbstract $rule, $value): bool {

        $rule -> setValue($value);

        if($rule instanceof Custom) {

            /** @var Custom $rule */
            $name = $rule -> getName();

            if(false === isset($this -> extendCollection[$name])) {
                throw new RuntimeException(sprintf('Custom rule "%s" is not defined. Set it with the "extend()" method.', $name));
            }

            /** @var Extend $extend */
            $extend   = $this -> extendCollection[$name];
            $callback = $extend -> getCallback();

            $rule -> setCallback($callback);

            //Set the error message if there is one
            if($message = ($rule -> getRawMessage() ?? $extend -> getMessage())) {
                $rule -> setMessage($message);
            }
        }

        //Check if the rule is valid or not
        return $rule -> isValid();
    }


    /**
     * Returns the value based on the field type (combine, input field, file)
     * @param $fieldName
     * @return array
     */
    private function getPath($fieldName): array {

        //Check if the path is already known
        if(true === isset($this -> cachedValues[$fieldName])) {
            return $this -> cachedValues[$fieldName];
        }

        //Check if field is a combine instance

        if($combine = $this -> combine -> get($fieldName)) {
            $path = [['value' => $combine -> combine(), 'path' => explode('.', $fieldName)]];
        }
        else {

            $type = $this -> fieldNames[$fieldName] ?? null;
            $path = null;

            switch($type) {

                case FileCollection::class:

                    $files      = Request :: getUploadedFiles();
                    $translator = new StringTranslator($files);
                    $path       = $translator -> path($fieldName);
                    break;

                case FieldCollection::class:

                    $path = $this -> translator -> path($fieldName);
                    break;
            }
        }

        //Cache the path
        $this -> cachedValues[$fieldName] = $path;

        return $path ?? [['value' => null, 'path' => null]];
    }
}