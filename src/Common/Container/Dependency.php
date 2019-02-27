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

class Dependency
{

    /**
     * Store the callable.
     *
     * @since 2.0.3
     *
     * @var callable
     */
    private $loader;

    /**
     * __construct.
     *
     * @since 2.0.3
     */
    public function __construct($loader)
    {
        $this->loader = $loader;
    }

    /**
     * Resolve single.
     *
     * @param $concrete the class.
     * @param $params constructur args.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function resolve($concrete, $params)
    {
        if ($concrete instanceof \Closure) {
            return $concrete($this, $params);
        }
        $reflector = new \ReflectionClass($concrete);
        // check if class is instantiable
        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$concrete} is not instantiable", 500);
        }
        // get class constructor
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            // get new instance from class
            return $reflector->newInstance();
        }
        // get constructor params
        $parameters   = $constructor->getParameters();
        $dependencies = $this->getResolveDependencies($parameters, $params);
        // get new instance with dependencies resolved
        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * Get all dependencies resolved.
     *
     * @param (array) $parameters required params
     * @param (array) $params constructure args.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getResolveDependencies($parameters, $params)
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            // get the type hinted class
            $dependency = $parameter->getClass();
            if ($dependency === null) {
                // check if default value for a parameter is available
                if ($parameter->isDefaultValueAvailable()) {
                    // get default value of parameter
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    if (empty($params[$parameter->name])) {
                        throw new \Exception("Can not resolve class dependency {$parameter->name}", 500);
                    }
                    $dependencies[] = $params[$parameter->name];
                }
            } else {
                // get dependency resolved
                $this->loader = $dependency->name;
                $dependencies[] = $this->get($dependency->name);
            }
        }
        return $dependencies;
    }

    /**
     * Returns the specific dependency instance.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function get($params = [])
    {
        return $this->resolve(call_user_func($this->loader), $params);
    }
}
