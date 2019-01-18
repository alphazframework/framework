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
 * @deprecated 3.0.0
 * @license MIT
 */

namespace Zest\Common;

class Server
{
    public static function get()
    {
        $server = static::determineServer();
        $server = explode('/', $server)[0];
        $server = strtolower($server);
        if ($server === 'apache') {
            return;
        } elseif (preg_match('/[php]/i', $server)) {
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
