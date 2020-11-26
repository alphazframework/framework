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

namespace Zest\Contracts\Cache;

interface Cache
{
    /**
     * __construct.
     *
     * @since 3.0.0
     */
    public function __construct();

    /**
     * Get the adapter of cache.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getAdapter();

    /**
     * Set the valid adapter.
     *
     * @param (string) $adapter
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function setProperAdapter($adapter);

    /**
     * Get default ttl.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getDefaultTtl();

    /**
     * Get item ttl.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return int|false
     */
    public function getItemTtl($key);

    /**
     * Get the value from cache.
     *
     * @param (mixed) $key
     * @param (mixed) $default
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Get the multiple values from cache.
     *
     * @param (array) $keys
     * @param (mixed) $default
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getMultiple($keys, $default = null);

    /**
     * Save item to cache.
     *
     * @param (mixed) $key   key for cache
     * @param (mixed) $value value to be cached
     * @param (int)   $ttl   time to live for cache
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function set($key, $value, $ttl = null);

    /**
     * Save multiple items to cache.
     *
     * @param (array) $cache [key,value,ttl]
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function setMultiple($cache);

    /**
     * Determine if cache exixts.
     *
     * @param (mixed) $key key for cache
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function has($key);

    /**
     * Delete item form cache.
     *
     * @param (mixed) $key key for cache
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function delete($key);

    /**
     * Delete multiples items form cache.
     *
     * @param (array) $keys
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function deleteMultiple($keys);

    /**
     * Clear all caches.
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function clear();
}
