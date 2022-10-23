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
 *
 * @license MIT
 */

namespace alphaz\Validation;

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
            'string'         => __printl('string:validation'),
            'required'       => __printl('required:validation'),
            'int'            => __printl('int:validation'),
            'float'          => __printl('float:validation'),
            'email'          => __printl('email:validation'),
            'ip'             => __printl('ip:validation'),
            'ipv6'           => __printl('ipv6:validation'),
            'alpha'          => __printl('alpha:validation'),
            'subnet'         => __printl('subnet:validation'),
            'validate'       => __printl('validate:validation'),
            'unique'         => __printl('unique:validation'),
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
    public static function has()
    {
        return (count(static::$error) > 0) ? true : false;
    }

    /**
     * Get all error msgs.
     *
     * @return resource
     */
    public static function all()
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
    public static function getMsgs()
    {
        self::pushMsgs();

        return static::$msgs;
    }
}
