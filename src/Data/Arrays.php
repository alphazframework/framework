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

class Arrays implements \ArrayAccess
{
    /**
     * Determine array is accessible.
     *
     * @param (mixed) $value Value to be check.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function accessible($value) :bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Determine array is (sqquential).
     *
     * @param (array) $array Value to be check.
     *
     * @since 3.0.0
     *
     * @return bool
     */    
    public static function isSequential($array) :bool
    {
        return is_array($array) && !self::isAssoc($array) && !self::isMulti($array);
    }

    /**
     * Determine array is Assoc.
     *
     * @param (array) $value Value to be check.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function isAssoc(array $array) :bool
    {
        return array_keys($array) !== range(0, count($array) - 1) && !self::isMulti($array);
    }
    /**
     * Determine array is multi-dimensional.
     *
     * @param (array) $value Value to be check.
     *
     * @since 3.0.0
     *
     * @return bool
     */
     public static function isMulti(array $array) :bool
    {
        sort($array, SORT_REGULAR);
        return isset($array[0]) && is_array($array[0]);
    }

    /**
     * Determine array is accessible.
     *
     * @param (mixed) $value Value to be check.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function set(&$array, $key = null, $value = null, $opr = null)
    {
        if (null === $value) {
            return $array;
        }
        if (null === $key) {
            return $array = $value;
        }
        if (null === $opr) {
            return $array[$key] = $value;
        }

        $keys = explode($opr, $key);
        foreach ($keys as $ks => $key) {
            if (!isset($array[$key])) {
                $array = &$array[$key];
            }
        }
        $array = $value;
        return $array;        
    }
    public static function get(&$array, $default, $opr = null)
    {

    }

    /**
     * Determine if an item or items exist in an array using 'Operator' notation.
     *
     * @param (array)       $array Default array
     * @param (aray|string) $keys  Keys to search
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function has($array, $keys)
    {

    }

    /**
     * Determine is given value is realy? array.
     *
     * @param (mixed) $value Value to be checked.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function isRealyArray($value)
    {
        return is_array($value) && !empty($value);
    }

    /**
     * Convert a multi-dimensional array to assoc.
     *
     * @param (array) $array Value to be converted.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function multiToAssoc(array $arrays)
    {
        $results = [];
        foreach ($arrays as $key => $value) {
            if (self::isRealyArray($value) === true) {
                $results = array_merge($results, self::multiToAssoc($value));
            } else {
                $results[$key] = $value;
            }
        }

        return $results;
    }

    /**
     * Converted a multi-dimensional associative array with `dot`.
     *
     * @param (array)  $value   arrays.
     * @param (string) $prepend Prepend value
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function dot(array $arrays, $prepend = '')
    {
        return self::multiToAssocWithSpecificOpr($arrays, $prepend, '.');
    }

    /**
     * Converted a multi-dimensional associative array with `operator`.
     *
     * @param (array)  $value   arrays.
     * @param (string) $prepend Prepend value
     * @param (string) $opr     Operator
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function multiToAssocWithSpecificOpr(array $arrays, $prepend = '', $opr = null)
    {
        $results = [];
        foreach ($arrays as $key => $value) {
            if (self::isRealyArray($value) === true) {
                $results = array_merge($results, self::multiToAssocWithSpecificOpr($value, $prepend.$key. $opr));
            } else {
                $results[$prepend.$key] = $value;
            }
        }

        return $results;
    }

    /**
     * Push an item onto the beginning of an array.
     *
     * @param (mixed) $value Dafult array, where value to append.
     * @param (mixed) $value Value to be append
     * @param (mixed) $key   Key of value if array is assoc or multi-dimensional
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function prepend($array, $value, $key = null)
    {

    }

    /**
     * Push an item onto the end of an array.
     *
     * @param (mixed) $value Dafult array, where value to append.
     * @param (mixed) $value Value to be append
     * @param (mixed) $key   Key of value if array is assoc or multi-dimensional
     *
     * @since 3.0.0
     *
     * @return bool
     */    
    public static function append($array, $value, $key = null)
    {

    }
    public function offsetExists($offset) :bool
    {

    }
    public function offsetGet($offset)
    {

    }

    public function offsetSet($offset, $value) :void
    {

    }
    public function offsetUnset($offset) :void
    {

    }   
}
