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

namespace alphaz\Component;

use alphaz\http\Request;
use alphaz\http\Response;
use alphaz\Input\Input;
use alphaz\View\View;

class Component extends \alphaz\Router\Router
{
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
    public function dispatch(Request $request)
    {
        $url = $request->getQueryString();
        $url = $this->RemoveQueryString($url, new Request());
        if ($this->match($url)) {
            if (isset($this->params['redirect'])) {
                \alphaz\Site\Site::redirect($this->params['to'], $this->params['code']);

                return;
            }
            (isset($this->params['middleware'])) ? $this->params['middleware'] = new $this->params['middleware']() : null;
            if (!isset($this->params['callable'])) {
                $controller = $this->params['controller'];
                $controller = $this->convertToStudlyCaps($controller);
                $controller = $this->getNamespace().$controller;
                if (class_exists($controller)) {
                    (isset($this->params['middleware']) && is_object($this->params['middleware'])) ? ( new $this->params['middleware']())->before(new Request(), new Response(), $this->params) : null;
                    $controller_object = new $controller($this->params, $this->getInput(new Input()));
                    $action = $this->params['action'];
                    $action = $this->convertToCamelCase($action);
                    if (preg_match('/action$/i', $action) == 0) {
                        $controller_object->$action();
                        (isset($this->params['middleware']) && is_object($this->params['middleware'])) ? (new $this->params['middleware']())->after(new Request(), new Response(), $this->params) : null;
                    } else {
                        throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                    }
                } else {
                    throw new \Exception("Controller class $controller not found");
                }
            } else {
                (is_object(isset($this->params['middleware']))) ? $this->params['middleware']->before(new Request(), new Response(), $this->params) : null;
                call_user_func($this->params['callable'], $this->params);
                (is_object(isset($this->params['middleware']))) ? $this->params['middleware']->after(new Request(), new Response(), $this->params) : null;
            }
        } else {
            View::view('errors/404', [], true, [], 404);
        }
    }
}
