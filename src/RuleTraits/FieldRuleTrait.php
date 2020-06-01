<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation\RuleTraits;

use sFire\Validation\Rules\After;
use sFire\Validation\Rules\Before;
use sFire\Validation\Rules\BeginsWith;
use sFire\Validation\Rules\Between;
use sFire\Validation\Rules\Contains;
use sFire\Validation\Rules\Different;
use sFire\Validation\Rules\Distinct;
use sFire\Validation\Rules\EndsWith;
use sFire\Validation\Rules\Equals;
use sFire\Validation\Rules\In;
use sFire\Validation\Rules\IsAccepted;
use sFire\Validation\Rules\IsAlpha;
use sFire\Validation\Rules\IsAlphaDash;
use sFire\Validation\Rules\IsAlphaNumeric;
use sFire\Validation\Rules\IsBool;
use sFire\Validation\Rules\IsCountable;
use sFire\Validation\Rules\IsEmail;
use sFire\Validation\Rules\IsEmpty;
use sFire\Validation\Rules\IsFalse;
use sFire\Validation\Rules\IsInt;
use sFire\Validation\Rules\IsDate;
use sFire\Validation\Rules\IsIp;
use sFire\Validation\Rules\IsIpPrivate;
use sFire\Validation\Rules\IsIpPublic;
use sFire\Validation\Rules\IsIpv4;
use sFire\Validation\Rules\IsIpv6;
use sFire\Validation\Rules\IsJson;
use sFire\Validation\Rules\IsLength;
use sFire\Validation\Rules\isMacAddress;
use sFire\Validation\Rules\IsNumber;
use sFire\Validation\Rules\IsScalar;
use sFire\Validation\Rules\IsString;
use sFire\Validation\Rules\IsTrue;
use sFire\Validation\Rules\IsUrl;
use sFire\Validation\Rules\LengthBetween;
use sFire\Validation\Rules\Max;
use sFire\Validation\Rules\MaxLength;
use sFire\Validation\Rules\MaxWords;
use sFire\Validation\Rules\Min;
use sFire\Validation\Rules\MinLength;
use sFire\Validation\Rules\MinWords;
use sFire\Validation\Rules\NotContains;
use sFire\Validation\Rules\NotIn;
use sFire\Validation\Rules\Present;
use sFire\Validation\Rules\Regex;
use sFire\Validation\Rules\Same;
use sFire\Validation\Rules\Words;


/**
 * Trait FieldRuleTrait
 * @package sFire\Validation
 */
trait FieldRuleTrait {


    use RuleTrait;
    use ArrayRuleTrait;


    /**
     * Checks if a value comes after a given date
     * @param string $date
     * @param string $format
     * @return self
     */
    public function after(string $date, string $format = 'Y-m-d'): self {
        return $this -> addRule(After::class, [$date, $format]);
    }


    /**
     * Checks if a value comes before a given date
     * @param string $date
     * @param string $format
     * @return self
     */
    public function before(string $date, string $format = 'Y-m-d'): self {
        return $this -> addRule(Before::class, [$date, $format]);
    }


    /**
     * Checks if a value begins with a given value
     * @param mixed $value
     * @return self
     */
    public function beginsWith($value): self {
        return $this -> addRule(BeginsWith::class, [$value]);
    }


    /**
     * Checks if a value comes before a given date
     * @param float $minimum
     * @param float $maximum
     * @return self
     */
    public function between(float $minimum, float $maximum): self {
        return $this -> addRule(Between::class, [$minimum, $maximum]);
    }


    /**
     * Checks if a value contains a given value
     * @param mixed $value
     * @return self
     */
    public function contains($value): self {
        return $this -> addRule(Contains::class, [$value]);
    }


    /**
     * Check if value does not match a value of a given field name
     * @param string $fieldName
     * @return self
     */
    public function different(string $fieldName): self {
        return $this -> addRule(Different::class, [$fieldName]);
    }


    /**
     * Check if all the values in an array are unique
     * @return self
     */
    public function distinct(): self {
        return $this -> addRule(Distinct::class);
    }


    /**
     * Checks if a value ends with a given value
     * @param mixed $value
     * @return self
     */
    public function endsWith($value): self {
        return $this -> addRule(EndsWith::class, [$value]);
    }


    /**
     * Checks if a value equals a given value
     * @param mixed $value
     * @param bool $strict
     * @return self
     */
    public function equals($value, bool $strict = false): self {
        return $this -> addRule(Equals::class, [$value, $strict]);
    }


    /**
     * Checks if a value exists in a given array
     * @param array $collection
     * @param bool $strict
     * @return self
     */
    public function in(array $collection, bool $strict = false): self {
        return $this -> addRule(In::class, [$collection, $strict]);
    }


    /**
     * Checks if a value is accepted
     * @param array $accepted
     * @return self
     */
    public function isAccepted(array $accepted = []): self {
        return $this -> addRule(isAccepted::class, [$accepted]);
    }


    /**
     * Checks if value only contains alpha characters
     * @return self
     */
    public function isAlpha(): self {
        return $this -> addRule(IsAlpha::class);
    }


    /**
     * Checks if value only contains letters and numbers, dashes and underscores
     * @return self
     */
    public function isAlphaDash(): self {
        return $this -> addRule(IsAlphaDash::class);
    }


    /**
     * Checks if value only exists off letters and numbers
     * @return self
     */
    public function isAlphaNumeric(): self {
        return $this -> addRule(IsAlphaNumeric::class);
    }


    /**
     * Checks if value is a boolean
     * @return self
     */
    public function isBool(): self {
        return $this -> addRule(IsBool::class);
    }


    /**
     * Checks if value is countable
     * @return self
     */
    public function isCountable(): self {
        return $this -> addRule(IsCountable::class);
    }


    /**
     * Checks if value is a valid date
     * @param string $format
     * @return self
     */
    public function isDate(string $format = 'Y-m-d'): self {
        return $this -> addRule(IsDate::class, [$format]);
    }


    /**
     * Checks if value is a valid email address
     * @return self
     */
    public function isEmail(): self {
        return $this -> addRule(IsEmail::class);
    }


    /**
     * Checks if a value comes after a given date
     * @return self
     */
    public function isEmpty(): self {
        return $this -> addRule(IsEmpty::class);
    }


    /**
     * Checks if value is boolean false
     * @return self
     */
    public function isFalse(): self {
        return $this -> addRule(IsFalse::class);
    }


    /**
     * Checks if value is an integer number
     * @param bool $strict
     * @return self
     */
    public function isInt(bool $strict = false): self {
        return $this -> addRule(IsInt::class, [$strict]);
    }


    /**
     * Checks if value is a valid IP address (v4 or v6)
     * @return self
     */
    public function isIp(): self {
        return $this -> addRule(IsIp::class);
    }


    /**
     * Checks if value is a private ip address (v4 or v6)
     * @return self
     */
    public function isIpPrivate(): self {
        return $this -> addRule(IsIpPrivate::class);
    }


    /**
     * Checks if value is a public ip address (v4 or v6)
     * @return self
     */
    public function isIpPublic(): self {
        return $this -> addRule(IsIpPublic::class);
    }


    /**
     * Checks if value is a valid IP V4 address
     * @return self
     */
    public function isIpV4(): self {
        return $this -> addRule(IsIpv4::class);
    }


    /**
     * Checks if value is a valid IP V6 address
     * @return self
     */
    public function isIpV6(): self {
        return $this -> addRule(IsIpv6::class);
    }


    /**
     * Checks if value is valid JSON
     * @return self
     */
    public function isJson(): self {
        return $this -> addRule(IsJson::class);
    }


    /**
     * Checks if the value character length is the given length
     * @param int $characters
     * @return self
     */
    public function isLength(int $characters): self {
        return $this -> addRule(IsLength::class, [$characters]);
    }


    /**
     * Checks if value is a valid Mac Address
     * @return self
     */
    public function IsMacAddress(): self {
        return $this -> addRule(isMacAddress::class);
    }


    /**
     * Checks if value is an integer number
     * @param bool $strict
     * @return self
     */
    public function isNumber(bool $strict = false): self {
        return $this -> addRule(IsNumber::class, [$strict]);
    }


    /**
     * Checks if value is a scalar type
     * @return self
     */
    public function isScalar(): self {
        return $this -> addRule(IsScalar::class);
    }


    /**
     * Checks if value is of the type string
     * @return self
     */
    public function isString(): self {
        return $this -> addRule(IsString::class);
    }


    /**
     * Checks if value equals boolean true
     * @return self
     */
    public function isTrue(): self {
        return $this -> addRule(IsTrue::class);
    }


    /**
     * Checks if value is a valid URL
     * @param bool $protocol [optional] True if protocol is required
     * @return self
     */
    public function isUrl(bool $protocol = false): self {
        return $this -> addRule(IsUrl::class, [$protocol]);
    }


    /**
     * Checks if value is a valid URL
     * @param int $minimum The minimum length the value length should be
     * @param int $maximum The maximum length the value length should be
     * @return self
     */
    public function lengthBetween(int $minimum, int $maximum): self {
        return $this -> addRule(LengthBetween::class, [$minimum, $maximum]);
    }


    /**
     * Checks if the value is less than the given maximum amount
     * @param float $maximum
     * @return self
     */
    public function max(float $maximum): self {
        return $this -> addRule(Max::class, [$maximum]);
    }


    /**
     * Checks if the amount of characters is less or equal than the given amount
     * @param int $characters
     * @return self
     */
    public function maxLength(int $characters): self {
        return $this -> addRule(MaxLength::class, [$characters]);
    }


    /**
     * Checks if the amount of words is less than or equal to a given amount
     * @param int $words
     * @param int $minCharacters
     * @param bool $alphanumeric
     * @return self
     */
    public function maxWords(int $words, int $minCharacters = 2, bool $alphanumeric = true): self {
        return $this -> addRule(MaxWords::class, [$words, $minCharacters, $alphanumeric]);
    }


    /**
     * Checks if the value is at least a given minimum
     * @param float $minimum
     * @return self
     */
    public function min(float $minimum): self {
        return $this -> addRule(Min::class, [$minimum]);
    }


    /**
     * Checks if the amount of characters is at least a given amount
     * @param int $characters
     * @return self
     */
    public function minLength(int $characters): self {
        return $this -> addRule(MinLength::class, [$characters]);
    }


    /**
     * Checks if the amount of words is at least a given amount
     * @param int $words
     * @param int $minCharacters
     * @param bool $alphanumeric
     * @return self
     */
    public function minWords(int $words, int $minCharacters = 2, bool $alphanumeric = true): self {
        return $this -> addRule(MinWords::class, [$words, $minCharacters, $alphanumeric]);
    }


    /**
     * Checks if a value does not contain a given value
     * @param mixed $value
     * @return self
     */
    public function notContains($value): self {
        return $this -> addRule(NotContains::class, [$value]);
    }


    /**
     * Checks if a value does not exists in a given array
     * @param array $content
     * @param bool $strict
     * @return self
     */
    public function notIn(array $content, bool $strict = false): self {
        return $this -> addRule(NotIn::class, [$content, $strict]);
    }


    /**
     * Check if value matches a regular expression pattern
     * @param string $pattern
     * @return self
     */
    public function regex(string $pattern): self {
        return $this -> addRule(Regex::class, [$pattern]);
    }


    /**
     * Check if value matches a value of a given field name
     * @param string $fieldName
     * @return self
     */
    public function same(string $fieldName): self {
        return $this -> addRule(Same::class, [$fieldName]);
    }


    /**
     * Check if value exists
     * @return self
     */
    public function present(): self {
        return $this -> addRule(Present::class);
    }


    /**
     * Checks if the amount of words is at least a given amount
     * @param int $words
     * @param int $minCharacters
     * @param bool $alphanumeric
     * @return self
     */
    public function words(int $words, int $minCharacters = 2, bool $alphanumeric = true): self {
        return $this -> addRule(Words::class, [$words, $minCharacters, $alphanumeric]);
    }
}