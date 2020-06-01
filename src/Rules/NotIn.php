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
 * Class NotIn
 * @package sFire\Validation
 */
class NotIn extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Invalid input';


    /**
     * Constructor
     * @param array $content
     * @param bool $strict
     */
    public function __construct(array $content, bool $strict = false) {

        $this -> addParameter('content', $content);
        $this -> addParameter('strict', $strict);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {
        return false === in_array($this -> value, $this -> getParameter('content'), $this -> getParameter('strict'));
    }
}