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
 * Class IsIpv4
 * @package sFire\Validation
 */
class IsIpv4 extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should be a valid IPv4 address';


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value)) {
            return true === (bool) preg_match('/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/', (string) $this -> value);
        }

        return false;
    }
}