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
     * @param string $str String to concat.
     *
     * @since 3.0.0
     *
     * @return bool
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
     * Check if string has atleast one uppercase.
     *
     * @param string $str String to be checked.
     *
     * @return bool
     */
    public static function hasUpperCase(string $str)
    {
        $all_words = preg_split('/\s+/', $str);

        foreach ($all_words as $word) {
            if (preg_match_all('~^\p{Lu}~u', $word)) {
                // There is one upper
                return true;
            }
        }

        return false;
    }

    /**
     * Check if string has atleast one lowercase.
     *
     * @param string $str String to be checked.
     *
     * @return bool
     */
    public static function hasLowerCase(string $str)
    {
        $all_words = preg_split('/\s+/', $str);

        foreach ($all_words as $word) {
            if (!preg_match_all('~^\p{Lu}~u', $word)) {
                // There is one upper
                return true;
            }
        }

        return false;
    }

    /**
     * Change case of character to opposite case.
     *
     * @param string $str String to be changed.
     *
     * @return string
     */
    public static function ConvertCase(string $str, $encoding = null)
    {
        if (function_exists('mb_strtolower') && function_exists('mb_strtoupper')) {
            $characters = preg_split('/(?<!^)(?!$)/u', $str);
            foreach ($characters as $key => $character) {
                if (mb_strtolower($character, self::encoding($encoding)) !== $character) {
                    $character = mb_strtolower($character, self::encoding($encoding));
                }
                else {
                    $character = mb_strtoupper($character, self::encoding($encoding));
                }
                $characters[$key] = $character;
            }
            return implode('',$characters);
        }
    }
}
