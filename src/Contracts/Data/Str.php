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

namespace Zest\Contracts\Data;

interface Str
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
    public static function reverse(string $str) :string;

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
    public static function strConcat($g, ...$str);

    /**
     * Count the string.
     *
     * @param string $str String to be counted.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public static function count(string $str);
}
