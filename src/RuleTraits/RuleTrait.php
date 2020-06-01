<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation\RuleTraits;

use sFire\Validation\Rules\Custom;
use sFire\Validation\RuleSet;


/**
 * Trait RuleTrait
 * @package sFire\Validation
 */
trait RuleTrait {


    /**
     * Executes a custom defined rule based on a given rule name
     * @param string $name The name of the rule
     * @param array $parameters [optional] The arguments for the rule
     * @return self
     */
    public function custom(string $name, array $parameters = []): self {
        return $this -> addRule(Custom::class, [$name, $parameters]);
    }


    /**
     * Add new validation middleware
     * @param string ...$class
     * @return self
     */
    public function middleware(string ...$class): self {

        if(count($class) > 0) {
            $this -> middleware = array_merge($class, ($this -> middleware ?? []));
        }
        else {
            $this -> middleware = null;
        }

        return $this;
    }


    /**
     * Adds a new rule to the collection
     * @param string $rule The rule namespace/class
     * @param array $parameters The arguments for the rule
     * @return self
     */
    private function addRule(string $rule, array $parameters = []): self {

        $ruleset = new RuleSet($rule, $parameters);
        $this -> ruleCollection[] = $ruleset;

        return $this;
    }
}