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
 * @since 1.0.0
 *
 * @license MIT
 *
 * @note i wrote this file first time by following the course on udemy  => https://www.udemy.com/php-mvc-from-scratch/ , any further/others modification by me
 */

namespace Zest\Router;

use Config\Config;
use Zest\Cache\ZestCache\ZestCache;
use Zest\http\Request;
use Zest\http\Response;

class Router
{
    /**
     * Associative array of routes (the routing table).
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $params = [];

    /**
     * Parameters from the matched route.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $request;

    /**
     * __construct.
     *
     * @since 3.0.0
     */
    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * Get the HTTP Request instance.
     *
     * @since 3.0.0
     */
    public function getRequestInstance()
    {
        return $this->request;
    }

    /**
     * Add a route to the routing table.
     *
     * @param string       $route      The route URL
     * @param array|string $params     Parameters (controller, action, etc.) or $params Home@index
     * @param string       $methods    request method like GET or GET|POST
     * @param string       $middleware Middleare name
     * @param closure      $callback   for protection of page if closure function will return ture then route will be dispached.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function add($route, $params = '', $methods = 'GET|HEAD', $middleware = '', \closure $callback = null)
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);
        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        // Add start and end delimiters, and case insensitive flag
        $route = '/^'.$route.'$/i';
        //Check if callback is'nt set set default return value to true
        if ($callback === null) {
            $callback = (function () {
                return true;
            });
        }
        //If array
        if (is_array($params)) {
            $methodArray = ['method' => $methods];
            $params = array_merge($params, $methodArray);
            $call = ['callBack' => $callback];
            $params = array_merge($params, $call);
            $this->routes[$route] = $params;
        } elseif (is_string($params)) { 
            //If string
            $param = [];
            $parts = explode('@', $params);
            $param['controller'] = $parts[0];
            $param['action'] = $parts[1];
            $param['method'] = $methods;
            $param['callBack'] = $callback;
            if (isset($parts[2])) {
                $param['namespace'] = $parts[2];
            }
            //If middleware is set then used
            (!empty($middleware)) ? $param['middleware'] = $this->addMiddleware($middleware) : $param;
            $this->routes[$route] = $param;
        } elseif (is_callable($params)) {
            (!empty($middleware)) ? $this->routes[$route] = ['callable' => $params, 'method' => $methods, 'middleware' => $this->addMiddleware($middleware)] : $this->routes[$route] = ['callable' => $params, 'method' => $methods];
        } else {
            throw new \Exception('Wrong agruments given', 500);
        }
    }

    /**
     * Add the middleware.
     *
     * @param (string) $name name of middleware
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function addMiddleware($name)
    {
        $namespace = "App\Middleware\\";
        $middleware = $namespace.$name;
        $middleware_object = new $middleware();
        if (class_exists($middleware)) {
            if (method_exists($middleware_object, 'before') && method_exists($middleware_object, 'after')) {
                return $middleware_object;
            } else {
                throw new \Exception('Middleware methods before and after not exists', 500);
            }
        } else {
            throw new \Exception("Middleware Class {$middleware} not found", 500);
        }
    }

    /**
     * Add multiple routes at once from array in the following format:.
     *
     * @param $routes = [route,param,method,callback]
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function addRoutes($routes)
    {
        if (!is_array($routes) && !$routes instanceof Traversable) {
            throw new \Exception('Routes should be an array or an instance of Traversable');
        }
        foreach ($routes as $route) {
            call_user_func_array([$this, 'add'], $route);
        }
    }

    /**
     * Add a route to the routing table as POST.
     *
     * @param string       $route      The route URL
     * @param array|string $params     Parameters (controller, action, etc.) or $params Home@index
     * @param string       $middleware Middleare name
     * @param closure      $callback   for protection of page if closure function will return ture then route will be dispached.     *
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function post($route, $params, $middleware = '', $callback = null)
    {
        $this->add($route, $params, 'POST', $middleware, $callback);
    }

    /**
     * Add a route to the routing table as GET.
     *
     * @param string       $route      The route URL
     * @param array|string $params     Parameters (controller, action, etc.) or $params Home@index
     * @param string       $middleware Middleare name
     * @param closure      $callback   for protection of page if closure function will return ture then route will be dispached.     *
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function get($route, $params, $middleware = '', $callback = null)
    {
        $this->add($route, $params, 'GET|HEAD', $middleware, $callback);
    }

    /**
     * Add a route to the routing table as PUT.
     *
     * @param string       $route      The route URL
     * @param array|string $params     Parameters (controller, action, etc.) or $params Home@index
     * @param string       $middleware Middleare name
     * @param closure      $callback   for protection of page if closure function will return ture then route will be dispached.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function put($route, $params, $middleare = '', $callback = null)
    {
        $this->add($route, $params, 'PUT', $middleware, $callback);
    }

    /**
     * Add a route to the routing table as PATCH.
     *
     * @param string       $route      The route URL
     * @param array|string $params     Parameters (controller, action, etc.) or $params Home@index
     * @param string       $middleware Middleare name
     * @param closure      $callback   for protection of page if closure function will return ture then route will be dispached.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function patch($route, $params, $middleware = '', $callback = null)
    {
        $this->add($route, $params, 'PATCH', $middleware, $callback);
    }

    /**
     * Add a route to the routing table as DELETE.
     *
     * @param string       $route      The route URL
     * @param array|string $params     Parameters (controller, action, etc.) or $params Home@index
     * @param string       $middleware Middleare name
     * @param closure      $callback   for protection of page if closure function will return ture then route will be dispached.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function delete($route, $params, $middleware = '', $callback = null)
    {
        $this->add($route, $params, 'DELETE', $middleware, $callback);
    }

    /**
     * Add a route to the routing table as OPTIONS.
     *
     * @param string       $route      The route URL
     * @param array|string $params     Parameters (controller, action, etc.) or $params Home@index
     * @param string       $middleware Middleare name
     * @param closure      $callback   for protection of page if closure function will return ture then route will be dispached.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function options($route, $params, $middleware = '', $callback = null)
    {
        $this->add($route, $params, 'OPTIONS', $middleware, $callback);
    }

    /**
     * Add a route to the routing table as TRACE.
     *
     * @param string       $route      The route URL
     * @param array|string $params     Parameters (controller, action, etc.) or $params Home@index
     * @param string       $middleware Middleare name
     * @param closure      $callback   for protection of page if closure function will return ture then route will be dispached.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function trace($route, $params, $middleware = '', $callback = null)
    {
        $this->add($route, $params, 'TRACE', $middleware, $callback);
    }

    /**
     * Add a route to the routing table as CONNECT.
     *
     * @param string       $route      The route URL
     * @param array|string $params     Parameters (controller, action, etc.) or $params Home@index
     * @param string       $middleware Middleare name
     * @param closure      $callback   for protection of page if closure function will return ture then route will be dispached.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function connect($route, $params, $middleware = '', $callback = null)
    {
        $this->add($route, $params, 'CONNECT', $middleware, $callback);
    }

    /**
     * Get all the routes from the routing table.
     *
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @return bool true if a match found, false otherwise
     */
    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                //Check if given method is matched
                if ($this->methodMatch($params['method'])) {
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
        }
    }

    /**
     * Match the request methods.
     *
     * @param string $methods       router request method
     * @param string $requestMethod Requested method
     *
     * @since 2.0.3
     *
     * @return bool
     */
    public function methodMatch($methods, $requestMethod = null)
    {
        $match = false;
        if ($requestMethod === null) {
            $requestMethod = ($this->request->getRequestMethod()) ? $this->request->getRequestMethod() : 'GET';
        }
        $methods = explode('|', $methods);
        foreach ($methods as $method) {
            if (strcasecmp($requestMethod, $method) === 0) {
                $match = true;
                break;
            } else {
                continue;
            }
        }
        if ($match === true) {
            return true;
        }

        return false;
    }

    /**
     * Get the currently matched parameters.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Get the current input according to given method.
     *
     * @since 3.0.0
     *
     * @return mix-data
     */
    public function getInput($default)
    {
        $method = (!empty($default)) ? $default : $this->request->getRequestMethod();
        if ($method === 'POST') {
            $data = $_POST;
        } elseif ($method === 'GET') {
            $data = $_GET;
        } elseif ($method === 'REQUEST') {
            $data = $_REQUEST;
        } else {
            parse_str(file_get_contents('php://input'), $data);
        }

        return (new \Zest\Data\Conversion())::arrayObject($data);
    }

    /**
     * Dispatch the route, creating the controller object and running the
     * action method.
     *
     * @param string $url The route URL
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->RemoveQueryString($url);
        if ($this->match($url)) {
            if (!isset($this->params['callable'])) {
                if (call_user_func($this->params['callBack']) === true) {
                    $controller = $this->params['controller'];
                    $controller = $this->convertToStudlyCaps($controller);
                    $controller = $this->getNamespace().$controller;
                    if (class_exists($controller)) {
                        (is_object($this->params['middleware'])) ? $this->params['middleware']->before(new Request(), new Response()) : null;
                        $controller_object = new $controller($this->params, $this->getInput($this->params['method']));
                        $action = $this->params['action'];
                        $action = $this->convertToCamelCase($action);
                        if (preg_match('/action$/i', $action) == 0) {
                            $controller_object->$action();
                            (is_object($this->params['middleware'])) ? $this->params['middleware']->after(new Request(), new Response()) : null;
                        } else {
                            throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                        }
                    } else {
                        throw new \Exception("Controller class $controller not found");
                    }
                } else {
                    throw new \Exception('This page is protected', 404);
                }
            } else {
                (is_object($this->params['middleware'])) ? $this->params['middleware']->before(new Request(), new Response()) : null;
                call_user_func($this->params['callable'], $this->params);
                (is_object($this->params['middleware'])) ? $this->params['middleware']->after(new Request(), new Response()) : null;
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
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
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
                $url = self::RemoveQueryString($this->request->getQueryString());
            }
        }

        return $url;
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present.
     *
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @return string The request URL
     */
    public function parseurl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    /**
     * Load routers form cache.
     *
     * @since 2.0.0
     *
     * @return array
     */
    public function loadCache()
    {
        if ($this->isCached() === true) {
            $fileHandling = new \Zest\Files\FileHandling();

            return json_decode($fileHandling->open('../Storage/Cache/routers.cache', 'readOnly')->read('../Storage/Cache/routers.cache'), true)['data'];
        }
    }

    /**
     * Cache the roouter.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function cacheRouters()
    {
        if (Config::ROUTER_CACHE === true) {
            if ($this->isCached() !== true) {
                $fileHandling = new \Zest\Files\FileHandling();
                $routers = $this->getRoutes();
                $cache = new ZestCache();
                $cache->create('routers');
                $cache->store('routers', 'routes', $routers, Config::ROUTE_CACHE_REGENERATE);
                $fileHandling->open('../Storage/Cache/router_time.cache', 'writeOnly')->write(time() + Config::ROUTE_CACHE_REGENERATE);
            }
        }
    }

    /**
     * Check if cache is exists.
     *
     * @since 2.0.0
     *
     * @return bool
     */
    public function isCached()
    {
        if (file_exists('../Storage/Cache/routers.cache')) {
            return true;
        } else {
            return false;
        }
    }
}
