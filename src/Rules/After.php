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
use sFire\Validation\Exception\InvalidArgumentException;


/**
 * Class After
 * @package sFire\Validation
 */
class After extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Date should be after :date';


    /**
     * Constructor
     * @param string $date
     * @param string $format
     * @throws InvalidArgumentException
     */
    public function __construct(string $date, string $format = 'Y-m-d') {

        if(false === DateTime :: createFromFormat($format, $date)) {
            throw new InvalidArgumentException(sprintf('Date "%s" is not a correct date format', $date));
        }

        $this -> addParameter('date', $date);
        $this -> addParameter('format', $format);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {

            $format    = $this -> getParameter('format');
            $timestamp = DateTime :: createFromFormat($format, $this -> getParameter('date')) -> getTimestamp();
            $date      = DateTime :: createFromFormat($format, (string) $this -> value);

            if(false === $date) {
                return false;
            }

            return $date -> getTimestamp() > $timestamp;
        }

        return false;
    }
}