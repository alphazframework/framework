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
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\Cookies;

class Cookies
{
    /**
     * The default path (if specified).
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $path = '/';

    /**
     * The default domain (if specified).
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $domain;

    /**
     * The default secure setting (defaults to false).
     *
     * @since 3.0.0
     *
     * @var bool
     */
    protected $secure = false;

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
    public function set(string $name, $value, $expire = 0, $path = null, $domain = null, bool $secure = false, bool $httponly = true)
    {
        $name = preg_match('/[=,; \t\r\n\013\014]/', $name) ? rand(1, 25) : $name;
        if ($expire instanceof \DateTime) {
            $expire = $expire->format('U');
        } elseif (preg_match('~\D~', $expire)) {
            $expire = strtotime($expire);
        } else {
            $expire = $expire;
            if (false === $expire) {
                throw new \InvalidArgumentException('The cookie expiration time is not valid.', 500);
            }
        }
        [$path, $domain, $secure] = $this->getPathAndDomain($path, $domain, $secure);

        return setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Get the path and domain, or the default values.
     *
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     *
     * @since 3.0.0
     *
     * @return array
     */
    protected function getPathAndDomain($path, $domain, $secure = false, $sameSite = null)
    {
        return [$path ?: $this->path, $domain ?: $this->domain, is_bool($secure) ? $secure : $this->secure];
    }

    /**
     * Set the default path and domain for the jar.
     *
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setDefaultPathAndDomain($path, $domain, $secure = false, $sameSite = null)
    {
        [$this->path, $this->domain, $this->secure] = [$path, $domain, $secure];

        return $this;
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
    public function delete($name, $path = null, $domain = null)
    {
        $this->set($name, null, -2628000, $path, $domain);
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
