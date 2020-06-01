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

use sFire\Validation\Exception\OutOfBoundsException;


/**
 * Class Message
 * @package sFire\Validation
 */
class Message {


    /**
     * Contains all the error messages for rules
     * @var array
     */
    private array $rules = [];


    /**
     * Contains all the error messages for specific fields
     * @var array
     */
    private array $fields = [];


    /**
     * Contains all the custom error messages
     * @var array
     */
    private array $messages = [];


    /**
     * Sets a new array with custom error messages
     * @param array $messages
     * @return void
     */
    public function set(array $messages): void {

        $this -> messages = $messages;
        $this -> format();
    }


    /**
     * Returns the error message by looking up the field with optional rule name in the custom errors messages list
     * @param string $fieldName The name of the field
     * @param null|string $ruleName [optional] The name of the rule
     * @return null|string
     */
    public function find(string $fieldName, string $ruleName = null): ?string {
        return $this -> fields[$fieldName][strtolower($ruleName)] ?? $this -> rules[strtolower($ruleName)] ?? null;
    }


    /**
     * Formats the custom error message for easy lookup
     * @return void
     * @throws OutOfBoundsException
     */
    private function format(): void {

        $rules  = [];
        $fields = [];

        foreach($this -> messages as $key => $message) {

            if(true === is_string($message)) {
                $rules[strtolower($key)] = $message;
            }
            elseif(true === is_array($message)) {

                $field   = $key;
                $rule    = key($message);
                $message = reset($message);

                if(false === is_string($rule)) {
                    throw new OutOfBoundsException(sprintf('Rule must be of the type string, got "%s"', gettype($rule)));
                }

                if(false === is_string($message)) {
                    throw new OutOfBoundsException(sprintf('Custom error message with rule "%s" must be of the type string, "%s" given', $rule, gettype($message)));
                }

                $fields[$field] ??= [];
                $fields[$field][strtolower($rule)] ??= $message;
            }
        }

        $this -> rules = $rules;
        $this -> fields = $fields;
    }
}