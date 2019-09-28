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
 * @since 2.0.0
 *
 * @license MIT
 */

namespace Zest\Contracts\Data;


interface Conversion
{
    /**
     * Convert arrays to Object.
     *
     * @param array $array Arrays
     *
     * @since 2.0.0
     *
     * @return object
     */
    public static function arrayToObject($array);

    /**
     * Convert Objects to arrays.
     *
     * @param object $object
     *
     * @since 2.0.0
     *
     * @return array
     */
    public static function objectToArray($object);

    /**
     * Convert the bit into bytes.
     *
     * @param int $size The value that you want provided
     * @param int $pre  Round the value default 2
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function bitToBytes($size, $pre = 2);

    /**
     * Convert the views to relative unit.
     *
     * @param int    $n   Views.
     * @param string $sep Seperator.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function viewToHumanize($n, $sep = ',');

    /**
     * Convert XML to arrays.
     *
     * @param mixed $xml xml
     *
     * @since 2.0.0
     *
     * @return array
     */
    public static function xmlToArray($xml);

    /**
     * Unit conversion.
     *
     * @param int $value   Value to be work on.
     * @param string $base The unit which is given that to be converted.
     * @param string $to   The unit in which it should be converted.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function unit($value, $base, $to);
}
