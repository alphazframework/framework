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
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Common\Container;

class Dependency
{
    /**
     * Store the object
     *
     * @since 2.0.3
     *
     * @var object
    */
    private $object;
    /**
     * Store the singleton
     *
     * @since 2.0.3
     *
     * @var bool
    */
    private $singleton;
    /**
     * Store the callable
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
    public function __construct(callable $loader, $singleton = true)
    {
        $this->singleton = (bool) $singleton;
        $this->loader = $loader;
    }

    /**
     * Returns the specific dependency instance.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function get()
    {
        if (!$this->singleton) {
            return (object) call_user_func($this->loader);
        }
        if ($this->object === null) {
            $this->object = call_user_func($this->loader);
            $object = new $this->object;
        }

        return (object) $object;
    }
}
