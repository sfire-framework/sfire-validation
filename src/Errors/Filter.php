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
 * Class Filter
 * @package sFire\Validation
 */
class Filter {


    /**
     * Contains all the error messages
     * @var array
     */
    private array $errors = [];


    /**
     * Contains the field name to filter for
     * @var null|string
     */
    private ?string $fieldName = null;


    /**
     * Constructor
     * @param array $errors The array with error messages
     * @param null|string $fieldName [optional] Filtering the errors regarding this field name
     */
    public function __construct(array &$errors, string $fieldName = null) {

        $this -> errors    = &$errors;
        $this -> fieldName = $fieldName;
    }


    /**
     * Returns all error messages based on optional field name set in the constructor
     * @return ValidationError[]
     */
    public function all(): array {

        $output = [];

        if(null === $this -> fieldName) {

            foreach($this -> errors as $fieldName =>  $errors) {

                foreach($errors as $error) {
                    $output[] = $error;
                }
            }
        }
        elseif(isset($this -> errors[$this -> fieldName]) ) {

            foreach($this -> errors[$this -> fieldName] as $error) {
                $output[] = $error;
            }
        }

        return $output;
    }


    /**
     * Returns the first error message
     * @return null|ValidationError
     */
    public function first(): ?ValidationError  {

        $errors = $this -> all();
        return $errors[0] ?? null;
    }


    /**
     * Returns the last error message
     * @return null|ValidationError
     */
    public function last(): ?ValidationError {

        $errors = $this -> all();
        return $errors[count($errors) - 1] ?? null;
    }
}