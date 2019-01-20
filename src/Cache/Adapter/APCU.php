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

class APCU extends AbstractAdapter
{
    /**
     * __construct.
     *
     * @param (int) $ttl time to live
     *
     * @since 3.0.0
     */
    public function __construct($ttl = 0)
    {
        parent::__construct($ttl);

        if (!function_exists('apcu_cache_info')) {
            throw new \Exception('APCU cache extension not installed', 500);
        }
    }

    /**
     * Method to get the current APCU info.
     *
     * @return array
     */
    public function getInfo()
    {
        return apcu_cache_info();
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
        $data = apcu_fetch($key);
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
     * @param (mixed)  $value
     * @param (int)    $ttl
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

        apcu_store($key, $cache, $cache['ttl']);

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
        $data = apcu_fetch($key);
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
        apcu_delete($key);

        return $this;
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
        apcu_clear_cache();

        return $this;
    }
}
