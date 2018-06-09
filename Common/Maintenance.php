<?php

namespace Softhub99\Zest_Framework\Common;

use Config\Config;

class Maintenance
{
    public function isMaintain()
    {
        if (file_exists(route()->root.'maintained')) {
            return true;
        } elseif (Config::Maintenance) {
            return true;
        } else {
            return false;
        }
    }

    public function updataMaintenance($status)
    {
        if ($status === 'on') {
            //TODO
        } elseif ($status === 'off') {
            //TODO
        }
    }

    public function run()
    {
        if (self::isMaintain()) {
            throw new \Exception('Sorry, Site is in maintenance mode', 503);
        }
    }
}
