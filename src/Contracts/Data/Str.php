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
     * @param string $str      String to be evaluated.
     * @param string $encoding Valid encoding.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function reverse(string $str, $encoding = null): string;

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
    public static function concat($g, ...$str);

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
    public static function count(string $str, $encoding = null);
}
