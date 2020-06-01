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
 * Class Count
 * @package sFire\Validation
 */
class Count extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Must contain :amount item(s)';


    /**
     * Constructor
     * @param int $amount
     */
    public function __construct(int $amount) {
        $this -> addParameter('amount', $amount);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_array($this -> value)) {

            $amount = count($this -> value);
            return $amount == $this -> getParameter('amount');
        }

        return false;
    }
}