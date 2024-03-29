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

class Env
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
     * Create a new env configuration repository.
     *
     * @param array $items
     *
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @return array
     */
    public function load()
    {
        $items = [];
        if (\defined('__alphaz__ROOT__')) {
            $file = __alphaz__ROOT__.'/.env';

            if (file_exists($file)) {
                $handle = fopen($file, 'r');
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        // if line start with # then skip it
                        if (substr($line, 0, 1) === '#') {
                            continue;
                        }
                        // if it is whitespace or empty then skip it
                        if (trim($line) === '') {
                            continue;
                        }
                        $config = explode('=', $line);
                        // if config is not 2 then skip it
                        if (count($config) !== 2) {
                            continue;
                        }

                        $items = array_merge($items, [
                            $config[0] => $config[1],
                        ]);
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
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }
}
