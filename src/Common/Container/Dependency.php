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

class Dependency
{
    /*
     * Store the object
    */
    private $object;
    /*
     * Store the singleton
    */
    private $singleton;
    /*
     * Store the callable
    */
    private $loader;

    /**
     * __construct.
     */
    public function __construct(callable $loader, $singleton = true)
    {
        $this->singleton = (bool) $singleton;
        $this->loader = $loader;
    }

    /**
     * Returns the specific dependency instance.
     *
     * @return mixed
     */
    public function get()
    {
        if (!$this->singleton) {
            return call_user_func($this->loader);
        }
        if ($this->object === null) {
            $this->object = call_user_func($this->loader);
        }

        return $this->object;
    }
}
