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
 * @license MIT
 */

namespace Zest\Cache\APCU;

class APCU
{
    /**
     * Adding data to cache.
     *
     * @param string $key , mix-data $data
     *
     * @return bool
     */
    public function add($key, $data)
    {
        return apcu_add($key, $data);
    }

    /**
     * Adding data to cache override existance.
     *
     * @param string $key , mix-data $data
     *
     * @return bool
     */
    public function addOverride($key, $data)
    {
        return apcu_store($key, $data);
    }

    /**
     * Updates an old value with a new value.
     *
     * @param string $key , mix-data $data
     *
     * @return bool
     */
    public function update($key, $oldData, $Data)
    {
        return apcu_cas($key, $oldData, $Data);
    }

    /**
     * Get the cache data.
     *
     * @param string $key
     *
     * @return array
     */
    public function get($key)
    {
        return apcu_fetch($key);
    }

    /**
     * Checks if entry exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function isCached($key)
    {
        return apcu_exists($key);
    }

    /**
     * Delete the cache data.
     *
     * @param string $key
     *
     * @return bool
     */
    public function delete($key)
    {
        return apcu_delete($key);
    }

    /**
     * Delete all  cache data.
     *
     * @return bool
     */
    public function deleteMaster()
    {
        return apcu_clear_cache();
    }

    /**
     *  Retrieves cached information from APCu's data store.
     *
     * @return array
     */
    public function apucInfo()
    {
        return apcu_cache_info();
    }
}
