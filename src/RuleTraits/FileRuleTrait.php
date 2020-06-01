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

use sFire\Validation\Rules\Dimensions;
use sFire\Validation\Rules\Exists;
use sFire\Validation\Rules\Extension;
use sFire\Validation\Rules\MaxHeight;
use sFire\Validation\Rules\MaxSize;
use sFire\Validation\Rules\MaxWidth;
use sFire\Validation\Rules\MinHeight;
use sFire\Validation\Rules\MinSize;
use sFire\Validation\Rules\MinWidth;
use sFire\Validation\Rules\NotExtension;
use sFire\Validation\Rules\SizeBetween;


/**
 * Trait FileRuleTrait
 * @package sFire\Validation
 */
trait FileRuleTrait {


    use RuleTrait;
    use ArrayRuleTrait;


    /**
     * Checks if the file dimensions matches the given width and height
     * @param int $width
     * @param int $height
     * @return self
     */
    public function dimensions(int $width, int $height): self {
        return $this -> addRule(Dimensions::class, [$width, $height]);
    }


    /**
     * Checks if a file exists
     * @return self
     */
    public function exists(): self {
        return $this -> addRule(Exists::class);
    }


    /**
     * Checks if the file extension match an array with extensions
     * @param string ...$extensions
     * @return self
     */
    public function extension(string ...$extensions): self {
        return $this -> addRule(Extension::class, $extensions);
    }


    /**
     * Checks if the file extension does not match an array with extensions
     * @param string ...$extensions
     * @return self
     */
    public function notExtension(string ...$extensions): self {
        return $this -> addRule(NotExtension::class, $extensions);
    }


    /**
     * Checks if the file height in pixels is less than or equals to a given height in pixels
     * @param int $size Size in pixels
     * @return self
     */
    public function maxHeight(int $size): self {
        return $this -> addRule(MaxHeight::class, [$size]);
    }


    /**
     * Checks if a file does not exceeds a given file size
     * @param int $size
     * @return self
     */
    public function maxSize(int $size): self {
        return $this -> addRule(MaxSize::class, [$size]);
    }


    /**
     * Checks if the file width in pixels is less than or equals to a given width in pixels
     * @param int $size Size in pixels
     * @return self
     */
    public function maxWidth(int $size): self {
        return $this -> addRule(MaxWidth::class, [$size]);
    }


    /**
     * Checks if the file height in pixels is at least a given height in pixels
     * @param int $size Size in pixels
     * @return self
     */
    public function minHeight(int $size): self {
        return $this -> addRule(MinHeight::class, [$size]);
    }


    /**
     * Checks if a file size is at least a given file size
     * @param int $size Size in bytes
     * @return self
     */
    public function minSize(int $size): self {
        return $this -> addRule(MinSize::class, [$size]);
    }


    /**
     * Checks if the file width in pixels is at least a given width in pixels
     * @param int $size Size in pixels
     * @return self
     */
    public function minWidth(int $size): self {
        return $this -> addRule(MinWidth::class, [$size]);
    }


    /**
     * Checks if a file size is between a given minimum and maximum file size
     * @param int $minimum Size in bytes
     * @param int $maximum Size in bytes
     * @return self
     */
    public function sizeBetween(int $minimum, int $maximum): self {
        return $this -> addRule(SizeBetween::class, [$minimum, $maximum]);
    }
}