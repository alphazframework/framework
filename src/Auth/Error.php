<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 1.0.0
 *
 * @license MIT
 */

namespace alphaz\Auth;

class Error
{
    /**
     * Store the error msgs.
     *
     * @since 1.0.0
     *
     * @var array
     */
    private static $errors = [];

    /**
     * Set the error msg.
     *
     * @param (string) $error error msg
     * @param (string) optional $key   key of error msg like username
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function set($error, $key = null)
    {
        if (isset($key)) {
            static::$errors[$key] = $error;
        } else {
            static::$errors = $error;
        }
    }

    /**
     * Check if the error has or not.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function has()
    {
        return (count(static::$errors) > 0) ? true : false;
    }

    /**
     * Get all the error msgs.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public static function all()
    {
        return static::$errors;
    }

    /**
     * Get the error msgs.
     *
     * @param (string) optional $key like username
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get($key = null)
    {
        return (isset($key)) ? static::$errors[$key] : static::$errors;
    }
}
