<?php

namespace Softhub99\Zest_Framework\Router;

/**
 * Router
 *
 * PHP version 7.0
 */
class Router
{

    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

    /**
     * Add a route to the routing table
     *
     * @param string $route  The route URL
     * @param array  $params Parameters (controller, action, etc.)
     *
     * @return void
     */
    public function add(string $route, array$params = [])
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Get all the routes from the routing table
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
     * @return boolean  true if a match found, false otherwise
     */
    public function match(string $url)
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

        return false;
    }

    /**
     * Get the currently matched parameters
     *
     * @return array
     */
    public function getParams(){
        return $this->params;
    }

    /**
     * Dispatch the route, creating the controller object and running the
     * action method
     *
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch(string $url)
    {
        $url = $this->RemoveQueryString($url);
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;

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
            throw new \Exception('No route matched.', 404);
        }



    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToStudlyCaps(string $string)
    {
        return ucwords(str_replace('-', ' ', $string));
    }

    /**
     * Convert the string with hyphens to camelCase,
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase(string $string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove the query string variables from the URL (if any). As the full
     * @param string $url The full URL
     *
     * @return string The URL with the query string variables removed
     */
    protected function RemoveQueryString(string $url)
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

        (!array_key_exists('namespace',$this->params)) ? $namespace = 'App\Controllers\\' : $namespace .= $this->params['namespace'] . '\\';
        return $namespace;
    }
    /**
     * Parase the url if need
     *
     * @return string The request URL
     */
    public function parseurl(){
        if(isset($_GET['url'])){
            return $url = explode('/',filter_var(rtrim($_GET['url'] , '/') , FILTER_SANITIZE_URL) );
        } 
        
    }    
}
