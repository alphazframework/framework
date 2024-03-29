<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 1.0.0
 *
 * @license MIT
 */

namespace alphaz\Common;

use alphaz\Contracts\Common\Configuration as ConfigurationContract;
use alphaz\Data\Arrays;

class Configuration implements ConfigurationContract
{
    /**
     * All of the configuration items.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new configuration repository.
     *
     * @param array $items
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct($items = [])
    {
        if (\defined('__alphaz__ROOT__')) {
            $this->file = __alphaz__ROOT__.'/Config/App.php';
        } else {
            $this->file = null;
        }

        // We need to load array configurations.
        $this->items = Arrays::arrayChangeCaseKey(Arrays::dot($this->load()), CASE_LOWER);
        $this->items = array_merge($this->items, $items);
    }

    /**
     * Load the configuration file.
     *
     * @since 1.0.0
     *
     * @return array
     */
    private function load()
    {
        $configs = [];

        if (file_exists($this->file)) {
            $configs += require $this->file;
        }

        return $configs;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param string $key
     *
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @param array|string $key
     * @param mixed        $value
     *
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }
}
