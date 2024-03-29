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
 * @since 1.9.7
 *
 * @license MIT
 */

namespace alphaz\Common;

use alphaz\Contracts\Common\Root as RootContract;
use alphaz\Data\Arrays;

class Root implements RootContract
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
     * Create a new Roots/Paths repository.
     *
     * @param array $items
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct($items = [])
    {
        $this->items = Arrays::arrayChangeCaseKey(Arrays::dot($this->paths()), CASE_LOWER);
        $this->items = array_merge($this->items, $items);
    }

    /**
     * Get the specified path value.
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
     * Return the root path of app.
     *
     * @since 1.9.1
     *
     * @return string
     */
    private function root()
    {
        if (defined('__alphaz__ROOT__')) {
            return __alphaz__ROOT__.'/';
        }

        return '../';
    }

    /**
     * Get the path.
     *
     * @since 1.9.7
     *
     * @return array
     */
    private function paths()
    {
        $roots = [
            'root'         => $this->root(),
            //App
            'app'          => $this->root().'App/',
            'controllers'  => $this->root().'App/Controllers/',
            'locale'       => $this->root().'App/Locale/',
            'middleware'   => $this->root().'App/Middleware/',
            'models'       => $this->root().'App/Models/',
            //components
            'com'          => $this->root().'App/Components/',
            //config
            'config'       => $this->root().'Config/',
            //public
            'public'       => getcwd().'/',
            //routes
            'routes'       => $this->root().'routes/',
            //Storage
            'storage'      => [
                'storage'  => $this->root().'Storage/',
                'backup'   => $this->root().'Storage/Backup/',
                'data'     => $this->root().'Storage/'.__config('app.data_dir'),
                'cache'    => $this->root().'Storage/'.__config('app.cache_dir'),
                'session'  => $this->root().'Storage/'.__config('app.session_path'),
                'log'      => $this->root().'Storage/Logs/',
            ],
            'views'        => $this->root().__config('app.theme_path'),
        ];

        return $roots;
    }
}
