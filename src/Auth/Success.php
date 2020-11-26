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
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Auth;

class Success
{
    /**
     * Store the success msgs.
     *
     * @since 2.0.3
     *
     * @var mixed
     */
    private static $success;

    /**
     * Set the success msgs.
     *
     * @param (string) $success message
     *
     * @since 2.0.3
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
     * @since 2.0.3
     *
     * @return string
     */
    public function get()
    {
        return static::$success;
    }
}
