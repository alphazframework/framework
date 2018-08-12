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
 * @license MIT
 */

namespace Zest\Auth;

class Error
{
    /*
     * Store the error msgs
    */
    private static $errors = [];

    /**
     * Set the error msg.
     *
     * @param $error , error msg
     *        $key , key of error msg like username (optional)
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
     * @return bool
     */
    public function has()
    {
        return (count(static::$errors) > 0) ? true : false;
    }

    /**
     * Get all the error msgs.
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
     * @param $key , like username (optional)
     *
     * @return array
     */
    public function get($key = null)
    {
        return (isset($key)) ? static::$errors[$key] : static::$errors;
    }
}
