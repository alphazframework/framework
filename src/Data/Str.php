<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Data;

use Zest\Contracts\Data\Str as StrContract;

class Str implements StrContract
{
    /**
     * Get the encoding.
     *
     * @param string $encoding Valid encoding.
     *
     * @since 3.0.0
     *
     * @return string
     */
    private static function encoding($encoding = null) :string
    {
        return $encoding ?: \mb_internal_encoding();
    }

    /**
     * Reverse the string.
     *
     * @param string $str      String to be evaluated.
     * @param string $encoding Valid encoding.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function reverse(string $str, $encoding = null) :string
    {
        $newStr = '';
        $dataArr = (array) $str;
        $dataArr[] = self::encoding($encoding);
        $length = self::count($str);
        $dataArr = [$str, $length, 1];

        while ($dataArr[1]--) {
            $newStr .= call_user_func_array('mb_substr', $dataArr);
        }

        return $newStr;
    }

    /**
     * Concat the strings.
     *
     * @param string $g   With concat.
     * @param array  $str String to concat.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function concat($g, ...$str)
    {
        return implode($g, $str);
    }

    /**
     * Count the string.
     *
     * @param string $str      String to be counted.
     * @param string $encoding Valid encoding.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public static function count(string $str, $encoding = null)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, self::encoding($encoding));
        }

        //This approach produce wrong result when use any encoding Scheme like UTF-8
        $i = 1;
        $str = $str."\0";
        while ($str[$i] != "\0") {
            $i++;
        }

        return $i;
    }

    /**
     * Check the string is uppercase.
     *
     * @param string $str String to evaluate uppercase.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function hasUpperCase(string $str)
    {
        $hasUppercase = false;
        $index = 0;
        while ($index < self::count($str)) {
            if ($str[$index] === strtoupper($str[$index])) {
                $hasUppercase = true;
                break;
            }
            $index++;
        }

        return $hasUppercase;
    }

    /**
     * Check the string is lowercase.
     *
     * @param string $str String to evaluate lowercase.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function hasLowerCase(string $str)
    {
        $hasLowercase = false;
        $index = 0;
        while ($index < self::count($str)) {
            if ($str[$index] === strtolower($str[$index])) {
                $hasLowercase = true;
                break;
            }
            $index++;
        }

        return $hasLowercase;
    }
}
