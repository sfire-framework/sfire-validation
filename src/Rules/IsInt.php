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
 * Class IsInt
 * @package sFire\Validation
 */
class IsInt extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Must be an integer number';


    /**
     * Constructor
     * @param bool $strict
     */
    public function __construct(bool $strict = false) {
        $this -> addParameter('strict', $strict);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || is_numeric($this -> value)) {

            if(true === $this -> getParameter('strict')) {
                return true === is_int($this -> value);
            }

            return true === (bool) preg_match('/^-?[0-9]+$/', (string) $this -> value);
        }

        return false;
    }
}