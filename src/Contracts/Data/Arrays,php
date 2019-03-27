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

interface Arrays
{
    /**
     * Determine is given value is really, array?.
     *
     * @param mixed $value Value to be checked.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function isReallyArray($value);
    /**
     * Set an array item to a given value using "operator" notation.
     *
     * @param  array   $array  Array to be evaluated.
     * @param  string  $key    Key
     * @param  mixed   $value  Value
     * @param string   $opr    Notation like 'dot'
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function set(&$array, $key = null, $value = null, $opr = null);

    /**
     * Get an item from an array using "operator" notation.
     *
     * @param array        $array Default array.
     * @param array|string $keys  Keys to search.
     * @param string       $opr   Operator notaiton.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function get($array, $key = null, $default = null, $opr = null);

    /**
     * Determine if an item or items exist in an array using 'Operator' notation.
     *
     * @param array        $array Default array.
     * @param array|string $keys  Keys to search.
     * @param string       $opr   Operator notaiton.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function has($array, $keys = null, $opr = null);

    /**
     * Converted a multi-dimensional associative array with `dot`.
     *
     * @param array $arrays Arrays.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function dot(array $arrays);

    /**
     * Converted a multi-dimensional associative array with `operator`.
     *
     * @param array  $arrays Arrays.
     * @param string $opr    Operator
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function multiToAssocWithSpecificOpr(array $arrays, $opr = null);

    /**
     * Push an item onto the beginning of an array.
     *
     * @param mixed $value Dafult array, where value to append.
     * @param mixed $value Value to be append
     * @param mixed $key   Key of value if array is assoc or multi-dimensional
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function prepend($array, $value, $key = null);

    /**
     * Get the unique elements from array.
     *
     * @param array $array Array ot evaulated
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function unique($array);

    /**
     * Remove one or many array items from a given array using "operator" notation.
     *
     * @param  array        $array Array to be evaluated
     * @param  array|string $keys Keys
     *
     * @since 3.0.0
     *
     * @return void
     */
    public static function forget(&$array, $keys);
}
