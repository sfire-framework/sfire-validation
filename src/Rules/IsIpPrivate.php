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
 * Class IsIpPrivate
 * @package sFire\Validation
 */
class IsIpPrivate extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'IP address should be private';


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        $ip = new IsIp();
        $ip -> setValue($this -> value);

        if(false === $ip -> isValid()) {
            return false;
        }

        $ip = new IsIpPublic();
        $ip -> setValue($this -> value);

        return false === $ip -> isValid();
    }
}