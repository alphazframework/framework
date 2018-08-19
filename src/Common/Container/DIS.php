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
 */

namespace Zest\Common\Container;

//DependencyInjectionService
class DIS
{
    /*
     * Store the instance of cotnainer class
    */
    private $container;
    /*
     * Store the registered dependencies
    */
    private $dependencies;

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->dependencies = require_once route()->config.'/Dependencies.php';
        $this->handler();
    }

    /**
     * Register the dependencies.
     *
     * @return void
     */
    public function handler()
    {
        $dependencies = $this->dependencies;
        foreach ($this->getDependencies() as $depenci => $value) {
            $this->register($depenci, function () use ($value) {
                return $value;
            });
        }
    }

    /**
     * Registers a dependency into the Dependency Injection system.
     *
     * @param string $identifier The identifier for this dependency
     *                           $loader     The loader function for the dependency (to be called when needed)
     *                           $singleton  Whether or not to return always the same instance
     *
     * @return void
     */
    public function register($identifier, callable $loader, $singleton = true)
    {
        $this->container->add($identifier, $loader, $singleton);
    }

    /**
     * Returns the dependency identified by the given identifier.
     *
     * @param string $identifier The identifier
     *
     * @return mixed
     */
    public function get($identifier)
    {
        return $this->container->get($identifier);
    }

    /**
     * Returns all the dependencies.
     *
     * @return array
     */
    public function debug()
    {
        return $this->container->debug();
    }

    /**
     * Returns all the dependencies.
     *
     * @return array
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }
}
