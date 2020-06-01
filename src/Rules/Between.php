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
 * Class Between
 * @package sFire\Validation
 */
class Between extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value must be between :minimum and :maximum';


    /**
     * Constructor
     * @param float $minimum
     * @param float $maximum
     */
    public function __construct(float $minimum, float $maximum) {

        $this -> addParameter('minimum', $minimum);
        $this -> addParameter('maximum', $maximum);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {

            if(0 === strlen((string) $this -> value)) {
                return false;
            }

            return floatval($this -> value) >= floatval($this -> getParameter('minimum')) && floatval($this -> value) <= floatval($this -> getParameter('maximum'));
        }

        return false;
    }
}