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
 * Class RequiredWithAll
 * @package sFire\Validation
 */
class RequiredWithAll extends RequiredAbstract {


    /**
     * Returns if the value is present or not
     * @return bool
     */
    public function isValid(): bool {

        $empty      = $this -> isEmpty($this -> value);
        $fieldNames = $this -> getParameter('fieldNames');

        if(true === $empty) {

            foreach($fieldNames as $fieldName) {

                if(true === $this -> isEmpty($this -> getValueByFieldName($fieldName))) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }
}