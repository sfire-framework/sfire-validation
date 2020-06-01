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
 * Class IsAlphaDash
 * @package sFire\Validation
 */
class IsAlphaDash extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Only letters a-z, A-Z, digits 0-9, dashes and underscores allowed';


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {

            preg_match_all('/[^a-zA-Z0-9_\-]+$/', (string) $this -> value, $match);
            return 0 === count($match[0]);
        }

        return false;
    }
}