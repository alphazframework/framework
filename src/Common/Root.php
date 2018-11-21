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

namespace Zest\Common;

use Zest\Data\Conversion;

class Root
{
    public static function path()
    {
        return '../';
    }

    public static function rootPaths()
    {
        $roots = [
            'root' => static::path(),
            //App
            'app'         => static::path().'App/',
            'controllers' => static::path().'App/Controllers/',
            'local'       => static::path().'App/local/',
            'middleware'  => static::path().'App/Middleware/',
            'models'      => static::path().'App/Models/',
            'views'       => static::path().'App/Views/',
            //components
            'com' => static::path().'App/Component/',
            //config
            'config' => static::path().'Config/',
            //public
            'public' => static::path().'public/',
            //routes
            'routes' => static::path().'routes/',
            //Storage
            'storage'         => static::path().'Storage/',
            'storage_backtup' => static::path().'Storage/Backup/',
            'storage_data'    => static::path().'Storage/Data/',
            'storage_logs'    => static::path().'Storage/Logs /',
            'storage_session' => static::path().'Storage/Session/',
        ];

        return Conversion::arrayObject($roots);
    }
}
