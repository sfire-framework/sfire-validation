<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation;


/**
 * Class File
 * @package sFire\Validation
 */
class File {


    /**
     * Contains the base name of the file
     * @var null|string
     */
    private ?string $baseName = null;


    /**
     * Contains the full path of the file
     * @var null|string
     */
    private ?string $path = null;


    /**
     * Sets the base name of the file
     * @param string $baseName
     * @return void
     */
    public function setBaseName(string $baseName): void {
        $this -> baseName = $baseName;
    }


    /**
     * Returns the base name of the file
     * @return null|string
     */
    public function getBaseName(): ?string {
        return $this -> baseName;
    }


    /**
     * Sets the full path of the file
     * @param string $path
     * @return void
     */
    public function setPath(string $path): void {
        $this -> path = $path;
    }


    /**
     * Returns the full path of the file
     * @return null|string
     */
    public function getPath(): ?string {
        return $this -> path;
    }


    /**
     * Returns the extension of the file
     * @return null|string
     */
    public function getExtension(): ?string {

        if(true === is_string($this -> baseName)) {
            return strtolower(pathinfo($this -> baseName, PATHINFO_EXTENSION));
        }

        return null;
    }
}