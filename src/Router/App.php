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

namespace alphaz\Router;

use alphaz\Cache\Cache;

class App extends Router
{
    /**
     * Run the alphaz Framework.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function run()
    {
        $router = new Router();
        $cache = new Cache('file');
        if (file_exists('../Routes/Routes.php')) {
            $routeFile = '../Routes/Routes.php';
        } elseif (file_exists('Routes/Routes.php')) {
            $routeFile = 'Routes/Routes.php';
        } else {
            throw new \Exception('Error while loading Route.php file', 500);
        }
        if (__config('app.router_cache') === true) {
            if (!$cache->has('router')) {
                require_once $routeFile;
                $router->cacheRouters();
            } else {
                $router->routes = $router->loadCache();
            }
        } else {
            require_once $routeFile;
        }

        return $router;
    }
}
