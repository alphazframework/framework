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

namespace Zest\Cache\Adapter;

class APC extends AbstractAdapter
{
    /**
     * __construct.
     *
     * @param int $ttl time to live
     *
     * @since 3.0.0
     */
    public function __construct($ttl = 0)
    {
        parent::__construct($ttl);

        if (!function_exists('apc_cache_info')) {
            throw new \Exception('APC cache extension is not installed', 500);
        }
    }

    /**
     * Method to get the current APC info.
     *
     * @return array
     */
    public function getInfo()
    {
        return apc_cache_info();
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
        $data = apc_fetch($key);
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

        apc_store($key, $cache, $cache['ttl']);

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
        $data = apc_fetch($key);
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
        apc_delete($key);

        return $this;
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
        apc_clear_cache();
        apc_clear_cache('user');

        return $this;
    }
}
