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

class Memcached extends AbstractAdapter
{

    /**
     * Store the object 
     * 
     * @since 3.0.0
     *
     * @var object
    */
    private $memcached;

    /**
     * __construct
     *
     * @param (int) $ttl time to live
     *
     * @since 3.0.0
     */ 
    public function __construct($ttl = 0)
    {
        parent::__construct($ttl);

        if (!class_exists('Memcached',false)) {
            throw new \Exception("Memcached Class not found", 500);
        }
        $this->memcached = new \Memcached();
        $host = __config()->cache->memcached->host;
        $port = __config()->cache->memcached->port;
        $weight = __config()->cache->memcached->weight;
        $this->addServer($host, $port, $weight);

        $version = $this->memcached->getVersion();
        if (isset($version[$host . ':' . $port])) {
            $this->version = $version[$host . ':' . $port];
        }
    }

    /**
     * Get the memcached object.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function memcached()
    {
        return $this->memcached;
    }

    /**
     * Add server to Memcached.
     *
     * @param  (string) $host
     *         (int) $port
     *         (int) $weight 
     *
     * @since 3.0.0
     * 
     * @return object
     */
    public function addServer($host, $port = 11211, $weight = 1)
    {
        $this->memcached->addServer($host, $port, $weight);

        return $this;
    }

    /**
     * Add servers to Memcached.
     *
     * @param  (array) $servers
     *
     * @since 3.0.0
     * 
     * @return object
     */
    public function addServers(array $servers)
    {
        $this->memcached->addServers($servers);

        return $this;
    }

    /**
     * Get the version of memcache.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the time-to-live for an item in cache.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */ 
    public function getItemTtl($key)
    {
        $data = $this->memcached->get($key);

        if ($data['ttl'] === 0 || (time() - $data['start'] <= $data['ttl'])) {
            $ttl = $data['ttl'];
        } else {
            $this->deleteItem($key);
        }

        return (isset($ttl)) ? $ttl : false;
    }

    /**
     * Save an item to cache.
     *
     * @param (string) $key
     *        (mixed) $value 
     *        (int) $ttl 
     *
     * @since 3.0.0
     *
     * @return object
     */    
    public function saveItem($key, $value, $ttl = null)
    {
        $cache = [
            'start' => time(),
            'ttl'   => ($ttl !== null) ? (int) $ttl : $this->ttl,
            'value' => $value 
        ];
        
        $this->memcached->set($key, $cache, $cache['ttl']);

        return $this;
    }

    /**
     * Get value form the cache.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getItem($key)
    {
        $data = $this->memcached->get($key);

        if ($data['ttl'] === 0 || (time() - $data['start'] <= $data['ttl'])) {
            $value = $data['value'];
        } else {
            $this->deleteItem($key);
        }
        

        return (isset($value)) ? $value : false;
    }

    /**
     * Determine if cache exists.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function hasItem($key)
    {
        return ($this->getItem($key) !== false);
    }

    /**
     * Delete the cache.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return object
     */    
    public function deleteItem($key)
    {
        $this->memcached->delete($key);

        return $this;
    }

    /**
     * Close the connection.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function close()
    {
        $this->memcached->quit();        
    }

    /**
     * Remove all caches.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function destroy()
    {
        $this->memcached->flush();
        $this->close();
        $this->memcached = null;

        return $this;
    }
}
