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
 * Class Required
 * @package sFire\Validation
 */
class Required extends RequiredAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Field is required';


    /**
     * Constructor
     * @param bool $required
     */
    public function __construct(bool $required = true) {

        parent::__construct([]);
        $this -> addParameter('required', $required);
    }


    /**
     * Returns if the value is present or not
     * @return bool
     */
    public function isValid(): bool {

        $required = $this -> getParameter('required');
        $empty    = $this -> isEmpty($this -> value);

        return (true === $required && false === $empty) || (false === $required);
    }


    /**
     * Tells the validator if validation should stop if current rule fails
     * @return bool
     */
    public function isBail(): bool {
        return true === $this -> isEmpty($this -> value);
    }
}