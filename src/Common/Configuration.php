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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Common;

use Zest\Contracts\Common\Configuration as ConfigurationContract;
use Zest\Data\Arrays;

class Configuration implements ConfigurationContract
{

    /**
     * All of the configuration items.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new configuration repository.
     *
     * @param array $items
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function has($key)
    {
        return Arrays::has($this->items, $key, '.');
    }

    /**
     * Get the specified configuration value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->items;
        }

        return Arrays::get($this->items, $key, $default, '.');
    }

    /**
     * Set a given configuration value.
     *
     * @param array|string  $key
     * @param mixed         $value
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arrays::set($this->items, $key, $value, '.');
        }
    }

    /**
     * Get all of the configuration items for the application.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }
}
