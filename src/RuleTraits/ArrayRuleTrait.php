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

use sFire\Validation\Rules\Count;
use sFire\Validation\Rules\CountBetween;
use sFire\Validation\Rules\CountMax;
use sFire\Validation\Rules\CountMin;
use sFire\Validation\Rules\IsArray;


/**
 * Trait ArrayRuleTrait
 * @package sFire\Validation
 */
trait ArrayRuleTrait {


    /**
     * Checks if a value (array) contains a given amount of items
     * @param int $amount
     * @return self
     */
    public function count(int $amount): self {
        return $this -> addRule(Count::class, [$amount]);
    }


    /**
     * Checks if a value (array) contains an amount of items between a given minimum and maximum
     * @param int $minimum
     * @param int $maximum
     * @return self
     */
    public function countBetween(int $minimum, int $maximum): self {
        return $this -> addRule(CountBetween::class, [$minimum, $maximum]);
    }


    /**
     * Checks if a value (array) contains no more items than a given maximum amount
     * @param int $maximum
     * @return self
     */
    public function countMax(int $maximum): self {
        return $this -> addRule(CountMax::class, [$maximum]);
    }


    /**
     * Checks if a value (array) contains at least a given amount of items
     * @param int $minimum
     * @return self
     */
    public function countMin(int $minimum): self {
        return $this -> addRule(CountMin::class, [$minimum]);
    }


    /**
     * Checks if value is an array
     * @return self
     */
    public function isArray(): self {
        return $this -> addRule(IsArray::class);
    }
}