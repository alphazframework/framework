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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Cache\Adapter;

abstract class AbstractAdapter
{
    /**
     * Time to live.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $ttl = 0;

    /**
     * __construct.
     *
     * @param (int) $ttl time to live
     *
     * @since 3.0.0
     */
    public function __construct($ttl = 0)
    {
        $this->setTtl($ttl);
    }

    /**
     * Set the ttl.
     *
     * @param (int) $ttl time to live
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Get the time-to-live for cache.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * Get the time-to-live for an item in cache.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return int
     */
    abstract public function getItemTtl($key);

    /**
     * Save an item to cache.
     *
     * @param (string) $key
     *                      (mixed)  $value
     *                      (int)    $ttl
     *
     * @since 3.0.0
     *
     * @return void
     */
    abstract public function saveItem($key, $value, $ttl = null);

    /**
     * Get an item from cache.
     *
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    abstract public function getItem($key);

    /**
     * Determine if the item exist in cache.
     *
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return bool
     */
    abstract public function hasItem($key);

    /**
     * Delete a value in cache.
     *
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return void
     */
    abstract public function deleteItem($key);

    /**
     * Destroy cache resource.
     *
     * @since 3.0.0
     *
     * @return void
     */
    abstract public function destroy();
}
