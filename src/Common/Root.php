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
        return '../';
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
            'root' => $this->root(),
            //App
            'app'          => $this->root().'App/',
            'controllers'  => $this->root().'App/Controllers/',
            'locale'       => $this->root().'App/Locale/',
            'middleware'   => $this->root().'App/Middleware/',
            'models'       => $this->root().'App/Models/',
            'views'        => __config()->config->theme_path,
            //components
            'com' => $this->root().'App/Components/',
            //config
            'config' => $this->root().'Config/',
            //public
            'public' => $this->root().'public/',
            //routes
            'routes' => $this->root().'routes/',
            //Storage
            'storage'         => $this->root().'Storage/',
            'storage_backtup' => $this->root().'Storage/Backup/',
            'storage_data'    => __config()->config->data_dir,
            'cache_dir'       => __config()->config->cache_dir,
            'storage_logs'    => $this->root().'Storage/Logs/',
            'storage_session' => __config()->config->session_path,
        ];

        return Conversion::arrayObject($roots);
    }
}
