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

class Success
{
    /*
     * Store the success msgs
    */
    private static $success;

    /**
     * Set the success msgs.
     *
     * @param $success , message
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
     * @return string
     */
    public function get()
    {
        return static::$success;
    }
}
