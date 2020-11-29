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

namespace Zest\Common;

class Env
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
     * Create a new env configuration repository.
     *
     * @param array $items
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function __construct($items = [])
    {
        $this->items = array_merge($this->load(), $items);
    }

    /**
     * Load the configuration file.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function load()
    {
        $items = [];
        if (\defined('__ZEST__ROOT__')) {
            $file = __ZEST__ROOT__.'/.env';

            if (file_exists($file)) {
                $handle = fopen($file, 'r');
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        if ($line !== "\n") {
                            $config = explode('=', $line);
                            $items = array_merge($this->items, [
                                $config[0] => $config[1],
                            ]);
                        }
                    }
                    fclose($handle);
                }
            }
        }

        return $items;
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

        return $this->items[$key] ?? $default;
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
