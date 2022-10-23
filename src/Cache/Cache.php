<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 1.0.0
 *
 * @license MIT
 */

namespace alphaz\Cache;

use alphaz\Cache\Adapter\APC;
use alphaz\Cache\Adapter\APCU;
use alphaz\Cache\Adapter\FileCache;
use alphaz\Cache\Adapter\Memcache;
use alphaz\Cache\Adapter\Memcached;
use alphaz\Cache\Adapter\Redis;
use alphaz\Cache\Adapter\SessionCache;
use alphaz\Container\Container;
use alphaz\Contracts\Cache\Cache as CacheContract;

class Cache implements CacheContract
{
    /**
     * Store the adapter object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    private $adapter = null;

    /**
     * __construct.
     *
     * @since 1.0.0
     */
    public function __construct($adapter = null)
    {
        $adapter = $adapter ?? __config('cache.driver', 'file');
        $this->setProperAdapter($adapter);
    }

    /**
     * Get the adapter of cache.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set the valid adapter.
     *
     * @param string $adapter
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function setProperAdapter($adapter)
    {
        $container = new Container();

        switch ($adapter) {
            case 'apc':
                $container->registerInstance([APC::class, 'cache'], new APC());
                break;
            case 'apcu':
                $container->registerInstance([APCU::class, 'cache'], new APCU());
                break;
            case 'memcache':
                $container->registerInstance([Memcache::class, 'cache'], new Memcache(__config('memcachecache.host'), __config('memcachecache.port')));
                break;
            case 'memcached':
                $container->registerInstance([Memcached::class, 'cache'], new Memcached(__config('memcachedcache.host'), __config('memcachedcache.host'), __config('memcachedcache.weight')));
                break;
            case 'redis':
                $container->registerInstance([Redis::class, 'cache'], new Redis(__config('rediscache.host'), __config('rediscache.port')));
                break;
            case 'session':
                $container->registerInstance([SessionCache::class, 'cache'], new SessionCache());
                break;

            default:
                $container->registerInstance([FileCache::class, 'cache'], new FileCache(__cache_path()));
                break;
        }

        $this->adapter = $container->get('cache');

        return $this;
    }

    /**
     * Get default ttl.
     *
     * @since 1.0.0
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
     * @param string $key
     *
     * @since 1.0.0
     *
     * @return int|false
     */
    public function getItemTtl($key)
    {
        $this->adapter->getItemTtl($key);
    }

    /**
     * Get the value from cache.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @since 1.0.0
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
     * @param array $keys
     * @param mixed $default
     *
     * @since 1.0.0
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
     * @param mixed $key   key for cache
     * @param mixed $value value to be cached
     * @param int   $ttl   time to live for cache
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function set($key, $value, $ttl = null)
    {
        $this->adapter->saveItem($key, $value, $ttl);

        return $this;
    }

    /**
     * Save multiple items to cache.
     *
     * @param array $cache [key=>keyVal,value=> val,ttl=>ttl]
     *
     * @since 1.0.0
     *
     * @return self
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
     * @param mixed $key key for cache
     *
     * @since 1.0.0
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
     * @param mixed $key key for cache
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function delete($key)
    {
        $this->adapter->deleteItem($key);

        return $this;
    }

    /**
     * Delete multiples items form cache.
     *
     * @param array $keys
     *
     * @since 1.0.0
     *
     * @return self
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
     * @since 1.0.0
     *
     * @return self
     */
    public function clear()
    {
        $this->adapter->destroy();

        return $this;
    }
}
