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

use Zest\Contracts\Data\Arrays as ArraysContract;

class Arrays implements ArraysContract
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
    public static function isReallyArray($value)
    {
        return is_array($value) && !empty($value);
    }

    /**
     * Determine array is (sqquential).
     *
     * @param array $array Value to be check.
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
     * @param array $value Value to be check.
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
     * @param array $value Value to be check.
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
    public static function get($array, $key = null, $default = null, $opr = null)
    {
        if (!self::isReallyArray($array)) {
            return $default;
        }
        if (null === $key) {
            return $array;
        }
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        if (null !== $opr) {

            if (strpos($key, $opr) === false) {
                return $array[$key] ?? $default;
            }

            foreach (explode($opr, $key) as $k) {
                if (self::isReallyArray($array) && array_key_exists($k, $array)) {
                    $array = $array[$k];
                } else {
                    return $default;
                }
            }

            return $array;
        }

        return $default;
    }

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
    public static function has($array, $keys = null, $opr = null)
    {
         if (is_null($keys)) {
            return false;
        }

        $keys = (array) $keys;

        if ($keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $get = self::get($array, $key, null, $opr);
            if (self::isReallyArray($get) || $get === null) {
                return false;
            }
        }

        return true;
    }

    /**
     * Convert a multi-dimensional array to assoc.
     *
     * @param array $array Value to be converted.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function multiToAssoc(array $arrays)
    {
        $results = [];
        foreach ($arrays as $key => $value) {
            if (self::isReallyArray($value) === true) {
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
     * @param array  $value   arrays.
     * @param string $prepend Prepend value
     * @param string $opr     Operator
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function multiToAssocWithSpecificOpr(array $arrays, $prepend = '', $opr = null)
    {
        $results = [];
        foreach ($arrays as $key => $value) {
            if (self::isReallyArray($value) === true) {
                $results = array_merge($results, self::multiToAssocWithSpecificOpr($value, $prepend.$key.$opr));
            } else {
                $results[$prepend.$key] = $value;
            }
        }

        return $results;
    }

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
    public static function prepend($array, $value, $key = null)
    {
        if ($key === null) {
            array_unshift($array, $value);
        } else {
            $array = array_merge([$key => $value], $array);
        }

        return $array;
    }

    /**
     * Push an item onto the end of an array.
     *
     * @param mixed $value Dafult array, where value to append.
     * @param mixed $value Value to be append
     * @param mixed $key   Key of value if array is assoc or multi-dimensional
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function append($array, $value, $key = null)
    {
        return array_merge($array, [$key => $value]);
    }

    /**
     * Get the unique elements from array.
     *
     * @param array $array Array ot evaulated
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function unique($array)
    {
        $results = [];
        if (self::isMulti($array)) {
            $array = self::multiToAssoc($array);
            foreach ($array as $key => $value) {
                $results[] = $value;
            }
            return array_unique($array);
        } 

        return array_unique($array);
        
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param array $array Array to be evaulated.
     * @param mixed $keys  Keys
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function subSetOfArray(array $array, $keys)
    {
    }

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
    public static function forget(&$array, $keys)
    {

    }

    /**
     * Get all of the given array except for a specified array of keys.
     *
     * @param  array        $array Default array.
     * @param  array|string $keys  Keys
     *
     * @since 3.0.0
     *     
     * @return array
     */
    public static function except($array, $keys)
    {

    }
}
