<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Validation\Collection;

use sFire\Validation\RuleTraits\FieldRuleTrait;


/**
 * Class FieldCollection
 * @package sFire\Validation
 */
class FieldCollection extends CollectionAbstract {

    use FieldRuleTrait;
}