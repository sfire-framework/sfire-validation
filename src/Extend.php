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


/**
 * Trait Extend
 * @package sFire\Validation
 */
class Extend {


    /**
     * Contains the error message
     * @var null|string
     */
    private ?string $message = null;


    /**
     * Contains the class/namespace and method for validating the rule
     * @var ExtendCallback
     */
    private ?ExtendCallback $callback = null;


    /**
     * Sets a callback function for validating the rule
     * @param callable $function
     * @return self
     */
    public function callback(callable $function): self {

        $this -> callback = new ExtendCallback();
        $this -> callback -> setFunction($function);

        return $this;
    }


    /**
     * Sets a class/namespace and method for validating the rule
     * @param string $className
     * @param string $methodName
     * @return self
     */
    public function method(string $className, string $methodName): self {

        $this -> callback = new ExtendCallback();
        $this -> callback -> setClassName($className);
        $this -> callback -> setMethodName($methodName);

        return $this;
    }


    /**
     * Returns the callback method/function
     * @return ExtendCallback
     */
    public function getCallback(): ?ExtendCallback {
        return $this -> callback;
    }


    /**
     * Sets the error message
     * @param string $message The error message
     * @return self
     */
    public function message(string $message): self {

        $this -> message = $message;
        return $this;
    }


    /**
     * Returns the error message
     * @return null|string
     */
    public function getMessage(): ?string {
        return $this -> message;
    }
}