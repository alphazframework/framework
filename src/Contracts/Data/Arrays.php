<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
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
     * Determine array is (sqquential).
     *
     * @param array $array Value to be check.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function isSequential($array);

    /**
     * Determine array is Assoc.
     *
     * @param array $value Value to be check.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function isAssoc(array $array);

    /**
     * Determine array is multi-dimensional.
     *
     * @param array $value Value to be check.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function isMulti(array $array);

    /**
     * Get type of array.
     *
     * @param array $array The array to work on.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function getType(array $array);

    /**
     * Add an element to an array using "dot" notation if it doesn't exist.
     *
     * @param array  $array Array to be evaluated
     * @param string $key   Key
     * @param string $opr   Notation like 'dot'
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function add($array, $key, $value, $opr = null);

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
     * @return array
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
     * @param array $arrays      Arrays.
     * @param bool  $assocOutput Switch to output assoc arrays.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function dot(array $arrays, bool $assocOutput = false);

    /**
     * Converted a multi-dimensional associative array with `operator`.
     *
     * @param array  $arrays      Arrays.
     * @param string $opr         Operator.
     * @param bool   $assocOutput Switch to output assoc arrays.
     * @param string $_key        the previous key of the object
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function multiToAssocWithSpecificOpr(array $arrays, $opr = null, bool $assocOutput = false, string $_key = null);

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
    public static function forget(&$array, $keys, $opr = null);

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
    public static function except($array, $keys);

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
    public static function pull(&$array, $key, $default = null, $opr = null);

    /**
     * Changes the case of all keys in an array.
     *
     * @param array $array The array to work on.
     * @param int   $case  Either CASE_UPPER or CASE_LOWER (default).
     *
     * @since 3.0.0
     *
     * @return array
     */
    public static function arrayChangeCaseKey($array, $case = CASE_LOWER);

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
    public static function arrayChangeCaseValue($array, $case = CASE_LOWER);

    /**
     * Remove duplicate values from array.
     *
     * @param array      $array The array to work on.
     * @param string|int $key   Key that need to evaulate.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function removeDuplicates(array $array, $key);

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
    public static function mostOccurring(array $array, $key = '');

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
    public static function leastOccurring(array $array, $key = '');

    /**
     * Convert the array into a query string.
     *
     * @param array $array The array to work on.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function query($array);

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
    public static function where(array $array, callable $callback);

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
    public static function shuffle(array &$array);

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
    public static function random(array $array, int $i = null);

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
    public static function pluck(array $array, $key);
}
