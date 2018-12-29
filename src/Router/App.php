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
 * @since 2.0.0
 *
 * @license MIT
 */

namespace Zest\Router;

class App extends \Zest\Router\Router
{

     /**
     * Run the Zest Framework.
     *
     * @since 2.0.0
     *
     * @return bool
     */   
    public function run()
    {
        $router = new Router();
        if (\Config\Config::ROUTER_CACHE) {
            if ($this->isExpired()) {
                $this->delete();
                require_once '../Routes/Routes.php';
            } else {
                $router->routes = $router->loadCache();
                $router->dispatch($_SERVER['QUERY_STRING']);
            }
        } else {
            require_once '../Routes/Routes.php';
        }
    }

    /**
     * Determine whether the cache expired.
     *
     * @since 2.0.0
     *
     * @return bool
     */
    public function isExpired()
    {
        $f = fopen('../Storage/Cache/router_time.cache', 'r');
        $expire = fread($f, filesize('../Storage/Cache/router_time.cache'));
        fclose($f);
        if ($expire <= time()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete the cached.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function delete()
    {
        unlink('../Storage/Cache/routers.cache');
        unlink('../Storage/Cache/router_time.cache');
    }
}
