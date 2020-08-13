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


use sFire\Validation\Combine\Combine;

/**
 * Class MiddlewareAbstract
 * @package sFire\Validation
 */
abstract class MiddlewareAbstract {


    /**
     * Contains the value of the field that can be used in the middleware
     * @var mixed
     */
    private $value;


    /**
     * Contains the field name for later use in the middleware
     * @var string
     */
    private string $fieldName;


    /**
     * Contains a Combine instance
     * @var null|Combine
     */
    private ?Combine $combine = null;


    /**
     * Method that will run before execution of validation rules
     * @return void
     */
    abstract public function execute(): void;


    /**
     * Set the new value of the key
     * @param mixed $value The new value
     * @return void
     */
    public function setValue($value): void {
        $this -> value = $value;
    }


    /**
     * Returns the key value
     * @return mixed
     */
    public function getValue() {
        return $this -> value;
    }


    /**
     * Set the field name for later use in the middleware
     * @param string $fieldName
     * @return void
     */
    public function setFieldName(string $fieldName): void {
        $this -> fieldName = $fieldName;
    }


    /**
     * Returns the key
     * @return string
     */
    public function getFieldName(): string {
        return $this -> fieldName;
    }


    /**
     * Set a new Combine instance
     * @param null|Combine $combine A Combine instance
     * @return void
     */
    public function setCombine(?Combine $combine): void {
        $this -> combine = $combine;
    }


    /**
     * Returns the combine instance
     * @return null|Combine
     */
    public function getCombine(): ?Combine {
        return $this -> combine;
    }
}