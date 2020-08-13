<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation\Collection;

use sFire\Validation\Rules\Required;
use sFire\Validation\Rules\RequiredWith;
use sFire\Validation\Rules\RequiredWithAll;
use sFire\Validation\Rules\RequiredWithout;
use sFire\Validation\Rules\RequiredWithoutAll;
use sFire\Validation\RuleSet;


/**
 * Class CollectionAbstract
 * @package sFire\Validation
 */
abstract class CollectionAbstract {


    /**
     * Contains a collection of rules
     * @var RuleSet[]
     */
    protected array $ruleCollection = [];


    /**
     * Contains all the middleware
     * @var null|array
     */
    protected ?array $middleware = [];


    /**
     * Contains if the collection should be bailed if one rule fails validation
     * @var bool
     */
    protected bool $bail = false;


    /**
     * Contains all the field names
     * @var array
     */
    protected array $fieldNames = [];


    /**
     * Contains a collection of special required rules
     * @var array
     */
    private array $requiredCollection = [];


    /**
     * Constructor
     * @param array $fieldNames
     */
    public function __construct(array $fieldNames) {
        $this -> fieldNames = $fieldNames;
    }


    /**
     * Adds a new rule that will require the field/value (null, '', [] or uploaded file with no path are considered null)
     * @param bool $required
     * @return self
     */
    public function required(bool $required = true): self {

        $ruleset = new RuleSet(Required::class, [$required]);
        $this -> requiredCollection[Required::class] = $ruleset;

        return $this;
    }


    /**
     * Adds a new rule that will require the field/value (null, '', [] or uploaded file with no path are considered null)
     * The field under validation must be present and not empty only if any of the other specified fields are present.
     * @param string ...$fieldNames
     * @return self
     */
    public function requiredWith(string ...$fieldNames): self {

        $ruleset = new RuleSet(RequiredWith::class, [$fieldNames]);
        $this -> requiredCollection[RequiredWith::class] = $ruleset;

        return $this;
    }


    /**
     * Adds a new rule that will require the field/value (null, '', [] or uploaded file with no path are considered null)
     * The field under validation must be present and not empty only if all of the other specified fields are present.
     * @param string ...$fieldNames
     * @return self
     */
    public function requiredWithAll(string ...$fieldNames): self {

        $ruleset = new RuleSet(RequiredWithAll::class, [$fieldNames]);
        $this -> requiredCollection[RequiredWithAll::class] = $ruleset;

        return $this;
    }


    /**
     * Adds a new rule that will require the field/value (null, '', [] or uploaded file with no path are considered null)
     * The field under validation must be present and not empty only when any of the other specified fields are not present.
     * @param string ...$fieldNames
     * @return self
     */
    public function requiredWithout(string ...$fieldNames): self {

        $ruleset = new RuleSet(RequiredWithout::class, [$fieldNames]);
        $this -> requiredCollection[RequiredWithout::class] = $ruleset;

        return $this;
    }


    /**
     * Adds a new rule that will require the field/value (null, '', [] or uploaded file with no path are considered null)
     * The field under validation must be present and not empty only when all of the other specified fields are not present.
     * @param string ...$fieldNames
     * @return self
     */
    public function requiredWithoutAll(string ...$fieldNames): self {

        $ruleset = new RuleSet(RequiredWithoutAll::class, [$fieldNames]);
        $this -> requiredCollection[RequiredWithoutAll::class] = $ruleset;

        return $this;
    }


    /**
     * Returns the collection with specials required rules (these must run first)
     * @return array
     */
    public function getRequiredCollection(): array {
        return $this -> requiredCollection;
    }


    /**
     * Returns all the field names
     * @return array
     */
    public function getFieldNames(): array {
        return $this -> fieldNames;
    }


    /**
     * Returns if individual rules should bail each other
     * @return bool
     */
    public function isBail(): bool {
        return $this -> bail;
    }


    /**
     * Returns all the rules in a single array with the special required rules as priority
     * @return array
     */
    public function getRuleCollection(): array {
        return array_merge($this -> getRequiredCollection(), $this -> ruleCollection);
    }


    /**
     * Sets if a single rule should bail all other rules when validation fails
     * @param bool $bail
     * @return self
     */
    public function bail(bool $bail = true): self {

        $this -> bail = $bail;
        return $this;
    }


    /**
     * Returns the middleware for the collection
     * @return null|array
     */
    public function getMiddleware(): ?array {
        return $this -> middleware;
    }


    /**
     * Uses all the rules from another defined field validator
     * @param array $ruleCollection
     * @return self
     */
    public function using(array $ruleCollection): self {

        $this -> ruleCollection = array_merge($ruleCollection, $this -> ruleCollection);
        return $this;
    }
}