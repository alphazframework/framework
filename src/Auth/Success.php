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

class Success
{
    /**
     * Store the success msgs.
     *
     * @since 1.0.0
     *
     * @var mixed
     */
    private static $success;

    /**
     * Set the success msgs.
     *
     * @param (string) $success message
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function set($success)
    {
        static::$success = $success;
    }

    /**
     * Get the success message.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get()
    {
        return static::$success;
    }
}
