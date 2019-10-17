<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Cache\Adapter;

class SessionCache extends AbstractAdapter
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

        if (!isset($_SESSION['__CACHE__'])) {
            $_SESSION['__CACHE__'] = [];
        }
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
        if (isset($_SESSION['__CACHE__'][$key])) {
            $data = json_decode($_SESSION['__CACHE__'][$key], true);
            if ($data['ttl'] === 0 || (time() - $data['start'] <= $data['ttl'])) {
                $ttl = $data['ttl'];
            } else {
                $this->deleteItem($key);
            }
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
        $_SESSION['__CACHE__'][$key] = json_encode([
            'start' => time(),
            'ttl'   => ($ttl !== null) ? (int) $ttl : $this->getTtl(),
            'value' => $value,
        ]);

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
        if (isset($_SESSION['__CACHE__'][$key])) {
            $data = json_decode($_SESSION['__CACHE__'][$key], true);
            if ($data['ttl'] === 0 || (time() - $data['start'] <= $data['ttl'])) {
                $value = $data['value'];
            } else {
                $this->deleteItem($key);
            }
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
        return ($this->getItem($key) !== false) ? true : false;
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
        if (isset($_SESSION['__CACHE__'][$key])) {
            unset($_SESSION['__CACHE__'][$key]);
        }

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
        if (isset($_SESSION['__CACHE__'])) {
            unset($_SESSION['__CACHE__']);
        }

        return $this;
    }
}
