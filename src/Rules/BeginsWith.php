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
 * Class BeginsWith
 * @package sFire\Validation
 */
class BeginsWith extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value must begin with ":value"';


    /**
     * Constructor
     * @param mixed $value
     */
    public function __construct($value) {
        $this -> addParameter('value', $value);
    }


    /**w
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {
            return true === (bool) preg_match('/^'. preg_quote($this -> getParameter('value')) .'/', (string) $this -> value);
        }

        return false;
    }
}