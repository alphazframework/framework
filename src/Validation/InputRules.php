<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Validation;

class InputRules extends StickyRules
{
    /**
     * Evaulate required.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function required($value)
    {
        return ($this->notBeEmpty($value)) ? true : false;
    }

    /**
     * Evaulate int.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function int($value)
    {
        if ($this->notBeEmpty($value)) {
            if (is_int($value)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Evaulate float.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function float($value)
    {
        if ($this->notBeEmpty($value)) {
            if (is_float($value)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Evaulate string.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function string($value)
    {
        if ($this->notBeEmpty($value)) {
            if (is_string($value) && preg_match('/[A-Za-z]+/i', $value)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Evaulate email.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function email($value)
    {
        if ($this->notBeEmpty($value)) {
            if (filter_var($value, FILTER_VALIDATE_EMAIL) !== false) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Evaulate ip.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function ip($value)
    {
        return ($this->notBeEmpty($value)) ? filter_var($value, FILTER_VALIDATE_IP) : false;
    }

    /**
     * Evaulate IPv6.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function ipv6($value)
    {
        if ($this->notBeEmpty($value)) {
            return (preg_match('/(([0-9a-fA-F]{0,4}:){1,7}[0-9a-fA-F]{0,4})/i', $value)) ? true : false;
        }
    }

    /**
     * Evaulate alpha.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function alpha($value)
    {
        if ($this->notBeEmpty($value)) {
            return (preg_match('/^[a-zA-Z]+$/', $value)) ? true : false;
        }
    }

    /**
     * Evaulate ipv4 subnet.
     *
     * @param $value Value to be checked
     *
     * @return bool
     */
    public function subnet($value)
    {
        if ($this->notBeEmpty($value)) {
            return (preg_match('/^\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]|[0-9])\b$/', $value)) ? true : false;
        }
    }
}
