<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Auth;

class Error
{
    /**
     * Store the error msgs.
     *
     * @since 2.0.3
     *
     * @var array
     */
    private static $errors = [];

    /**
     * Set the error msg.
     *
     * @param (string)          $error error msg
     * @param (string) optional $key   key of error msg like username
     *
     * @since 2.0.3
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
     * @since 2.0.3
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
     * @since 2.0.3
     *
     * @return array
     */
    public function all()
    {
        return static::$errors;
    }

    /**
     * Get the error msgs.
     *
     * @param (string) optional $key like username
     *
     * @since 2.0.3
     *
     * @return array
     */
    public function get($key = null)
    {
        return (isset($key)) ? static::$errors[$key] : static::$errors;
    }
}
