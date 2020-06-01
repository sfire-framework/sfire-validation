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
 * Class IsIp
 * @package sFire\Validation
 */
class IsIp extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should be a valid IP address';


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        $ipv4 = new IsIpv4();
        $ipv4 -> setValue($this -> value);

        $ipv6 = new IsIpv6();
        $ipv6 -> setValue($this -> value);

        return true === ($ipv4 -> isValid() || $ipv6 -> isValid());
    }
}