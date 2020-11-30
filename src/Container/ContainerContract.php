<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Container;

interface ContainerContract
{
    /**
     * Register a type hint.
     *
     * @param string|array    $hint      Type hint or array contaning both type hint and alias.
     * @param string|\Closure $class     Class name or closure.
     * @param bool            $singleton Should we return the same instance every time?
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function register($hint, $class, bool $singleton = false);

    /**
     * Register a type hint and return the same instance every time.
     *
     * @param string|array    $hint  Type hint or array contaning both type hint and alias.
     * @param string|\Closure $class Class name or closure.
     *
     * @since 3.0.0
     *
     * @return 3.0.0
     */
    public function registerSingleton($hint, $class);

    /**
     * Register a singleton instance.
     *
     * @param string|array $hint     Type hint or array contaning both type hint and alias.
     * @param object       $instance Class instance.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function registerInstance($hint, $instance);

    /**
     * Registers a contextual dependency.
     *
     * @param string $class          Class.
     * @param string $interface      Interface.
     * @param string $implementation Implementation.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function registerContextualDependency($class, string $interface, string $implementation);

    /**
     * Creates a class instance using closure.
     *
     * @param closure $factory    Closuare.
     * @param array   $parameters Constructor parameters.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function closureFactory(\Closure $factory, array $parameters);

    /**
     * Creates a class instance using reflection.
     *
     * @param mixed $class      Class name.
     * @param array $parameters Constructor parameters.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function reflectionFactory($class, array $parameters = []);

    /**
     * Creates a class instance.
     *
     * @param string|\Closure $class      Class name or closure.
     * @param array           $parameters Constructor parameters.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function factory($class, array $parameters = []);

    /**
     * Checks if a class is registered in the container.
     *
     * @param string $class Class name.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function has(string $class);

    /**
     * Returns TRUE if a class has been registered as a singleton and FALSE if not.
     *
     * @param string $class Class name.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isSingleton(string $class);

    /**
     * Returns a class instance.
     *
     * @param string $class      Class name.
     * @param array  $parameters Constructor parameters.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function get($class, array $parameters = []);

    /**
     * Execute a callable and inject its dependencies.
     *
     * @param callable $callable   Callable.
     * @param array    $parameters Parameters.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function exec(callable $callable, array $parameters = []);
}
