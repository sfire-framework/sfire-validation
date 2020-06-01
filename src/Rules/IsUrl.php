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
 * Class IsUrl
 * @package sFire\Validation
 */
class IsUrl extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should be a valid URL';


    /**
     * Constructor
     * @param bool $protocol
     */
    public function __construct(bool $protocol = true) {
        $this -> addParameter('protocol', $protocol);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value)) {

            if(false === $this -> getParameter('protocol')) {

                $this -> value = preg_replace('/^http(s)?:\/\//i', '', $this -> value);
                $this -> value = 'http://' . $this -> value;
            }

            return true === (bool) preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', (string) $this -> value);
        }

        return false;
    }
}