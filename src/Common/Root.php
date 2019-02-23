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
 * @license MIT
 */

namespace Zest\Common;

use Zest\Data\Conversion;

class Root
{
    public function root()
    {
        return '../';
    }

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
            'views'        => $this->root().'App/Views/',
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
            'storage_data'    => $this->root().'Storage/Data/',
            'storage_logs'    => $this->root().'Storage/Logs/',
            'storage_session' => $this->root().'Storage/Session/',
        ];

        return Conversion::arrayObject($roots);
    }
}
