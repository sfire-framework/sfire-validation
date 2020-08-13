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

use sFire\Validation\Exception\InvalidArgumentException;


/**
 * Class Combine
 * @package sFire\Validation
 */
class Combine {


    /**
     * Contains the glue that will holds all the values together
     * @var null|string
     */
    private ?string $glue = null;


    /**
     * Contains a format that will be used like sprintf
     * @var null|string
     */
    private ?string $format = null;


    /**
     * Contains the name of the combine
     * @var null|string
     */
    private ?string $alias = null;


    /**
     * Contains all the middleware that needs to be executed for all the fields in the combine
     * @var array
     */
    private array $middleware = [];


    /**
     * Contains all the field names of the combine
     * @var array
     */
    private array $fields = [];


    /**
     * Contains the values for each field in the combine as cache for performance if the field needs to be looked up again
     * @var null|string
     */
    private ?string $cachedValue = null;


    /**
     * Contains an instance of CombineCollection
     * @var null|CombineCollection
     */
    private ?CombineCollection $collection = null;


    /**
     * Constructor
     * @param CombineCollection $collection
     * @param array $fieldNames
     */
    public function __construct(CombineCollection $collection, array $fieldNames = []) {

        $this -> collection = $collection;

        foreach($fieldNames as $fieldName) {
            $this -> fields[$fieldName] = null;
        }
    }


    /**
     * Joins field names with the glue string between each field name
     * @param string $glue
     * @return self
     */
    public function glue(string $glue): self {

        $this -> glue = $glue;
        return $this;
    }


    /**
     * Converts the field name values to the specific given format
     * @param string $format
     * @return self
     */
    public function format(string $format): self {

        $this -> format = $format;
        return $this;
    }


    /**
     * Gives the combined field names a new single name that can be used for validation fields or files
     * @param string $alias
     * @return self
     */
    public function alias(string $alias): self {

        $this -> alias = $alias;
        $this -> collection -> add($alias, $this);

        return $this;
    }


    /**
     * Add new validation middleware
     * @param string ...$class
     * @return self
     */
    public function middleware(string ...$class): self {

        $this -> middleware = array_merge($class, $this -> middleware);
        return $this;
    }


    /**
     * Returns the field name
     * @return null|string
     */
    public function getAlias(): ?string {
        return $this -> alias;
    }


    /**
     * Returns the glue
     * @return null|string
     */
    public function getGlue(): ?string {
        return $this -> glue;
    }


    /**
     * Returns the fields with their values
     * @return null|array
     */
    public function getFields(): array {
        return $this -> fields;
    }


    /**
     * Returns the field names
     * @return array
     */
    public function getFieldNames(): array {
        return array_keys($this -> fields);
    }


    /**
     * Returns all the middleware for this combine
     * @return array
     */
    public function getMiddleware(): array {
        return $this -> middleware;
    }


    /**
     * Sets the value for a given field name
     * @param string $field The name of the field
     * @param mixed $value The value for the field
     * @return void
     * @throws InvalidArgumentException
     */
    public function setValue(string $field, $value): void {

        if(false === array_key_exists($field, $this -> fields)) {
            throw new InvalidArgumentException(sprintf('Field "%s" does not exists', $field));
        }

        $this -> fields[$field] = $value;
    }


    /**
     * Combines the values with the glue or format and returns it as one single string
     * @return null|string
     */
    public function combine(): ?string {

        if(null !== $this -> cachedValue) {
            return $this -> cachedValue;
        }

        $output = null;

        if(count($this -> fields) > 0) {

            if(null !== $this -> glue) {
                $output = implode($this -> glue, $this -> fields);
            }
            else {

                $output = $this -> format;

                foreach($this -> fields as $fieldName => $value) {
                    $output = str_replace(':' . $fieldName, $value, $output);
                }
            }
        }

        $this -> cachedValue = $output;
        return $output;
    }
}