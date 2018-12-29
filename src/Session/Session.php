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
        $path = \Config\Config::Session_Path;
        ini_set('session.save_path', $path);
    }

    /**
     *Check if session is already set with specific name.
     *
     * @param $name (string) name of session e.g users
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function isSession(string $name):bool
    {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Get the session value by providing session name.
     *
     * @param $name (string) name of session e.g users
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function getValue(string $name)
    {
        return (static::isSession($name)) ? $_SESSION[$name] : false;
    }

    /**
     * Set/store value in session.
     *
     * @param $params (array)
     * 'name' => name of session e.g users
     * 'value' => value store in session e.g user token
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function setValue(string $name, $value)
    {
        return (static::isSession($name) !== true) ? $_SESSION[$name] = $value : false;
    }

    /**
     * Delete/unset the session.
     *
     * @param $name (string) name of session e.g users
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function unsetValue(string $name)
    {
        if (static::isSession($name)) {
            session_destroy();
            session_unset($name);
        }

        return false;
    }
}
