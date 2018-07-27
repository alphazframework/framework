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
namespace Softhub99\Zest_Framework\Cache\Opcache;

class Opcache
{
    /**
     * Cache the file.
     *
     * @param resuource $file
     *
     * @return bool
     */
    public function add($file)
    {
        return opcache_compile_file($file);
    }

    /**
     * Get status information about the cache.
     *
     * @param resuource $file
     *
     * @return array
     */
    public function status($file)
    {
        return opcache_get_status($file);
    }

    /**
     *  Invalidates a cached script.
     *
     * @param resuource $file , boolean $force
     *
     * @return bool
     */
    public function invalidat($file, $force)
    {
        return opcache_invalidate($file, $force);
    }

    /**
     * check is file cached.
     *
     * @param resuource $file
     *
     * @return bool
     */
    public function isCached($file)
    {
        return opcache_is_script_cached($file);
    }

    /**
     * Restart opcache.
     *
     * @return bool
     */
    public function restart()
    {
        return opcache_reset();
    }

    /**
     * Return config of opcache.
     *
     * @return arrauy
     */
    public function configGet()
    {
        return opcache_get_configuration();
    }
}
