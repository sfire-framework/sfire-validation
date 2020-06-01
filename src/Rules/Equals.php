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
 * Class Equals
 * @package sFire\Validation
 */
class Equals extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Invalid input';


    /**
     * Constructor
     * @param mixed $value
     * @param bool $strict
     */
    public function __construct($value, bool $strict = false) {

        $this -> addParameter('value', $value);
        $this -> addParameter('strict', $strict);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        //Check if strict mode is active
        if(true === $this -> getParameter('strict')) {

            //Compare the two types
            if(gettype($this -> value) !== gettype($this -> getParameter('value'))) {
                return false;
            }

            //Compare strictly
            return $this -> value === $this -> getParameter('value');
        }

        //Compare but not strictly
        return $this -> value == $this -> getParameter('value');
    }
}