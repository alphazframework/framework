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
     * Reverse the string.
     *
     * @param string $str String to be evaluated.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function reverse(string $str) :string
    {
        if (function_exists('strrev')) {
            return strrev($str);
        }

        $newStr = '';
        for ((int) $i = self::count($str) - 1; $i >= 0; $i--) {
            $newStr .= $str[$i];
        }

        return $newStr;
    }

    /**
     * Concat the strings.
     *
     * @param string $g    With concat. 
     * @param string $str  String to concat.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function strConcat($g, ...$str)
    {
        return implode($g, $str);
    }

    /**
     * Count the string.
     *
     * @param string $str String to be counted.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public static function count(string $str)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($str);
        }

        //This approach produce wrong result when use any encoding Scheme like UTF-8
        $i = 1;
        $str = $str . "\0";
        while ($str[$i] != "\0") {
            $i++;
        }

        return $i;
    }
}
