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

namespace Softhub99\Zest_Framework\Cookies;

class Cookies
{
    private static $name; // name of cookie
    private static $value; // value of cookie
    private static $expire; // expire of cookie
    private static $domain; // domain of cookie
    private static $path; // path of cookie
    private static $secure; // secure of cookie
    private static $httponly; // httponly of cookie

    /**
     * __Construct set the default values.
     *
     * @return void
     */
    public function __construct()
    {
        static::$expire = 0;
        static::$domain = 'localhost';
        static::$path = '/';
        static::$secure = true;
        static::$httponly = false;
    }

    /**
     * Set the cookie value.
     *
     * @param
     * $name of cookie
     * $value of cookie
     * $expire of cookie
     * $domain of cookie
     * $secure of cookie
     * $httponly of cookie
     *
     * @return bool
     */
    public static function set($params)
    {
        if (is_array($params)) {
            if (preg_match("/[=,; \t\r\n\013\014]/", $params['name'])) {
                static::$name = rand(1, 25);
            } else {
                static::$name = $params['name'];
            }
            if ($params['expire'] instanceof \DateTime) {
                $expire = $expire->format('U');
            } elseif (!is_numeric($params['expire'])) {
                $expire = strtotime($params['expire']);
            } else {
                static::$expire = $params['expire'];
            }
            static::$value = $params['value'];
            static::$domain = $params['domain'];
            static::$path = empty($path) ? '/' : $params['path'];
            static::$secure = (bool) $params['secure'];
            static::$httponly = (bool) $params['httponly'];

            return static::setCookie();
        } else {
            return false;
        }
    }

    /**
     * Set the cookie value.
     *
     * @return bool
     */
    public static function setCookie()
    {
        if (!empty(static::$name) && !empty(static::$value) && !empty(static::$expire) && !empty(static::$path) && !empty(static::$domain) && is_bool(static::$secure) && is_bool(static::$httponly)) {
            if (static::isCookie(static::$name) === false) {
                setcookie(static::$name, static::$value, static::$expire, static::$path, static::$domain, static::$secure, static::$httponly);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Check if cookie set or not.
     *
     * @param  $name of cookie
     *
     * @return bool
     */
    public static function isCookie($name)
    {
        if (isset($name) && !empty($name)) {
            if (isset($_COOKIE[$name])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get the cookie value.
     *
     * @param  $name of cookie
     *
     * @return string | boolean
     */
    public static function get($name)
    {
        if (isset($name) && !empty($name)) {
            if (static::isCookie($name)) {
                return $_COOKIE[$name];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Delete the cookie.
     *
     * @param  $name of cookie
     *
     * @return bool
     */
    public static function delete($name)
    {
        if (isset($name) && !empty($name)) {
            if (static::isCookie($name)) {
                static::$name = $name;
                static::$value = self::get($name);
                setcookie(static::$name, static::$value, time() - 3600000, static::$path, $_SERVER['SERVER_NAME']);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
