<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation\Errors;

use \ArrayIterator;


/**
 * Class ErrorCollection
 * @package sFire\Validation
 */
class ErrorCollection {


    /**
     * Contains all the error messages
     * @var array
     */
    private array $errors = [];


    /**
     * Adds a new error to the collection
     * @param ValidationError $error
     * @return void
     */
    public function add(ValidationError $error): void {

        $path = implode('.', $error -> getFieldPath());

        $this -> errors[$path] ??= [];
        $this -> errors[$path][] = $error;
    }


    /**
     * Returns all error messages based on optional field name set in the constructor
     * @param null|string $fieldName
     * @return array
     */
    public function get(string $fieldName = null): ArrayIterator {

        $output = [];

        if(null === $fieldName) {

            foreach($this -> errors as $errors) {

                foreach($errors as $error) {
                    $output[] = $error;
                }
            }
        }
        elseif(isset($this -> errors[$fieldName]) ) {

            foreach($this -> errors[$fieldName] as $error) {
                $output[] = $error;
            }
        }

        return new ArrayIterator($output);
    }


    /**
     * Returns if all the given field names are valid. If none given, it will returns if there are any errors.
     * @param string ...$fieldNames
     * @return bool Returns true if there are errors, false if not
     */
    public function has(string ...$fieldNames): bool {

        foreach($fieldNames as $fieldName) {

            if(false === isset($this -> errors[$fieldName])) {
                return false;
            }
        }

        return count($this -> errors) > 0;
    }


    /**
     * Returns the first found error for each field name
     * @return array
     */
    public function distinct(): array {

        $output = [];

        foreach($this -> errors as $field => $error) {

            if(false === isset($output[$field])) {
                $output[$field] = $error[0];
            }
        }

        return array_values($output);
    }
}