<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\Controller;

abstract class Controller
{
    /**
     * Parameters from the matched route.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $route_params = [];

    /**
     * Data form the input.
     *
     * @since 3.0.0
     *
     * @var mixed
     */
    protected $input;

    /**
     * Class constructor.
     *
     * @param (array) $route_params Parameters from the route
     * @param (mixed) $input        Data form the input
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct($route_params, $input)
    {
        $this->route_params = $route_params;
        $this->input = $input;
    }

    /**
     * Overriding...
     * Magic method called when a non-existent or inaccessible property is
     * write on an object of this class.
     * in this case we trow error.
     *
     * @param (string) $name  properity name
     * @param (array)  $value properity value
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __set($name, $value)
    {
        throw new \Exception("You're doing wrong job", 500);
    }

    /**
     *Overriding...
     * Magic method called when a non-existent or inaccessible property is
     * called on an object of this class.
     * in this case we trow error.
     *
     * @param (string) $name properity name
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __get($name)
    {
        throw new \Exception("You're doing wrong job", 500);
    }

    /**
     * Overriding...
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param (string) $name Method name
     * @param (array)  $args Arguments passed to the method
     *
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @since 1.0.0
     *
     * @return void
     */
    protected function after()
    {
    }

    /**
     * Prevent unserializing.
     *
     * @since 1.0.0
     *
     * @return void
     **/
    protected function __wakeup()
    {
    }
}
