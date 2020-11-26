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

use Zest\Files\FileHandling;
use Zest\Files\Files;

class FileCache extends AbstractAdapter
{
    /**
     * Path of cache directory.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private $path = '';

    /**
     * __construct.
     *
     * @param string $path Cache path
     * @param int    $ttl  time to live
     *
     * @since 3.0.0
     */
    public function __construct($path, $ttl = 0)
    {
        $this->path = $path;
        parent::__construct($ttl);
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
        $cacheFile = $this->path.md5($key);
        if (file_exists($cacheFile)) {
            $fileHandling = new FileHandling();
            $data = $fileHandling->open($cacheFile, 'readOnly')->read($cacheFile);
            $data = json_decode($data, true);
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
        if (!$this->hasItem($key)) {
            $cacheFile = $this->path.md5($key);
            $fileHandling = new FileHandling();
            $fileHandling->open($cacheFile, 'writeAppend')->write(json_encode([
                'start' => time(),
                'ttl'   => ($ttl !== null) ? (int) $ttl : $this->getTtl(),
                'value' => $value,
            ]));
            $fileHandling->close();
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
        $cacheFile = $this->path.md5($key);
        if (file_exists($cacheFile)) {
            $fileHandling = new FileHandling();
            $data = $fileHandling->open($cacheFile, 'readOnly')->read($cacheFile);
            $data = json_decode($data, true);
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
     * @param string $key
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function deleteItem($key)
    {
        $cacheFile = $this->path.md5($key);
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }

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
        $cacheDir = $this->path;
        if (is_dir($cacheDir)) {
            (new Files())->deleteDir($cacheDir);
        }

        return $this;
    }
}
