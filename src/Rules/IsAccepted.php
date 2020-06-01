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
 * Class IsAccepted
 * @package sFire\Validation
 */
class IsAccepted extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Invalid input';


    /**
     * Constructor
     * @param array $accepted
     */
    public function __construct(array $accepted = []) {

        if(0 === count($accepted)) {
            $accepted = ['yes', 'on', '1', 'true'];
        }

        $this -> addParameter('accepted', $accepted);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {
            return true === in_array($this -> value, $this -> getParameter('accepted'));
        }

        return false;
    }
}