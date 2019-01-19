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

use Zest\Cache\Cache;

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
        $cache = new Cache();
        if (__config()->config->router_cache === true) {
            if (!$cache->has('router')) {
                require_once '../Routes/Routes.php';
                $router->cacheRouters();
            } else {
                $router->routes = $router->loadCache();
                $router->dispatch($this->getRequestInstance()->getQueryString());
            }
        } else {
            require_once '../Routes/Routes.php';
        }
    }
}
