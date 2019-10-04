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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Container;

use Zest\Contracts\Container\Container as ContainerContract;
use Zest\Data\Arrays;

class Container implements ContainerContract
{
    /**
     * Registered type hints.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $hints = [];

    /**
     * Aliases.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Singleton instances.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Contextual dependencies.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $contextualDependencies = [];

    /**
     * Instance replacers.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $replacers = [];

    /**
     * Parse the hint parameter.
     *
     * @param string|array $hint Type hint or array contaning both type hint and alias
     *
     * @since 3.0.0
     *
     * @return string
     */
    protected function parseHint($hint): string
    {
        if (is_string($hint) && preg_match('/a-zA-Z/i', $hint)) {
            return $hint;
        } elseif (Arrays::isReallyArray($hint)) {
            list($hint, $alias) = $hint;
            $this->aliases[$alias] = $hint;

            return $hint;
        }

        throw new \InvalidArgumentException("The {$hint} parameter should be array or string ".gettype($hint).' given', 500);
    }

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
    public function register($hint, $class, bool $singleton = false)
    {
        if ($class instanceof $hint[0]) {
            $this->hints[$this->parseHint($hint)] = ['class' => $class, 'singleton' => $singleton];
        } else {
            // If not an instance of a class then throw an exception.
            throw new \InvalidArgumentException("Claass should be valid instance of {$hint[0]}.", 500);
        }
    }

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
    public function registerSingleton($hint, $class)
    {
        $this->register($hint, $class, true);
    }

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
    public function registerInstance($hint, $instance)
    {
        $this->instances[$this->parseHint($hint)] = $instance;
    }

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
    public function registerContextualDependency($class, string $interface, string $implementation)
    {
        $this->contextualDependencies[$class][$interface] = $implementation;
    }

    /**
     * Return the name based on its alias.
     *
     * @param string $alias Alias.
     *
     * @since 3.0.0
     *
     * @return string
     */
    protected function resolveAlias(string $alias)
    {
        return $this->aliases[$alias] ?? $alias;
    }

    /**
     * Resolves a type hint.
     *
     * @param string $hint Type hint
     *
     * @since 3.0.0
     *
     * @return string|\Closure
     */
    protected function resolveHint($hint)
    {
        return $this->hints[$hint]['class'] ?? $hint;
    }

    /**
     * Resolves a contextual dependency.
     *
     * @param string $class     Class.
     * @param string $interface Interface.
     *
     * @since 3.0.0
     *
     * @return string
     */
    protected function resolveContextualDependency(string $class, string $interface): string
    {
        return $this->contextualDependencies[$class][$interface] ?? $interface;
    }

    /**
     * Merges the provided parameters with the reflection parameters into one array.
     *
     * @param array $reflectionParameters Reflection parameters.
     * @param array $providedParameters   Provided parameters.
     *
     * @since 3.0.0
     *
     * @return array
     */
    protected function mergeParameters(array $reflectionParameters, array $providedParameters): array
    {
        $assocReflectionParameters = [];
        foreach ($reflectionParameters as $value) {
            $assocReflectionParameters[$value->getName()] = $value;
        }
        $assocProvidedParameters = [];
        foreach ($reflectionParameters as $key => $value) {
            $assocProvidedParameters[$key] = $value;
        }

        return array_replace($assocReflectionParameters, $assocProvidedParameters);
    }

    /**
     * Returns the name of function.
     *
     * @param \ReflectionParameter $parameter ReflectionParameter instance.
     *
     * @since 3.0.0
     *
     * @return string
     */
    protected function getDeclaringFunction(\ReflectionParameter $parameter): string
    {
        $declaringFunction = $parameter->getDeclaringFunction();
        $class = $parameter->getDeclaringClass();

        if ($declaringFunction->isClosure()) {
            return 'Closure';
        } elseif ($class === null) {
            return $declaringFunction->getName();
        }

        return $class->getName().'::'.$declaringFunction->getName();
    }

    /**
     * Resolve a parameter.
     *
     * @param \ReflectionParameter  $parameter ReflectionParameter instance.
     * @param \ReflectionClass|null $class     ReflectionClass instance.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    protected function resolveParameter(\ReflectionParameter $parameter, \ReflectionClass $class = null)
    {
        //Try to get the class name.
        if ($parameterClass = $parameter->getClass() !== null) {
            $parameterClassName = $parameterClass->getName();
            if ($class !== null) {
                $parameterClassName = $this->resolveContextualDependency($class->getName(), $parameterClassName);
            }

            return $this->get($parameterClassName);

        //Detetmine Parameter has default value? yes, use it.
        } elseif ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new \RuntimeException('Unable to resolve the parameter', 500);
    }

    /**
     * Resolve parameters.
     *
     * @param array                 $reflectionParameters Reflection parameters.
     * @param array                 $providedParameters   Provided Parameters.
     * @param \ReflectionClass|null $class                ReflectionClass instance.
     *
     * @since 3.0.0
     *
     * @return array
     */
    protected function resolveParameters(array $reflectionParameters, array $providedParameters, \ReflectionClass $class = null): array
    {
        //Merge the parameter in to one array.
        $parameters = $this->mergeParameters($reflectionParameters, $providedParameters);

        foreach ($parameters as $key => $parameter) {
            //Determine either the parameter instance of \ReflectionParameter?
            if ($parameter instanceof \ReflectionParameter) {
                $parameters[$key] = $this->resolveParameter($parameter, $class);
            }
        }

        return array_values($parameters);
    }

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
    public function closureFactory(\Closure $factory, array $parameters)
    {
        $instance = $factory(...array_merge($this, $Parameters));
        //Determine closure return valid object.
        if (is_object($instance) !== false) {
            return $instance;
        }

        throw new \Exception('Instance should be an object', 500);
    }

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
    public function reflectionFactory($class, array $parameters = [])
    {
        $class = new \ReflectionClass($class);

        //Determine the class is really class?
        if ($class->isInstantiable() === true) {

                //Get the class construct.
            $constructor = $class->getConstructor();
            if (null === $constructor) {
                //No construct just return an object.
                return $class->newInstance();
            }

            //Get Construct parameters.
            $constructorParameters = $constructor->getParameters();

            return $class->newInstanceArgs($this->resolveParameters($constructorParameters, $parameters, $class));
        }

        throw new \Exception('Class is not instantiable', 500);
    }

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
    public function factory($class, array $parameters = [])
    {
        //If Closure calls to closure method.
        if ($class instanceof \Closure) {
            $instance = $this->closureFactory($class, $factory);
        } else {
            //If reflection calls to reflection.
            $instance = $this->reflectionFactory($class, $parameters);
        }

        return $instance;
    }

    /**
     * Checks if a class is registered in the container.
     *
     * @param string $class Class name.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function has(string $class): bool
    {
        $class = $this->resolveAlias($class);

        return isset($this->hints[$class]) || isset($this->instances[$class]);
    }

    /**
     * Returns TRUE if a class has been registered as a singleton and FALSE if not.
     *
     * @param string $class Class name.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isSingleton(string $class): bool
    {
        $class = $this->resolveAlias($class);

        return (isset($this->hints[$class]) || isset($this->instances[$class])) && $this->hints[$class]['singleton'] === true;
    }

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
    public function get($class, array $parameters = [])
    {
        $class = $this->resolveAlias($class);

        //If instance? return it.
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        $instance = $this->factory($this->resolveHint($class), $parameters);

        //If singleton store to new instance.
        if (isset($this->hints[$class]) && $this->hints[$class]['singleton']) {
            $this->instances[$class] = $instance;
        }

        return $instance;
    }

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
    public function exec(callable $callable, array $parameters = [])
    {
        $reflection = new \ReflectionFunction($callable);

        return $callable(...$this->resolveParameters($reflection->getParameters(), $parameters));
    }
}
