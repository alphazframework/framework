<?php

namespace Zest\Validation;

class Handler
{
    private static $error = [];
    private static $msgs = [
    'string'   => 'The :field much be type of string like, mango',
    'required' => 'The :field is required',
    'min'      => 'The :field must be minimum of :rule characters',
    'max'      => 'The :name field must be  maximum of :rule characters',
    'int'      => 'The :field must be int like, 20, 200',
    'float'    => 'The :name field must be of type float e.g. 20.0',
    'email'    => 'Email address is not valid',
    'ip'       => 'Ip address is not valid',
    'validate' => 'Json is invilide',
    'unique'   => 'The :field value already exists, try another',
    ];

    public static function set($error, $key = null)
    {
        if (isset($key)) {
            static::$error[$key][] = $error;
        } else {
            static::$error[] = $error;
        }
    }

    public function has()
    {
        return (count(static::$error) > 0) ? true : false;
    }

    public function all()
    {
        return static::$error;
    }

    public function get($key = null)
    {
        return (isset($key)) ? static::$error[$key] : static::$error;
    }

    public function getMsgs()
    {
        return static::$msgs;
    }
}
