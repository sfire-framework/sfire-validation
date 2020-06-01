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

use sFire\Validation\Rules\RuleAbstract;


/**
 * Class ValidatorCallback
 * @package sFire\Validation
 */
class ValidatorCallback {


    /**
     * Contains an instance of RuleAbstract
     * @var RuleAbstract|null
     */
    private ?RuleAbstract $rule = null;


    /**
     * Constructor
     * @param RuleAbstract $rule
     */
    public function __construct(RuleAbstract $rule) {
        $this -> rule = $rule;
    }


    /**
     * Returns the value
     * @return mixed
     */
    public function getValue() {

        if(null !== $this -> rule) {
            return $this -> rule -> getValue();
        }

        return null;
    }


    /**
     * Returns the name of the rule
     * @return null|string
     */
    public function getRuleName(): ?string {

        if(null !== $this -> rule) {
            return $this -> rule -> getName();
        }

        return null;
    }


    /**
     * Returns the field name
     * @return null|string
     */
    public function getFieldName(): ?string {

        if(null !== $this -> rule) {
            return $this -> rule -> getFieldName();
        }

        return null;
    }


    /**
     * Returns the parameters
     * @return null|array
     */
    public function getParameters(): ?array {

        if(null !== $this -> rule) {
            return $this -> rule -> getParameters();
        }

        return null;
    }


    /**
     * Returns the value of a given parameter name
     * @param string $parameter The name of the parameter
     * @param null $default [optional] Default value that will be returned if parameter is not found
     * @return mixed|null
     */
    public function getParameter(string $parameter, $default = null) {

        $parameters = $this -> getParameters();
        return $parameters[$parameter] ?? $default;
    }


    /**
     * Sets the error message
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void {

        if(null !== $this -> rule) {
            $this -> rule -> setMessage($message);
        }
    }


    /**
     * Returns the error message
     * @return null|string
     */
    public function getMessage(): ?string {

        if(null !== $this -> rule) {
            return $this -> rule -> getParsedMessage();
        }

        return null;
    }


    /**
     * Retrieves data based on key within the whole set of validation data
     * @param string $key
     * @param mixed $default [optional]
     * @return mixed
     */
    public function getValueByFieldName(string $key, $default = null) {

        if(null !== $this -> rule) {
            return $this -> rule -> getValueByFieldName($key, $default);
        }

        return null;
    }


    /**
     * Returns all the validation data
     * @return null|array
     */
    public function getValidationData(): ?array {

        if(null !== $this -> rule) {
            return $this -> rule -> getValidationData();
        }

        return null;
    }
}
