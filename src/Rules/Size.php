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
 * Class Size
 * @package sFire\Validation
 */
class Size extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'File size should be :size bytes';


    /**
     * Constructor
     * @param int $size
     */
    public function __construct(int $size) {
        $this -> addParameter('size', $size);
    }


    /**
     * Returns whenever the given value is valid or not
     * @return bool
     */
    public function isValid(): bool {

        $file = $this -> getFile();

        if(false === $file instanceof File || false === is_readable($file -> getPath())) {
            return false;
        }

        $size = filesize($file -> getPath());
        return $size === $this -> getParameter('size');
    }
}