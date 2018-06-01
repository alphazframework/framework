<?php

namespace Softhub99\Zest_Framework\Common;

use Softhub99\Zest_Framework\Str\Str;

class Server
{
    public static function get()
    {
        $server = static::determineServer();
        $server = explode('/', $server)[0];
        $server = Str::stringConversion($server, 'lowercase');
        if ($server === 'apache') {
            return;
        } elseif ($server === 'nginx') {
            throw new \Exception("You need more configuration in your {$server} server", 404);
        } else {
            throw new \Exception("Sorry {$server} server not supported", 404);
        }
    }

    public static function determineServer()
    {
        return $_SERVER['SERVER_SOFTWARE'];
    }
}
