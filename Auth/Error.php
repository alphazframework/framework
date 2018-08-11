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

namespace Softhub99\Zest_Framework\Auth;

class Error
{
    private static $errors = [];

    public static function set($error, $key = null)
    {
        if (isset($key)) {
            static::$errors[$key] = $error;
        } else {
            static::$errors = $error;
        }
    }

    public function has()
    {
        return (count(static::$errors) > 0) ? true : false;
    }

    public function all()
    {
        return static::$errors;
    }

    public function get($key = null)
    {
        return (isset($key)) ? static::$errors[$key] : static::$errors;
    }
}
