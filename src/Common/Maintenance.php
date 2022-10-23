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

class Maintenance
{
    /**
     * Check is the site maintaince mode is enable.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function isMaintain()
    {
        if (file_exists(route('root').'maintained')) {
            return true;
        } elseif (__config('app.maintenance', false)) {
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
     * @since 1.0.0
     *
     * @return void
     */
    public function updataMaintenance(bool $status)
    {
        if ($status) {
            if (!file_exists(route('root').'maintained')) {
                $fh = fopen(route('root').'maintained', 'w');
                fwrite($fh, 'maintained');
                fclose($fh);
            }
        } elseif (!$status) {
            if (file_exists(route('root').'maintained')) {
                unlink(route('root').'maintained');
            }
        } else {
            return false;
        }
    }

    /**
     * Run the site maintaince mode if enable.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function run()
    {
        if ($this->isMaintain()) {
            throw new \Exception('Sorry, Site is in maintenance mode', 503);
        }
    }
}
