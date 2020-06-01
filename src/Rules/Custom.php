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

use sFire\Validation\Exception\RuntimeException;
use sFire\Validation\ExtendCallback;
use sFire\Validation\ValidatorCallback;


/**
 * Class Custom
 * @package sFire\Validation
 */
class Custom extends RuleAbstract {


    /**
     * Contains the name of the rule
     * @var null|string
     */
    private ?string $name = null;


    /**
     * Contains the callback method for validating the value
     * @var null|ExtendCallback
     */
    private ?ExtendCallback $callback = null;


    /**
     * Constructor
     * @param string $name The name of the rule
     * @param mixed ...$arguments The parameters for the rule
     */
    public function __construct(string $name, ...$arguments) {

        if(true === isset($arguments[0]) && true === is_array($arguments[0])) {

            foreach($arguments[0] as $key => $value) {
                $this -> addParameter($key, $value);
            }
        }

        $this -> name = $name;
    }


    /**
     * Returns the name of the rule
     * @return string
     */
    public function getName(): string {
        return $this -> name;
    }


    /**
     * Sets an instance of ExtendCallback for executing at method or function as validation
     * @param ExtendCallback  $callback
     */
    public function setCallback(ExtendCallback $callback) {
        $this -> callback = $callback;
    }


    /**
     * Returns whenever the rule is valid or not
     * @return bool
     * @throws RuntimeException
     */
    public function isValid(): bool {

        if(null === $this -> callback) {
            throw new RuntimeException(sprintf('Validation method for custom rule "%s" not set. Set it with the "extend()" method.', $this -> name));
        }

        return $this -> callback -> execute(new ValidatorCallback($this));
    }
}