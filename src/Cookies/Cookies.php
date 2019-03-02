<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\Cookies;

class Cookies
{
    /**
     * Set the cookie value.
     *
     * @param (string) $name     Name of cookie.
     * @param (mixed)  $value    Value to store in cookie.
     * @param (expire) $expire   TTL.
     * @param (string) $path     Path.
     * @param (domain) $domain   Domain.
     * @param (bool)   $secure   true | false.
     * @param (bool)   $httponly true | false.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function set(string $name, $value, $expire, $path, $domain, bool $secure, bool $httponly)
    {
        $name = preg_match('/[=,; \t\r\n\013\014]/', $name) ? rand(1, 25) : $name;
        if ($expire instanceof \DateTime) {
            $expire = $expire->format('U');
        } elseif (preg_match('~\D~', $expire)) {
            $expire = strtotime($expire);
        } else {
            $expire = $expire;
        }
        $path = empty($path) ? '/' : $path;
        if (!$this->has($name)) {
            return setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
        } else {
            return false;
        }
    }

    /**
     * Set the multiple cookies value.
     *
     * @param (array) $array valid array.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setMultiple(array $array)
    {
        foreach ($array as $key) {
            $this->set($key[0], $key[1], $key[2], $key[3], $key[4], $key[5], $key[6]);
        }

        return $this;
    }

    /**
     * Determine if cookie set or not.
     *
     * @param (string) $name of cookie
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function has($name)
    {
        if (isset($name) && !empty($name)) {
            if (isset($_COOKIE[$name])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Get the cookie value.
     *
     * @param (sring) $name    of cookie
     * @param (mixed) $default default value if cookie is not exists
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if (isset($name) && !empty($name)) {
            if ($this->has($name)) {
                return $_COOKIE[$name];
            } else {
                return $default;
            }
        } else {
            return false;
        }
    }

    /**
     * Get multiple values from cookie.
     *
     * @param (array) $keys    name
     * @param (mixed) $default default value if cookie is not exists
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getMultiple($keys, $default = null)
    {
        $value = [];
        foreach ($keys as $key) {
            $this->has($key) ? $value[$key] = $this->get($key, $default) : null;
        }

        return $value;
    }

    /**
     * Delete the cookie.
     *
     * @param (string) $name of cookie
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function delete($name)
    {
        if (isset($name) && !empty($name)) {
            if ($this->has($name)) {
                setcookie($name, '', time() - 3600, '/');

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Delete multiple cookies.
     *
     * @param (array) $keys keys
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }
}
