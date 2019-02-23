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
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Common\Container;

use Zest\Data\Conversion;

//DependencyInjectionService
class DIS
{
    /**
     * Store the instance of cotnainer class.
     *
     * @since 2.0.3
     *
     * @var object
     */
    private $container;
    /**
     * Store the registered dependencies.
     *
     * @since 2.0.3
     *
     * @var array
     */
    private $dependencies;

    /**
     * __construct.
     *
     * @param (array) $dependency dependency
     *
     * @since 2.0.3
     */
    public function __construct(array $dependency = [])
    {
        $this->container = Container::getInstance();
        $this->dependencies = __config()->dependencies;
        $this->mergeDependencies($dependency);
        $this->handler();
    }

    /**
     * Register the dependencies.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function handler()
    {
        $dependencies = $this->dependencies;
        foreach ($this->getDependencies() as $depenci => $value) {
            $this->register($depenci, function () use ($value) {
                return (object) new $value();
            }, true);
        }
    }

    /**
     * Registers a dependency into the Dependency Injection system.
     *
     * @param (string) $identifier The identifier for this dependency
     *                             (callable) $loader     The loader function for the dependency (to be called when needed)
     *                             (bool) $singleton  Whether or not to return always the same instance
     *
     * @since 2.0.3
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
     * @param (string) $identifier The identifier
     *
     * @since 2.0.3
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
     * @since 2.0.3
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
     * @since 2.0.3
     *
     * @return array
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * Merge to container.
     *
     * @param (array) $dependency valid dependency
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function mergeDependencies($dependency = [])
    {
        $this->dependencies = array_merge((array) $dependency, (array) $this->getDependencies());
        $this->dependencies = Conversion::arrayObject($this->dependencies);
    }
}
