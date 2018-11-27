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

namespace Zest\Validation;

class Handler
{
    /*
     * Errors
    */
    private static $error = [];
    /*
     * Msgs
    */
    private static $msgs = [];

    /**
     * Push the messages.
     *
     * @return void
     */
    public static function pushMsgs()
    {
        static::$msgs = [
            'string'         => printl('string:validation'),
            'required'       => printl('required:validation'),
            'int'            => printl('int:validation'),
            'float'          => printl('float:validation'),
            'email'          => printl('email:validation'),
            'ip'             => printl('ip:validation'),
            'ipv6'           => printl('ipv6:validation'),
            'alpha'          => printl('alpha:validation'),
            'subnet'         => printl('subnet:validation'),
            'validate'       => printl('validate:validation'),
            'unique'         => printl('unique:validation'),
            ];
    }
    /**
     * Set the error msg.
     *
     * @param $error the error msg
     *        $key key of error msg
     *
     * @return void
     */
    public static function set($error, $key = null)
    {
        if (isset($key)) {
            static::$error[$key][] = $error;
        } else {
            static::$error[] = $error;
        }
    }

    /**
     * check Whether the any error msg exists.
     *
     * @return resource
     */
    public function has()
    {
        return (count(static::$error) > 0) ? true : false;
    }

    /**
     * Get all error msgs.
     *
     * @return resource
     */
    public function all()
    {
        return static::$error;
    }

    /**
     * Get the error msg.
     *
     * @param $key key of error msg
     *
     * @return resource
     */
    public function get($key = null)
    {
        return (isset($key)) ? static::$error[$key] : static::$error;
    }

    /**
     * Get the msgs.
     *
     * @return resource
     */
    public function getMsgs()
    {
        self::pushMsgs();
        return static::$msgs;
    }
}
