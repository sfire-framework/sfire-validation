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
 * Class IsBool
 * @package sFire\Validation
 */
class IsBool extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should be of the type boolean';


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {
        return true === is_bool($this -> value);
    }
}