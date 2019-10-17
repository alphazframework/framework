<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Validation;

class JsonRules extends StickyRules
{
    /**
     * Evaulate Json.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function validate($value)
    {
        if ($this->notBeEmpty($value)) {
            $value = json_decode($value);
            if ($value !== null) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
