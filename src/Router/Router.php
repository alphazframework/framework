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
 *
 * @note i wrote this file first time by follow the course on udemy  => https://www.udemy.com/php-mvc-from-scratch/ , and other modification by me
 */

namespace Zest\Router;

use Config\Config;
use Zest\Cache\ZestCache\ZestCache;

class Router
{
    /**
     * Associative array of routes (the routing table).
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route.
     *
     * @var array
     */
    protected $params = [];

    /**
     * Add a route to the routing table.
     *
     * @param string $route  The route URL
     * @param array  $params Parameters (controller, action, etc.)
     *
     * @return void
     */
    public function add($route, $params = [])
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^'.$route.'$/i';
        if (is_array($params)) {
            $this->routes[$route] = $params;
        } elseif (is_callable($params)) {
            $this->routes[$route] = ['callable' => $params];
        }
    }

    /**
     * Get all the routes from the routing table.
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     * property if a route is found.
     *
     * @param string $url The route URL
     *
     * @return bool true if a match found, false otherwise
     */
    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Get named capture group values
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;

                return true;
            }
        }

        \Zest\Component\routes::loadComs();
    }

    /**
     * Get the currently matched parameters.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Dispatch the route, creating the controller object and running the
     * action method.
     *
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->RemoveQueryString($url);
        if ($this->match($url)) {
            if (!isset($this->params['callable'])) {
                $controller = $this->params['controller'];
                $controller = $this->convertToStudlyCaps($controller);
                $controller = $this->getNamespace().$controller;

                if (class_exists($controller)) {
                    $controller_object = new $controller($this->params);

                    $action = $this->params['action'];
                    $action = $this->convertToCamelCase($action);
                    if (preg_match('/action$/i', $action) == 0) {
                        $controller_object->$action();
                    } else {
                        throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                    }
                } else {
                    throw new \Exception("Controller class $controller not found");
                }
            } else {
                call_user_func($this->params['callable'], $this->params);
            }
        } else {
            \Zest\Component\routes::loadComs();
        }
    }

    /**
     * Convert the string with hyphens to StudlyCaps,.
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
        return ucwords(str_replace('-', ' ', $string));
    }

    /**
     * Convert the string with hyphens to camelCase,.
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove the query string variables from the URL (if any). As the full.
     *
     * @param string $url The full URL
     *
     * @return string The URL with the query string variables removed
     */
    protected function RemoveQueryString($url)
    {
        if (isset($url) && !empty($url)) {
            $parts = explode('&', $url);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = self::RemoveQueryString($_SERVER['QUERY_STRING']);
            }
        }

        return $url;
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present.
     *
     * @return string The request URL
     */
    protected function getNamespace()
    {
        (!array_key_exists('namespace', $this->params)) ? $namespace = 'App\Controllers\\' : $namespace .= $this->params['namespace'].'\\';

        return $namespace;
    }

    /**
     * Parase the url if need.
     *
     * @return string The request URL
     */
    public function parseurl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    public function loadCache()
    {
        if ($this->isCached() === true) {
            return json_decode(file_get_contents('../Storage/Cache/routers.cache'), true)['data'];
        }
    }

    public function cacheRouters()
    {
        if ($this->isCached() !== true) {
            $routers = $this->getRoutes();
            $cache = new ZestCache();
            $cache->create('routers');
            $cache->store('routers', 'routes', $routers, Config::ROUTE_CACHE_REGENERATE);
            $f = fopen('../Storage/Cache/router_time.cache', 'w');
            fwrite($f, time() + Config::ROUTE_CACHE_REGENERATE);
            fclose($f);
        }
    }

    public function isCached()
    {
        if (file_exists('../Storage/Cache/routers.cache')) {
            return true;
        } else {
            return false;
        }
    }
}
