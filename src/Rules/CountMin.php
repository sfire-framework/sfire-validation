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
 * Class CountMin
 * @package sFire\Validation
 */
class CountMin extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Must contain at least :minimum item(s)';


    /**
     * Constructor
     * @param int $minimum
     */
    public function __construct(int $minimum) {
        $this -> addParameter('minimum', $minimum);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_countable($this -> value)) {

            $amount = count($this -> value);
            return $amount >= $this -> getParameter('minimum');
        }

        return false;
    }
}