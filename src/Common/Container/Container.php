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

class Container
{
    /**
     * The singleton instance of this class.
     *
     * @since 2.0.3
     *
     * @var object
     */
    private static $instance;
    /**
     * The collection of dependencies contained.
     *
     * @since 2.0.3
     *
     * @var array
     */
    private $dependencies;

    /**
     * __construct.
     *
     * @since 2.0.3
     */
    private function __construct()
    {
        $this->dependencies = [];
    }

    /**
     * Get the instance of self class.
     *
     * @since 2.0.3
     *
     * @return object
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Adds an object generator and the identifier for that object, with the option
     * of make the object 'singleton' or not.
     *
     * @param string $identifier The identifier of the dependency
     *                           $loader     The generator for the dependency objectb (callable)
     *                           $singleton  Whether or not to return always the same instance of the object
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function add($identifier, callable $loader, $singleton = true)
    {
        $this->dependencies[$identifier] = new Dependency($loader, $singleton);
    }

    /**
     * Gets the dependency identified by the given identifier.
     *
     * @param (string) $identifier The identifier of the dependency
     *
     * @since 2.0.3
     *
     * @return object
     */
    public function get($identifier)
    {
        if (!isset($this->dependencies[$identifier])) {
            throw new \Exception("Dependency identified by '$identifier' does not exist", 500);
        }

        return $this->dependencies[$identifier]->get();
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
        return $this->dependencies;
    }
}
