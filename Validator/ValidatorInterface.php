<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Softhub99\Zest_Franewir\Interfaces\Validator;

interface ValidatorInterface
{
    public function compile($rules);

    public function makeItRequired($inputName);

    public function max($inputName, $value);

    public function min($inputName, $value);

    public function cleanHtml($inputName);

    public function typeof($type, $inputName, $inputValue);
}
