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
 * Class CountBetween
 * @package sFire\Validation
 */
class CountBetween extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should be between :minimum and :maximum';


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

        if(true === is_array($this -> value)) {

            $amount = count($this -> value);
            return $amount >= $this -> getParameter('minimum') && $amount <= $this -> getParameter('maximum');
        }

        return false;
    }
}