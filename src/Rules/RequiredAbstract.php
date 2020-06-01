<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation\Rules;


/**
 * Class RequiredAbstract
 * @package sFire\Validation
 */
abstract class RequiredAbstract extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Field is required';


    /**
     * Returns if the value is present or not
     * @return bool
     */
    abstract public function isValid(): bool;


    /**
     * Constructor
     * @param array $fieldNames
     */
    public function __construct(array $fieldNames) {
        $this -> addParameter('fieldNames', $fieldNames);
    }


    /**
     * Tells the validator if validation should stop if current rule fails
     * @return bool
     */
    public function isBail(): bool {
        return true === $this -> isEmpty($this -> value);
    }
}