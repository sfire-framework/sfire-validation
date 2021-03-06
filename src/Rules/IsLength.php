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
 * Class IsLength
 * @package sFire\Validation
 */
class IsLength extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should be :characters characters long';


    /**
     * Constructor
     * @param int $characters
     */
    public function __construct(int $characters) {
        $this -> addParameter('characters', $characters);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || is_numeric($this -> value)) {
            return strlen((string) $this -> value) === $this -> getParameter('characters');
        }

        return false;
    }
}