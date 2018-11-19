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
    private static $msgs = [
    'string'   => 'The :field much be type of string like, mango',
    'required' => 'The :field is required',
    'int'      => 'The :field must be int like, 20, 200',
    'float'    => 'The :name field must be of type float e.g. 20.0',
    'email'    => 'Email address is not valid',
    'ip'       => 'Ip address is not valid',
    'ipv6'     => 'The value must be a valid IPv6 address',
    'alpha'    => 'The value must only contain characters of the alphabet',
    'subnet'         => 'The value must be a valid IPv4 subnet', 
    'validate' => 'Json is invilide',
    'unique'   => 'The :field value already exists, try another',
    ];
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
     * check Whether the any error msg exists
     *
     * @return resource
     */

    public function has()
    {
        return (count(static::$error) > 0) ? true : false;
    }
    /**
     * Get all error msgs
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
        return static::$msgs;
    }
}
