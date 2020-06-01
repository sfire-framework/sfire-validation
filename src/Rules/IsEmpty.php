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
 * Class IsEmpty
 * @package sFire\Validation
 */
class IsEmpty extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = '';


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        switch(gettype($this -> value)) {

            case 'array': return 0 === count($this -> value); break;
            case 'string': return 0 === strlen($this -> value); break;
            default : return null === $this -> value; break;
        }
    }
}