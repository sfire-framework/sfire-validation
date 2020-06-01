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

use DateTime;


/**
 * Class IsDate
 * @package sFire\Validation
 */
class IsDate extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Must be a valid date';


    /**
     * Constructor
     * @param string $format
     */
    public function __construct(string $format = 'Y-m-d') {
        $this -> addParameter('format', $format);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {

            $format = $this -> getParameter('format');
            $date   = DateTime :: createFromFormat($format, $this -> value);

            return $date && $date -> format($format) === $this -> value;
        }

        return false;
    }
}