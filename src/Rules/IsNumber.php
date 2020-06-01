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
 * Class IsNumber
 * @package sFire\Validation
 */
class IsNumber extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should be :characters characters long';


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
                return true === is_numeric($this -> value) && false === is_string($this -> value);
            }

            if(preg_match('/^-?[0-9]+(\.?[0-9]*(e\+)?[0-9]+)?$/i', (string) $this -> value)) {
                return true;
            }
        }

        return false;
    }
}