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
    public static function accessible($value) :bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }
    public static function isSequential($array) :bool
    {
        return is_array($array) && !self::isAssoc($array) && !self::isMulti($array);
    }
    public static function isAssoc(array $array) :bool
    {
        return array_keys($array) !== range(0, count($array) - 1) && !self::isMulti($array);
    }
     public static function isMulti(array $array) :bool
    {
        sort($array, SORT_REGULAR);
        return isset($array[0]) && is_array($array[0]);
    }   
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
    public static function has($array, $keys)
    {

    }
    public static function isRealyArray($value)
    {
        return is_array($value) && !empty($value);
    }
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
    public static function dot(array $arrays, $prepend = '')
    {
        return self::multiToAssocWithSpecificOpr($arrays, $prepend, '.');
    }
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
    public static function prepend()
    {

    }
    public static function append()
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
