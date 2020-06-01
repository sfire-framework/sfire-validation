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
 * Class RuleSet
 * @package sFire\Validation
 */
class RuleSet {


    /**
     * Contains the classname/namespace
     * @var null|string
     */
    protected ?string $className = null;


    /**
     * Contains all the parameters
     * @var array
     */
    protected array $parameters = [];


    /**
     * Constructor
     * @param string $namespace
     * @param array $parameters
     */
    public function __construct(string $namespace, array $parameters = []) {

        $this -> setNamespace($namespace);
        $this -> setParameters($parameters);
    }


    /**
     * Returns the classname/namespace
     * @return null|string
     */
    public function getNamespace(): ?string {
        return $this -> className;
    }


    /**
     * Sets the classname/namespace
     * @param string $namespace
     * @return void
     */
    public function setNamespace(string $namespace): void {
        $this -> className = $namespace;
    }


    /**
     * Returns the parameters as an array
     * @return array
     */
    public function getParameters(): array {
        return $this -> parameters;
    }


    /**
     * Sets the parameters
     * @param array $parameters
     */
    public function setParameters(array $parameters) {
        $this -> parameters = $parameters;
    }
}