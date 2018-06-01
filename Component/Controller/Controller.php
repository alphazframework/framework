<?php

namespace Softhub99\Zest_Framework\Component\Controller;

/**
 * Base controller.
 *
 * PHP version 7.0
 */
abstract class Controller
{
    /**
     * Parameters from the matched route.
     *
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor.
     *
     * @param array $route_params Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /** Overriding...
     * Magic method called when a non-existent or inaccessible property is
     * write on an object of this class.
     * in this case we trow error.
     *
     * @param string $name  properity name
     * @param array  $value properity value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        throw new \Exception("You're doing wrong job", 500);
    }

    /** Overriding...
     * Magic method called when a non-existent or inaccessible property is
     * called on an object of this class.
     * in this case we trow error.
     *
     * @param string $name properity name
     *
     * @return void
     */
    public function __get($name)
    {
        throw new \Exception("You're doing wrong job", 500);
    }

    /** Overriding...
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name Method name
     * @param array  $args Arguments passed to the method
     *
     * @return void
     */
    final public function __call($name, $args)
    {
        $method = "{$name}Action";
        $method_before = "{$name}Before";
        $method_after = "{$name}After";
        if (method_exists($this, $method)) {
            if (method_exists($this, $method_before) && method_exists($this, $method_after)) {
                if ($this->$method_before() !== false) {
                    call_user_func_array([$this, $method], $args);
                    $this->$method_after();
                }
            } else {
                if ($this->before() !== false) {
                    call_user_func_array([$this, $method], $args);
                    $this->after();
                }
            }
        } else {
            throw new \Exception("Method {$method} not found in controller class ".get_class($this), 500);
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }

    /**
     * Prevent unserializing.
     **/
    protected function __wakeup()
    {
    }
}
