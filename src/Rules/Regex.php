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
 * Class Regex
 * @package sFire\Validation
 */
class Regex extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Invalid value';


    /**
     * Constructor
     * @param string $pattern
     */
    public function __construct(string $pattern) {
        $this -> addParameter('regex', $pattern);
    }

    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || is_numeric($this -> value)) {
            return (bool) preg_match($this -> getParameter('regex'), (string) $this -> value);
        }

        return false;
    }
}