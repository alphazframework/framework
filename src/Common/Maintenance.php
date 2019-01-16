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
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Common;

use Config\Config;

class Maintenance
{
    /**
     * Check is the site maintaince mode is enable.
     *
     * @since 2.0.3
     *
     * @return bool
     */
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

    /**
     * Upgrade the maintaince mode dynamically.
     *
     * @param (bool) $status
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function updataMaintenance(bool $status)
    {
        if ($status) {
            if (!file_exists(route()->root.'maintained')) {
                $fh = fopen(route()->root.'maintained', 'w');
                fwrite($fh, 'maintained');
                fclose($fh);
            }
        } elseif (!$status) {
            if (file_exists(route()->root.'maintained')) {
                unlink(route()->root.'maintained');
            }
        } else {
            return false;
        }
    }

    /**
     * Run the site maintaince mode if enable.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function run()
    {
        if (self::isMaintain()) {
            throw new \Exception('Sorry, Site is in maintenance mode', 503);
        }
    }
}
