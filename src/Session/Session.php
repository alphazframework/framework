<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\Session;

class Session
{
    /**
     * __Construct.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct()
    {
        static::sessionPath();
        static::start();
    }

    /**
     * Start the session if not already start.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function start()
    {
        (session_status() === PHP_SESSION_NONE) ? session_start() : null;
    }

    /**
     * Change session path.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public static function sessionPath()
    {
        ini_set('session.save_path', session_path());
    }

    /**
     * Check if session is already set with specific name.
     *
     * @param (string) $name name of session e.g users
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function has($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Get the session value by providing session name.
     *
     * @param (string) $name    name of session e.g users
     * @param (mixed)  $default default value if sesion is not exists
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function get($name, $default = null)
    {
        return (self::has($name)) ? $_SESSION[$name] : $default;
    }

    /**
     * Set/store value in session.
     *
     * @param (string) $name  name of session e.g users
     * @param (string) $value value store in session e.g user token
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function set($name, $value)
    {
        return (self::has($name) !== true) ? $_SESSION[$name] = $value : false;
    }

    /**
     * Set/store multiple values in session.
     *
     * @param (array) $values keys and values
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setMultiple($values)
    {
        foreach ($values as $value) {
            self::set($value['key'], $value['value'], $ttl);
        }

        return self;
    }

    /**
     * Get multiple values in session.
     *
     * @param (array) $keys    keys
     * @param (mixed) $default default value if sesion is not exists
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getMultiple($keys)
    {
        $value = [];
        foreach ($keys as $key) {
            $value[$key] = self::get($key);
        }

        return $value;
    }

    /**
     * Delete/unset the session.
     *
     * @param (string) $name name of session e.g users
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function delete(string $name)
    {
        if (self::has($name)) {
            unset($_SESSION[$name]);
        }

        return false;
    }

    /**
     * Delete multiple values in session.
     *
     * @param (array) $keys keys
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            self::delete($key);
        }
    }

    /**
     * Destroy the session.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public static function destroy()
    {
        session_unset();
        session_destroy();
    }
}
