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
 * @deprecated 3.0.0
 * @license MIT
 */

namespace Zest\Cache\ZestCache;

class ZestCache
{
    //The cache directory
    private $dir = '../Storage/Cache';
    //The name of the default cache file
    private $cacheName = 'default';
    //The cache file extension
    private $ext = '.cache';

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->openDir();
    }

    /**
     * get the default cache directory.
     *
     * @return string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * Get the default extension.
     *
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Open the default directories.
     *
     * @return void
     */
    public function openDir()
    {
        $dir = $this->getDir();
        if (!file_exists("$dir")) {
            $oldmask = umask(0);
            @mkdir($dir, 0777, true);
            @umask($oldmask);
        }
        if (!$this->isFile('.htaccess')) {
            $f = @fopen("$dir./.htaccess", 'a+');
            @fwrite($f, 'deny from all');
            @fclose($f);
        }
        if (!$this->isFile('index.html')) {
            $f = @fopen($dir.'/index.html', 'a+');
            @fclose($f);
        }
    }

    /**
     * Create the cache file.
     *
     * @param string $name
     *
     * @return bool
     */
    public function create($name = '', $auto = false)
    {
        if (!empty($name)) {
            $name = $name;
        } else {
            $name = $this->cacheName;
        }
        if ($this->isFile($name)) {
            if (true === $auto) {
                $name = date('Y-m-d-H-i-s');
            } else {
                return 'Sorry, file already exists, if you want create file with date/time pass auto agrument as true';
            }
        }
        $fullFile = $this->dir.'/'.$name.$this->ext;
        $file = fopen($fullFile, 'w+');
        fwrite($file, '');
        fclose($file);

        return true;
    }

    /**
     * Store data in cache file.
     *
     * @param resource $file , string $key, mix-data $data , time $expire
     *
     * @return bool
     */
    public function store($file, $key, $data, $expire)
    {
        $dataArray = [
            'key'    => $key,
            'data'   => $data,
            'expire' => time() + $expire,
        ];
        $cacheData = json_encode($dataArray);
        file_put_contents($this->dir.'/'.$file.$this->ext, $cacheData);

        return true;
    }

    /**
     * Check if key alrady exists or not.
     *
     * @param resource $file , string $sKey
     *
     * @return bool
     */
    public function isKey($file, $sKey)
    {
        if ($this->toArray($file)) {
            $key = $this->toArray($file)['key'];
            if ($key === $sKey) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Convert json to array.
     *
     * @param resource $file
     *
     * @return array
     */
    public function toArray($file)
    {
        return ($this->isFile($file)) ? json_decode(file_get_contents($this->dir.'/'.$file.$this->ext), true) : false;
    }

    /**
     * Load the file if expired its auto delete.
     *
     * @param resource $file
     *
     * @return mix-data
     */
    public function getData($file)
    {
        return ($this->load($file)) ? json_decode($this->load($file), true)['data'] : false;
    }

    /**
     * Load the file if expired its auto delete.
     *
     * @param resource $file
     *
     * @return mix-data
     */
    public function load($file)
    {
        if ($this->isFile($file)) {
            $data = file_get_contents($this->dir.'/'.$file.$this->ext);
            $expire = json_decode($data, true)['expire'];
            if ($expire <= time()) {
                $this->delete($file);

                return false;
            } else {
                return $data;
            }
        } else {
            return false;
        }
    }

    /**
     * Delete the cache file.
     *
     * @param resource $file
     *
     * @return bool
     */
    public function delete($file)
    {
        if ($this->isFile($file)) {
            $del = $this->dir.'/'.$file.$this->ext;
            unlink($del);
        }
    }

    /**
     * check is file exists or not.
     *
     * @param resource $file
     *
     * @return bool
     */
    public function isFile($file)
    {
        $fullFile = $this->dir.'/'.$file.$this->ext;

        return (file_exists($fullFile)) ? true : false;
    }
}
