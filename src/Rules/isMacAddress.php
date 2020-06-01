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
 * Class isMacAddress
 * @package sFire\Validation
 */
class isMacAddress extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value must begin a valid Mac Address';


    /**w
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {
            return true === (bool) preg_match('/^[0-9A-Fa-f]{2}([:-])([0-9A-Fa-f]{2}\1){4}([0-9A-Fa-f]{2})$/', (string) $this -> value);
        }

        return false;
    }
}