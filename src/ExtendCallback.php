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

use ReflectionMethod;
use sFire\Validation\Exception\RuntimeException;


/**
 * Class ExtendCallback
 * @package sFire\Validation
 */
class ExtendCallback {


    /**
     * Contains the class name if extending validation is used as objects/classes
     * @var null|string
     */
    private ?string $className = null;


    /**
     * Contains the method name if extending validation is used as objects/classes
     * @var null|string
     */
    private ?string $methodName = null;


    /**
     * Contains a callable function if extending validation is used as functions
     * @var null|callable
     */
    private $callableFunction = null;


    /**
     * Sets the class name if extending validation is used as objects/classes
     * @param string $className
     * @return void
     */
    public function setClassName(string $className): void {
        $this -> className = $className;
    }


    /**
     * Returns the class name if extending validation is used as objects/classes
     * @return null|string
     */
    public function getClassName() {
        return $this -> className;
    }


    /**
     * Sets the method name if extending validation is used as objects/classes
     * @param string $methodName
     * @return void
     */
    public function setMethodName(string $methodName): void {
        $this -> methodName = $methodName;
    }


    /**
     * Returns the methodName name if extending validation is used as objects/classes
     * @return null|string
     */
    public function getMethodName(): ?string {
        return $this -> methodName;
    }


    /**
     * Sets a callable function if extending validation is used as functions
     * @param callable $function
     * @return void
     */
    public function setFunction(callable $function): void {
        $this -> callableFunction = $function;
    }


    /**
     * Returns a callable function if extending validation is used as functions
     * @return mixed
     */
    public function getFunction() {
        return $this -> callableFunction;
    }


    /**
     * @param ValidatorCallback $callback
     * @return bool
     * @throws RuntimeException
     */
    public function execute(ValidatorCallback $callback): bool {

        $parameters = [$callback -> getValue(), $callback -> getParameters() ?? [], $callback];

        if(null === $this -> getClassName()) {

            if(null === $this -> getFunction()) {
                throw new RuntimeException(sprintf('Custom rule "%s" has no valid callable function. Set it with the "callback()" method.', $callback -> getName()));
            }

            //Execute function
            $valid = call_user_func_array($this -> getFunction(), $parameters);
        }
        else {

            $className = $this -> getClassName();
            $methodName = $this -> getMethodName();

            if(null === $methodName) {
                throw new RuntimeException(sprintf('Custom rule "%s" has no valid callable method. Set it with the "method()" method.', $callback -> getName()));
            }

            if(false === class_exists($className)) {
                throw new RuntimeException(sprintf('Class "%s" does not exists for custom rule "%s".', $className, $callback -> getName()));
            }

            //Check if method is static
            $reflection = new ReflectionMethod($className, $methodName);

            //Method should be called statically
            if(true === $reflection -> isStatic()) {
                $valid = call_user_func_array([$className, $methodName], $parameters);
            }

            //Method should be called by creating a new instance of the class itself
            else {

                $class = new $className();
                $valid = $class -> {$methodName}(...$parameters);
            }
        }

        if(false === is_bool($valid)) {
            throw new RuntimeException(sprintf('Custom rule "%s" should return a boolean, "%s" given.', $callback -> getName(), gettype($valid)));
        }

        return $valid;
    }
}
