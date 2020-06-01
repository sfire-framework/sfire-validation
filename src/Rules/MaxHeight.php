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
 * Class MaxHeight
 * @package sFire\Validation
 */
class MaxHeight extends RuleAbstract {


    /**
     * Contains the error messages
     * @var null|string
     */
    protected ?string $message = 'Height must be less or equal than :heightpx';


    /**
     * Constructor
     * @param int $height
     */
    public function __construct(int $height) {
        $this -> addParameter('height', $height);
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

        $dimensions = @getimagesize($file -> getPath());

        if(true === is_array($dimensions)) {
            return $dimensions[1] <= $this -> getParameter('height');
        }

        return true;
    }
}