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

use sFire\Validation\File;


/**
 * Class NotExtension
 * @package sFire\Validation
 */
class NotExtension extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Invalid file extension';


    /**
     * Constructor
     * @param array $extensions
     */
    public function __construct(string ...$extensions) {
        $this -> addParameter('extensions', array_unique($extensions));
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        $file = $this -> getFile();

        if(false === $file instanceof File || false === is_readable($file -> getPath())) {
            return true;
        }

        $extensions = array_map(function($extension) {
            return ltrim(strtolower($extension), '.');
        }, $this -> getParameter('extensions'));

        return false === in_array($file -> getExtension(), $extensions);
    }
}