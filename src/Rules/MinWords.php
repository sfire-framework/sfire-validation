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
 * Class MinWords
 * @package sFire\Validation
 */
class MinWords extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Value should contain at least :minimum words';


    /**
     * Constructor
     * @param int $words The maximum amount of words in a value
     * @param int $minCharacters The amount of characters that a single word should minimum have before it will be treated as a word
     * @param bool $alphanumeric True if a word should only exists of alpha numeric characters (a-z A-Z 0-9), false if not
     */
    public function __construct(int $words, int $minCharacters = 2, bool $alphanumeric = true) {

        $this -> addParameter('words', $words);
        $this -> addParameter('minCharacters', $minCharacters);
        $this -> addParameter('alphanumeric', $alphanumeric);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        if(true === is_string($this -> value) || true === is_numeric($this -> value)) {

            $pattern = true === $this -> getParameter('alphanumeric') ? '/[a-zA-Z0-9]{'. $this -> getParameter('minCharacters') .',}/' : '/[^ ]{'. $this -> getParameter('minCharacters') .',}/';

            if((bool) preg_match_all($pattern, (string) $this -> value, $match)) {
                return count($match[0]) >= $this -> getParameter('words');
            }
        }

        return true;
    }
}