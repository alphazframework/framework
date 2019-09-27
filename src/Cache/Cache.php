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

namespace Zest\Cache;

use Zest\Contracts\Cache\Cache as CacheContract;

class Cache implements CacheContract
{
    /**
     * Store the adapter object.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private $adapter = null;

    /**
     * __construct.
     *
     * @since 3.0.0
     */
    public function __construct()
    {
        $this->setProperAdapter(__config('cache.driver', 'file'));
    }

    /**
     * Get the adapter of cache.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getAdapter()
    {
        return $adapter;
    }

    /**
     * Set the valid adapter.
     *
     * @param (string) $adapter
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setAdapter($adapter)
    {
        $this->setProperAdapter($adapter);

        return $this;
    }

    /**
     * Set the valid adapter.
     *
     * @param (string) $adapter
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setProperAdapter($adapter)
    {
        switch ($adapter) {
            case 'apc':
                $adapter = '\Zest\Cache\Adapter\APC';
                break;
            case 'apcu':
                $adapter = '\Zest\Cache\Adapter\APCU';
                break;
            case 'file':
                $adapter = '\Zest\Cache\Adapter\FileCache';
                break;
            case 'memcache':
                $adapter = '\Zest\Cache\Adapter\Memcache';
                break;
            case 'memcached':
                $adapter = '\Zest\Cache\Adapter\Memcached';
                break;
            case 'redis':
                $adapter = '\Zest\Cache\Adapter\Redis';
                break;
            case 'session':
                $adapter = '\Zest\Cache\Adapter\SessionCache';
                break;

            default:
                $adapter = '\Zest\Cache\Adapter\FileCache';
                break;
        }

        $this->adapter = new $adapter();

        return $this;
    }

    /**
     * Get default ttl.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getDefaultTtl()
    {
        $this->adapter->getTtl();
    }

    /**
     * Get item ttl.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getItemTtl($key)
    {
        $this->adapter->getItemTtl($key);
    }

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
    public function get($key, $default = null)
    {
        $cache = $this->adapter->getItem($key);

        return (isset($cache) && $cache !== null) ? $cache : $default;
    }

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
    public function getMultiple($keys, $default = null)
    {
        $cache = [];
        foreach ($keys as $key) {
            $cache[$key] = $this->get($key, $default);
        }

        return $cache;
    }

    /**
     * Save item to cache.
     *
     * @param (mixed) $key   key for cache
     * @param (mixed) $value value to be cached
     * @param (int)   $ttl   time to live for cache
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function set($key, $value, $ttl = null)
    {
        $this->adapter->saveItem($key, $value, $ttl);

        return $this;
    }

    /**
     * Save multiple items to cache.
     *
     * @param (array) $cache [key=>keyVal,value=> val,ttl=>ttl]
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setMultiple($cache)
    {
        foreach ($cache as $value) {
            $this->set($value['key'], $value['value'], $value['ttl']);
        }

        return $this;
    }

    /**
     * Determine if cache exixts.
     *
     * @param (mixed) $key key for cache
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->adapter->hasItem($key);
    }

    /**
     * Delete item form cache.
     *
     * @param (mixed) $key key for cache
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function delete($key)
    {
        $this->adapter->deleteItem($key);

        return $this;
    }

    /**
     * Delete multiples items form cache.
     *
     * @param (array) $keys
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return $this;
    }

    /**
     * Clear all caches.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function clear()
    {
        $this->adapter->destroy();

        return $this;
    }
}
