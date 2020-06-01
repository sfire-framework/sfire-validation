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
 * Class SizeBetween
 * @package sFire\Validation
 */
class SizeBetween extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'File size should be between :minimum and :maximum bytes';


    /**
     * Constructor
     * @param int $minimum
     * @param int $maximum
     */
    public function __construct(int $minimum, int $maximum) {

        $this -> addParameter('minimum', $minimum);
        $this -> addParameter('maximum', $maximum);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(false === is_string($this -> value) || false === is_readable($this -> value)) {
            return false;
        }

        $size = filesize($this -> value);
        return $size >= $this -> getParameter('minimum') && $size <= $this -> getParameter('maximum');
    }
}