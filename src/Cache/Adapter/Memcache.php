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

class Memcache extends AbstractAdapter
{
    /**
     * Store the object.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private $memcache;

    /**
     * __construct.
     *
     * @param (int) $ttl time to live
     *
     * @since 3.0.0
     */
    public function __construct($ttl = 0, $host = 'localhost', $port = 255)
    {
        parent::__construct($ttl);

        if (!class_exists('Memcache', false)) {
            throw new \Exception('Memcache Class not found', 500);
        }
        $this->memcache = new \Memcache();
        $host = __config()->cache->memcache->host;
        $port = __config()->cache->memcache->port;

        if (!$this->memcache->connect($host, $port)) {
            throw new \Exception('Error: Unable to connect to the memcache server.', 500);
        }
    }

    /**
     * Get the memcache object.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function memcache()
    {
        return $this->memcache;
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
        return $this->memcache->getVersion();
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
        $data = $this->memcache->get($key);

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
     *                      (mixed) $value
     *                      (int) $ttl
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
            'value' => $value,
        ];

        $this->memcache->set($key, $cache, true, $cache['ttl']);

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
        $data = $this->memcache->get($key);

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
        return $this->getItem($key) !== false;
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
        $this->memcache->delete($key);

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
        $this->memcache->close();
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
        $this->memcache->flush();
        $this->close();
        $this->memcache = null;

        return $this;
    }
}
