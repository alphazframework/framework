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

namespace alphaz\Cache\Adapter;

class Memcached extends AbstractAdapter
{
    /**
     * Store the object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    private $memcached;

    /**
     * Version.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $version;

    /**
     * __construct.
     *
     * @param string $host   Host of memcache
     * @param int    $port   Port of memcache
     * @param int    $weight Weight of memcache
     * @param int    $ttl    Time to live
     *
     * @since 1.0.0
     */
    public function __construct($host, $port, $weight, $ttl = 0)
    {
        parent::__construct($ttl);

        if (!class_exists('Memcached', false)) {
            throw new \Exception('Memcached Class not found', 500);
        }
        $this->memcached = new \Memcached();
        $this->addServer($host, $port, $weight);

        $version = $this->memcached->getVersion();
        if (isset($version[$host.':'.$port])) {
            $this->version = $version[$host.':'.$port];
        }
    }

    /**
     * Get the memcached object.
     *
     * @since 1.0.0
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
     * @param string $host   Host of memcache
     * @param int    $port   Port of memcache
     * @param int    $weight Weight of memcache
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function addServer($host, $port = 11211, $weight = 1)
    {
        $this->memcached->addServer($host, $port, $weight);

        return $this;
    }

    /**
     * Add servers to Memcached.
     *
     * @param array $servers
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function addServers(array $servers)
    {
        $this->memcached->addServers($servers);

        return $this;
    }

    /**
     * Get the version of memcache.
     *
     * @since 1.0.0
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
     * @param string $key
     *
     * @since 1.0.0
     *
     * @return int|false
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
     * @param string $key
     * @param mixed  $value
     * @param int    $ttl
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function saveItem($key, $value, $ttl = null)
    {
        $cache = [
            'start' => time(),
            'ttl'   => ($ttl !== null) ? (int) $ttl : $this->getTtl(),
            'value' => $value,
        ];

        $this->memcached->set($key, $cache, $cache['ttl']);

        return $this;
    }

    /**
     * Get value form the cache.
     *
     * @param string $key
     *
     * @since 1.0.0
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
     * @param string $key
     *
     * @since 1.0.0
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
     * @param string $key
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function deleteItem($key)
    {
        $this->memcached->delete($key);

        return $this;
    }

    /**
     * Close the connection.
     *
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @return self
     */
    public function destroy()
    {
        $this->memcached->flush();
        $this->close();
        $this->memcached = null;

        return $this;
    }
}
