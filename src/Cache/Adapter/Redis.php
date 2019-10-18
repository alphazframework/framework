<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Cache\Adapter;

class Redis extends AbstractAdapter
{
    /**
     * Store the object.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private $redis;

    /**
     * __construct.
     *
     * @param string $host Host of redis
     * @param int    $port Port of redis
     * @param int    $ttl  Time to live
     *
     * @since 3.0.0
     */
    public function __construct($host, $port, $ttl = 0)
    {
        parent::__construct($ttl);

        if (!class_exists('Redis', false)) {
            throw new \Exception('Redis Class not found', 500);
        }
        $this->redis = new \Redis();
        if (!$this->redis->connect($host, $port)) {
            throw new \Exception('Error: Unable to connect to the redis server.', 500);
        }
    }

    /**
     * Get the redis object.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function redis()
    {
        return $this->redis;
    }

    /**
     * Get the version of redis.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->redis->info()['radis_version'];
    }

    /**
     * Get the time-to-live for an item in cache.
     *
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return int|false
     */
    public function getItemTtl($key)
    {
        $data = $this->redis->get($key);
        if ($data !== false) {
            $data = json_decode($data, true);
            if ((($data['ttl'] == 0) || ((time() - $data['start']) <= $data['ttl']))) {
                $ttl = $data['ttl'];
            } else {
                $this->deleteItem($key);
            }
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
     * @since 3.0.0
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
        if ($cache['ttl'] != 0) {
            $this->redis->set($key, json_encode($cache), $cache['ttl']);
        } else {
            $this->redis->set($key, json_encode($cache));
        }

        return $this;
    }

    /**
     * Get value form the cache.
     *
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getItem($key)
    {
        $data = $this->redis->get($key);
        if ($data !== false) {
            $data = json_decode($data, true);
            if ((($data['ttl'] == 0) || ((time() - $data['start']) <= $data['ttl']))) {
                $value = $data['value'];
            } else {
                $this->deleteItem($key);
            }
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function deleteItem($key)
    {
        $this->redis->delete($key);

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
        $this->redis->close();
    }

    /**
     * Remove all caches.
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function destroy()
    {
        $this->redis->flushDb();
        $this->close();
        $this->redis = null;

        return $this;
    }
}
