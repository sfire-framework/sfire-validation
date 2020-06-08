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
use sFire\DataControl\TypeArray;
use sFire\Validation\Collection\FieldCollection;
use sFire\Validation\Collection\FileCollection;
use sFire\Validation\Combine\Combine;
use stdClass;


/**
 * Class ValidatedData
 * @package sFire\Validation
 */
class ValidatedData {


    /**
     * Contains the validated data
     * @var array
     */
    private array $data = [

        'fields'	=> [],
        'files' 	=> [],
        'combined'  => []
    ];


    /**
     * Contains field names that should be excluded in the resultset
     * @var array
     */
    private array $exclude = [];


    /**
     * @var string|null
     */
    private ?string $prefix = null;


    /**
     * Contains the return types to match the data that needs to be returns calling the toArray or toObject methods
     * @var array
     */
    private array $returnTypes = ['fields' => false, 'files' => false, 'combined' => false];


    /**
     * Adds the return type fields to the output
     * @return self
     */
    public function fields(): self {

        $this -> returnTypes['fields'] = true;
        return $this;
    }


    /**
     * Adds the return type files to the output
     * @return self
     */
    public function files(): self {

        $this -> returnTypes['files'] = true;
        return $this;
    }


    /**
     * Adds the return type combined to the output
     * @return self
     */
    public function combined(): self {

        $this -> returnTypes['combined'] = true;
        return $this;
    }


    /**
     * Excludes all given field names in the resultset
     * @param array $fieldNames
     * @return self
     */
    public function exclude(array $fieldNames): self {

        $this -> exclude = $fieldNames;
        return $this;
    }


    /**
     *
     * @param string $prefix
     * @return self
     */
    public function prefix(string $prefix): self {

        $this -> prefix = $prefix;
        return $this;
    }


    /**
     * Returns an array with the validated data
     * @return array
     */
    public function toArray(): array {

        $output = [];

        if(0 === count(array_filter($this -> returnTypes, function($include) { return $include; }))) {
            $this -> fields() -> files() -> combined();
        }

        foreach($this -> returnTypes as $type => $include) {

            if(true === $include) {
                $output = array_merge($output, $this -> data[$type]);
            }
        }

        //Reset the return types for later use
        $this -> returnTypes = [];
        
        //Exclude values in resultset
        foreach($this -> exclude as $exclude) {

            $translator = new StringTranslator($output);
            $paths      = $translator -> path($exclude);

            if(null === $paths) {
                continue;
            }

            foreach($paths as $keys) {
                TypeArray::removeFromArray($output, $keys['path']);
            }
        }

        //Apply the prefix if there is one
        if(null !== $this -> prefix) {

            $translator = new StringTranslator($output);
            $output = $translator -> get($this -> prefix);
        }

        return $output;
    }


    /**
     * Returns an stdClass with the validated data
     * @return stdClass
     */
    public function toObject(): stdClass {
        return json_decode($this -> toJson(), false);
    }


    /**
     * Returns an JSON string with the validated data
     * @return string
     */
    public function toJson(): string {
        return json_encode($this -> toArray(), JSON_FORCE_OBJECT | JSON_INVALID_UTF8_IGNORE);
    }


    /**
     * Adds a new value to the validated values
     * @param array $path
     * @param mixed $value
     * @param $collection
     * @return void
     */
    public function add(array $path, $value, $collection): void {

        if($collection instanceof FileCollection) {

            TypeArray :: insertIntoArray($this -> data['files'], $path, $value);
            return;
        }

        $index 	= array_pop($path);
        $array = [];

        if(count($path) > 0) {
            TypeArray :: insertIntoArray($array, $path, [$index => $value]);
        }
        else {

            if(null === $index) {
                $array = [$value];
            }
            else {
                $array = [$index => $value];
            }
        }

        if($collection instanceof FieldCollection) {
            $this -> data['fields'] = array_replace_recursive($this -> data['fields'], $array);
        }
        elseif($collection instanceof Combine) {
            $this -> data['combined'] = array_replace_recursive($this -> data['combined'], $array);
        }
    }
}