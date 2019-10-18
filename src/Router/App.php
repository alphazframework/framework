<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 2.0.0
 *
 * @license MIT
 */

namespace Zest\Router;

use Zest\Cache\Cache;
use Zest\http\Request;

class App extends Router
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
                $router->dispatch(new Request());
            } else {
                $router->routes = $router->loadCache();
                $router->dispatch(new Request());
            }
        } else {
            require_once $routeFile;
            $router->cacheRouters();
            $router->dispatch(new Request());
        }
    }
}
