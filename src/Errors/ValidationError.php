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

use sFire\Validation\Rules\RuleAbstract;


/**
 * Class ValidationError
 * @package sFire\Validation
 */
class ValidationError {


    /**
     * Contains the value that has been validated
     * @var mixed
     */
    private $value;


    /**
     * Contains the path to the value in the validation data
     * @var array
     */
    private array $fieldPath = [];


    /**
     * Contains the validation rule
     * @var null|RuleAbstract
     */
    private ?RuleAbstract $rule = null;


    /**
     * Sets the value that has been validated
     * @param $value
     */
    public function setValue($value) {
        $this -> value = $value;
    }


    /**
     * Returns the value that has been validated
     * @return mixed
     */
    public function getValue() {
        return $this -> value;
    }


    /**
     * Sets the path to the value in the validation data
     * @param array $fieldPath
     */
    public function setFieldPath(array $fieldPath) {
        $this -> fieldPath = $fieldPath;
    }


    /**
     * Returns the path to the value in the validation data
     * @return array
     */
    public function getFieldPath(): array {
        return $this -> fieldPath;
    }


    /**
     * Sets an instance of RuleAbstract
     * @param RuleAbstract $rule
     * @return void
     */
    public function setRule(RuleAbstract $rule): void {
        $this -> rule = $rule;
    }


    /**
     * Returns the name of the used rule
     * @return null|string
     */
    public function getRuleName(): ?string {

        if(null !== $this -> rule) {
            return $this -> rule -> getName();
        }

        return null;
    }


    /**
     * Returns the parsed (with variable parameters) error message
     * @return null|string
     */
    public function getMessage(): ?string {

        if(null !== $this -> rule) {
            return $this -> rule -> getParsedMessage();
        }

        return null;
    }


    /**
     * Returns the raw (without variable parameters) error message
     * @return null|string
     */
    public function getRawMessage(): ?string {

        if(null !== $this -> rule) {
            return $this -> rule -> getRawMessage();
        }

        return null;
    }


    /**
     * Returns the parameters used for validation
     * @return null|array
     */
    public function getParameters(): ?array {

        if(null !== $this -> rule) {
            return $this -> rule -> getParameters();
        }

        return null;
    }
}