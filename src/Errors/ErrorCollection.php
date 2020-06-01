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
     * Returns a Filter object for retrieving all, first and last error messages
     * @param null|string $fieldName
     * @return Filter
     */
    public function get(string $fieldName = null): Filter {
        return new Filter($this -> errors, $fieldName);
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


    public function distinct() {

        $output = [];

        foreach($this -> errors as $field => $error) {

            if(false === isset($output[$field])) {
                $output[$field] = $error[0];
            }
        }

        return array_values($output);
    }
}