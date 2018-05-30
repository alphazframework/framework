<?php
namespace Softhub99\Zest_Framework\Common;
use Softhub99\Zest_Framework\Data\Conversion;
class Root
{
    public static function path()
    {
        $path =   realpath(dirname(__FILE__));
        $patterns = array();
        $patterns[0] = '/vendor\\\\/';
        $patterns[1] = '/softhub99\\\\/';
        $patterns[2] = '/zest_framework\\\\/';
        $patterns[3] = '/Common/';
        $root = preg_replace($patterns,'',$path);
        return $root;
    }
    public function rootPaths(){
        $roots = [
            'root' => static::path(),
            //App
            'app' => static::path().'App\\',
            'controllers' => static::path().'App\Controllers\\',
            'local' => static::path().'App\local\\',
            'middleware' => static::path().'App\Middleware\\',
            'models' => static::path().'App\Models\\',
            'views' => static::path().'App\Views\\',
            //components
            'com' => static::path().'App\Component\\',
            //config
            'config' => static::path().'Config\\',
            //public
            'public' => static::path().'public\\',
            //routes
            'routes' => static::path().'routes\\',
            //Storage
            'storage' => static::path().'Storage\\',
            'storage_backtup' => static::path().'Storage\Backup\\',
            'storage_data' => static::path().'Storage\Data\\',
            'storage_logs' => static::path().'Storage\logs\\',
            'storage_session' => static::path().'Storage\Session\\',
        ];
        return Conversion::arrayObject($roots);
    }
}