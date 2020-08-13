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
 * Class MaxLength
 * @package sFire\Validation
 */
class MaxLength extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should not be longer than :characters characters';


    /**
     * Constructor
     * @param int $length
     */
    public function __construct(int $length) {
        $this -> addParameter('characters', $length);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {

            $length = strlen((string) $this -> value);
            return $length <= $this -> getParameter('characters');
        }

        return true;
    }
}