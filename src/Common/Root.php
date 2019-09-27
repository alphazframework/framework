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
 * @since 1.9.7
 *
 * @license MIT
 */

namespace Zest\Common;

use Zest\Data\Conversion;

class Root
{
    /**
     * Return the root path of app.
     *
     * @since 1.9.1
     *
     * @return string
     */
    public function root()
    {
        return __ZEST__ROOT__.'/';
    }

    /**
     * Get the path.
     *
     * @since 1.9.7
     *
     * @return object
     */
    public function paths()
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
            'views'        => __config('app.theme_path'),
        ];

        return Conversion::arrayObject($roots);
    }
}
