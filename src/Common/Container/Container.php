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

class Container 

{
    /**
     * The singleton instance of this class
     */
    private static $instance;
    /**
     * The collection of dependencies contained.
     */
    private $dependencies;
    /**
     * __construct
     *
     */
    private function __construct()
    {
        $this->dependencies = [];
    }
    /**
     * Get the instance of self class.
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
     * @param string   $identifier The identifier of the dependency
     *                 $loader     The generator for the dependency objectb (callable)
     *                 $singleton  Whether or not to return always the same instance of the object 
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
     * @param  $identifier The identifier of the dependency
     *
     * @return object
     */
    public function get($identifier)
    {
        if (!isset($this->dependencies[$identifier])) {
            throw new \Exception("Dependency identified by '$identifier' does not exist",500);
        }
        return $this->dependencies[$identifier]->get();
    }
    /**
     * Returns all the dependencies.
     *
     * @return array
     */        
    public function debug()
    {
        return $this->dependencies;
    }
}