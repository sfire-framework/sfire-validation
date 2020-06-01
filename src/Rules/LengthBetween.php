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
 * Class LengthBetween
 * @package sFire\Validation
 */
class LengthBetween extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should be between :minimum and :maximum characters long';


    /**
     * Constructor
     * @param int $minimum
     * @param int $maximum
     */
    public function __construct(int $minimum, int $maximum) {

        $this -> addParameter('minimum', $minimum);
        $this -> addParameter('maximum', $maximum);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || is_numeric($this -> value)) {

            $length = strlen((string) $this -> value);
            return $length >= $this -> getParameter('minimum') && $length <= $this -> getParameter('maximum');
        }

        return false;
    }
}