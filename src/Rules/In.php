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
 * Class In
 * @package sFire\Validation
 */
class In extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Invalid input';


    /**
     * Constructor
     * @param array $collection
     * @param bool $strict
     */
    public function __construct(array $collection, bool $strict = false) {

        $this -> addParameter('collection', $collection);
        $this -> addParameter('strict', $strict);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {
        return true === in_array($this -> value, $this -> getParameter('collection'), $this -> getParameter('strict'));
    }
}