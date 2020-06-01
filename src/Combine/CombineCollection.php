<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation\Combine;


/**
 * Class CombineCollection
 * @package sFire\Validation
 */
class CombineCollection {


    /**
     * Contains all the combine instances
     * @var Combine[]
     */
    private array $combines = [];


    /**
     * Adds the alias and combine instance
     * @param string $alias The name of the alias
     * @param Combine $combine A Combine instance
     * @return void
     */
    public function add(string $alias, Combine $combine): void {
        $this -> combines[$alias] = $combine;
    }


    /**
     * Returns a Combine instance based on a given alias
     * @param string $alias The name of the alias
     * @return null|Combine
     */
    public function get(string $alias): ?Combine {
        return $this -> combines[$alias] ?? null;
    }
}