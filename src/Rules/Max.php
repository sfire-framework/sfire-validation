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
 * Class Max
 * @package sFire\Validation
 */
class Max extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Must be less than or equal to :maximum';


    /**
     * Constructor
     * @param float $maximum
     */
    public function __construct(float $maximum) {
        $this -> addParameter('maximum', $maximum);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {
            return floatval($this -> value) <= $this -> getParameter('maximum');
        }

        return true;
    }
}