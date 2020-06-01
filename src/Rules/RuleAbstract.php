<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation\Rules;

use ReflectionClass;
use sFire\DataControl\Translators\StringTranslator;
use sFire\Validation\Exception\InvalidArgumentException;
use sFire\Validation\File;


/**
 * Class RuleAbstract
 * @package sFire\Validation
 */
abstract class RuleAbstract {


    /**
     * Contains the whole set of data that will be validated
     * @var array
     */
    private array $validationData = [];


    /**
     * Contains the value that needs to be validated
     * @var mixed
     */
    protected $value = null;


    /**
     * Contains the field name
     * @var mixed
     */
    private ?string $fieldName = null;


    /**
     * Contains the error message of the rule
     * @var null|string
     */
    protected ?string $message = null;


    /**
     * Contains an instance of StringTranslator
     * @var null|StringTranslator
     */
    private ?StringTranslator $translator = null;


    /**
     * Contains all the parameters that the rule needs to validate the value
     * @var array
     */
    private array $parameters = [];


    /**
     * Returns whenever the rule is valid or not
     * @return bool
     */
    abstract public function isValid(): bool;


    /**
     * Sets the value that needs to be validated
     * @param mixed $value
     * @return void
     */
    public function setValue($value): void {
        $this -> value = $value;
    }


    /**
     * Returns the value that needs to be validated
     * @return mixed
     */
    public function getValue() {
        return $this -> value;
    }


    /**
     * Sets the field name
     * @param string $fieldName
     * @return void
     */
    public function setFieldName(string $fieldName): void {
        $this -> fieldName = $fieldName;
    }


    /**
     * Sets the field name
     * @return null|string
     */
    public function getFieldName(): ?string {
        return $this -> fieldName;
    }


    /**
     * Sets a custom message for the current rule
     * @param string $message Tje custom message
     * @return void
     */
    public function setMessage(string $message): void {
        $this -> message = $message;
    }


    /**
     * Sets a new parameter that can later be used to validate the value
     * @param mixed $name The name of the parameter
     * @param mixed $value The value of the parameter
     * @return void
     */
    public function addParameter($name, $value): void {
        $this -> parameters[$name] = $value;
    }


    /**
     * Returns the value of a given parameter
     * @param string $name The name of the parameter
     * @return mixed The value of the parameter
     * @throws InvalidArgumentException
     */
    public function getParameter(string $name) {

        if(false === isset($this -> parameters[$name])) {
            throw new InvalidArgumentException(sprintf('Parameter "%s" does not exists', $name));
        }

        return $this -> parameters[$name];
    }


    /**
     * Returns if the rule will bail other rules by default
     * @return bool
     */
    public function isBail(): bool {
        return false;
    }


    /**
     * Returns the class name of the current rule
     * @return string
     */
    public function getName(): string {
        return (new ReflectionClass($this)) -> getShortName();
    }


    /**
     * Returns the error message with parsed parameters
     * @return string
     */
    public function getParsedMessage(): ?string {

        $message = $this -> getRawMessage();

        foreach($this -> getParameters() as $name => $value) {

            if(true === is_array($value)) {
                $value = implode(', ', $value);
            }

            $message = str_replace(':' . $name, $value, $message);
        }

        return $message;
    }


    /**
     * Returns the raw error message without parsed name variables
     * @return null|string
     */
    public function getRawMessage(): ?string {
        return $this -> message;
    }


    /**
     * Returns the rule parameters
     * @return array
     */
    public function getParameters(): array {
        return $this -> parameters;
    }


    /**
     * Check if a given value is empty (i.e. empty string, empty array, null, etc.)
     * @param $value
     * @return bool
     */
    public function isEmpty($value): bool {

        $empty = new IsEmpty();
        $empty -> setValue($value);

        return $empty -> isValid();
    }


    /**
     * Retrieves data based on key within the whole set of validation data
     * @param string $key
     * @param mixed $default [optional]
     * @return mixed
     */
    public function getValueByFieldName(string $key, $default = null) {

        if(null === $this -> translator) {
            $this -> translator = new StringTranslator($this -> validationData);
        }

        return $this -> translator -> get($key, $default);
    }


    /**
     * Returns the whole set of validation data
     * @return array
     */
    public function getValidationData() {
        return $this -> validationData;
    }

    /**
     * Sets the validation data
     * @param array $validationData
     */
    public function setValidationData(array $validationData) {
        $this -> validationData = $validationData;
    }


    /**
     * Returns a File instance when dealing with uploaded files.
     * If no uploaded file found based on the current value, it will return current value as it is.
     * @return mixed
     */
    public function getFile() {

        if(true === is_array($this -> value)) {

            if(true === array_key_exists('tmp_name', $this -> value) && true === array_key_exists('name', $this -> value)) {

                $file = new File();
                $file -> setPath($this -> value['tmp_name']);
                $file -> setBaseName($this -> value['name']);

                return $file;
            }
        }

        return $this -> value;
    }
}