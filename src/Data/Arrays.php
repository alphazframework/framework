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
        return is_array($value) && count($value) !== 0;
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
     * Get type of array.
     *
     * @param array $array The array to work on.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function getType(array $array)
    {
        if (self::isReallyArray($array)) {
            if (self::isSequential($array)) {
                $type = 'indexes';
            } elseif (self::isAssoc($array)) {
                $type = 'assoc';
            } elseif (self::isMulti($array)) {
                $type = 'multi';
            }

            return isset($type) ? $type : false;
        }

        throw new \InvalidArgumentException('The given array should not be empty', 500);
    }

    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param array  $array Array to be evaluated
     * @param string $key   Key
     * @param string $opr   Notation like 'dot'
     * @param
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function add($array, $key, $value, $opr = null)
    {
        if (!self::has($array, $key, $opr)) {
            self::set($array, $key, $value, $opr);
        }

        return $array;
    }

    /**
     * Set an array item to a given value using "operator" notation.
     *
     * @param array  $array Array to be evaluated.
     * @param string $key   Key
     * @param mixed  $value Value
     * @param string $opr   Notation like 'dot'
     *
     * @since 3.0.0
     *
     * @return array
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
        foreach ($keys as $key) {
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
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
     * @return array
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
        $keys = (array) $keys;

        if (count($keys) === 0) {
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
     * @param array $arrays Arrays.
     * @param bool  $assocOutput Switch to output assoc arrays.
     * 
     * @since 3.0.0
     *
     * @return array
     */
    public static function dot(array $arrays, bool $assocOutput = false)
    {
        return self::multiToAssocWithSpecificOpr($arrays, '.', $assocOutput);
    }
    /**
     * Converted a multi-dimensional associative array with `operator`.
     *
     * @param array  $arrays Arrays.
     * @param string $opr    Operator.
     * @param bool  $assocOutput Switch to output assoc arrays.
     * @param string $_key the previous key of the object
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function multiToAssocWithSpecificOpr(array $arrays, $opr = null, bool $assocOutput = false, string $_key = null)
    {
        $results = [];
        foreach ($arrays as $key => $value) {
            $key = ($assocOutput === true ? $_key . $key : $key);
            if (self::isReallyArray($value) === true) {
                $assocKey = ($assocOutput === true ? $opr : $key.$opr);
                $results = array_merge(
                    $results,
                    self::multiToAssocWithSpecificOpr(
                        $value,
                        $assocKey,
                        $assocOutput,
                        $key . $opr
                    )
                );
            } elseif ($assocOutput === true) {
                // gets pull off the last dot that is added
                $_key = preg_replace('/(\.$)/', '', $_key);
                $results[$_key][] = $value;
            } else {
                $key = $opr.$key;
                $key = ($key[0] === '.' || $key[0] === '@' ? substr($key, 1) : $key);
                $results[$key] = $value;
            }
        }

        return $results;
    }

    /**
     * Push an item onto the beginning of an array.
     *
     * @param array $array Dafult array.
     * @param mixed $value Value to be append.
     * @param mixed $key   Key.
     *
     * @since 3.0.0
     *
     * @return array
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
     * @param array $array Dafult array, where value to append.
     * @param mixed $value Value to be append.
     * @param mixed $key   Key.
     *
     * @since 3.0.0
     *
     * @return array
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
    public static function subSetOfArray(array $array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * Remove one or many array items from a given array using "operator" notation.
     *
     * @param array        $array Array to be evaluated.
     * @param array|string $keys  Keys.
     *
     * Note: Adapted from laravel\framework.
     *
     * @see https://github.com/laravel/framework/blob/5.8/LICENSE.md
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function forget(&$array, $keys, $opr = null)
    {
        $original = &$array;

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return false;
        }
        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if (array_key_exists($key, $array)) {
                unset($array[$key]);
                continue;
            }

            if (null !== $opr) {
                $parts = explode($opr, $key);

                // clean up before each pass
                $array = &$original;

                while (count($parts) > 1) {
                    $part = array_shift($parts);

                    if (isset($array[$part]) && is_array($array[$part])) {
                        $array = &$array[$part];
                    } else {
                        continue 2;
                    }
                }

                unset($array[array_shift($parts)]);
            }
        }
    }

    /**
     * Get all of the given array except for a specified array of keys.
     *
     * @param array        $array Default array.
     * @param array|string $keys  Keys
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function except($array, $keys)
    {
        self::forget($array, $keys);

        return $array;
    }

    /**
     * Get a value from the array, and remove it.
     *
     * @param array  $array   Default Array.
     * @param string $key     Keys
     * @param mixed  $default Default value
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function pull(&$array, $key, $default = null, $opr = null)
    {
        $value = self::get($array, $key, $default, $opr);
        self::forget($array, $key);

        return $value;
    }

    /**
     * Changes the case of all keys in an array.
     *
     * @param array  $array The array to work on.
     * @param string $case  Either CASE_UPPER or CASE_LOWER (default).
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function arrayChangeCaseKey($array, $case = CASE_LOWER)
    {
        return array_map(function ($item) use ($case) {
            if (is_array($item)) {
                $item = self::arrayChangeCaseKey($item, $case);
            }

            return $item;
        }, array_change_key_case($array, $case));
    }

    /**
     * Changes the case of all values in an array.
     *
     * @param array  $array The array to work on.
     * @param string $case  Either CASE_UPPER or CASE_LOWER (default).
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function arrayChangeCaseValue($array, $case = CASE_LOWER)
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (self::isReallyArray($value)) {
                $array[$key] = array_merge($results, self::arrayChangeCaseValue($value, $case));
            } else {
                $array[$key] = ($case == CASE_UPPER) ? strtoupper($array[$key]) : strtolower($array[$key]);
            }
        }

        return $array;
    }

    /**
     * Remove duplicate values from array.
     *
     * @param array      $array The array to work on.
     * @param string|int $key   Key that need to evaulate.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function removeDuplicates(array $array, $key = '')
    {
        if (!self::isReallyArray($array)) {
            return false;
        }
        if (self::isSequential($array) || self::isAssoc($array)) {
            return array_unique($array);
        }
        if (self::isMulti($array) && empty($key)) {
            return false;
        }
        $dataSet = [];
        $i = 0;
        $keys = [];
        foreach ($array as $k) {
            if (in_array($k[$key], $keys)) {
                continue;
            } else {
                $keys[$i] = $k[$key];
                $dataSet[$i] = $k;
            }

            $i++;
        }

        return $dataSet;
    }

    /**
     * Get the most|least occurring value from array.
     *
     * @param string     $type  The type most|least
     * @param array      $array The array to work on.
     * @param string|int $key   Key that need to evaulate.
     *
     * @since 3.0.0
     *
     * @return array
     */
    private static function mostOrLeastOccurring(string $type, array $array, $key = '')
    {
        $occurring = [];

        if (self::isAssoc($array) || self::isMulti($array)) {
            $values = array_count_values(array_column($array, $key));
        } else {
            $values = array_count_values($array);
        }

        $tmp = $type === 'most' ? current($values) : current($values);
        unset($values[$tmp]);
        foreach ($values as $key => $value) {
            if ($type === 'most') {
                if ($tmp <= $value) {
                    $tmp = $key;
                    $occurring[] = $key;
                }
            } elseif ($type === 'least') {
                if ($tmp > $value) {
                    $tmp = $key;
                    $occurring[] = $key;
                }
            }
        }

        return $occurring;
    }

    /**
     * Get the most occurring value from array.
     *
     * @param array      $array The array to work on.
     * @param string|int $key   Key that need to evaulate.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function mostOccurring(array $array, $key = '')
    {
        return self::mostOrLeastOccurring('most', $array, $key);
    }

    /**
     * Get the least occurring value from array.
     *
     * @param array      $array The array to work on.
     * @param string|int $key   Key that need to evaulate.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function leastOccurring(array $array, $key = '')
    {
        return self::mostOrLeastOccurring('least', $array, $key);
    }

    /**
     * Convert the array into a query string.
     *
     * @param array $array The array to work on.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function query($array)
    {
        return http_build_query($array, null, '&', PHP_QUERY_RFC3986);
    }

    /**
     * Filter the array using the given callback.
     *
     * @param array    $array    The array to work on.
     * @param callable $callback Callback function.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function where(array $array, callable $callback)
    {
        return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Shuffle the given array for associative arrays, preserves key=>value pairs.
     * THIS METION WILL NOT WORKS WITH MULTIDIMESSIONAL ARRAY.
     *
     * @param array $array The array to work on.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function shuffle(array &$array)
    {
        $dataSet = [];

        $keys = array_keys($array);

        shuffle($keys);

        foreach ($keys as $key) {
            $dataSet[$key] = $array[$key];
        }

        $array = $dataSet;

        return true;
    }

    /**
     * Get one or a specified number of random values from an array.
     *
     * @param array    $array The array to work on.
     * @param int|null $i     Specifies how many entries should be picked.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function random(array $array, int $i = null)
    {
        (int) $i = $i ?? 1;
        $countElement = count($array);

        if ($countElement < $i) {
            throw new \OutOfBoundsException("You requested {$i} items, but there are only {$countElement} items available.", 500);
        }
        if ($i === 0) {
            throw new \OutOfBoundsException('Second argument has to be between 1 and the number of elements in the array', 500);
        }

        $keys = array_rand($array, $i);
        $dataSet = [];

        foreach ((array) $keys as $key) {
            $dataSet[] = $array[$key];
        }

        return $dataSet;
    }

    /**
     * Get multiple values of same keys from multi-dimessional array.
     *
     * @param array $array The array to work on.
     * @param mixed $key   The specific key to search/get values.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function pluck(array $array, $key)
    {
        if (self::isMulti($array)) {
            $dataSet = [];
            array_walk_recursive($array, function ($value, $k) use (&$dataSet, $key) {
                if ($k == $key) {
                    $dataSet[] = $value;
                }
            });

            return $dataSet;
        }

        throw new \InvalidArgumentException('The array given should be multi-dimensional array, '.self::getType($array).' given', 500);
    }
}
