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

namespace Zest\Component;

use Zest\Files\FileHandling;

class routes extends Component
{
    /**
     * Load the components.
     *
     * @since 1.9.7
     *
     * @return void
     */
    public static function loadComs()
    {
        $com = new Component();
        $path = '../App/Components/';
        $disk_scan = array_diff(scandir($path), ['..', '.']);
        foreach ($disk_scan as $scans) {
            $configFile = route()->com.$scans.'/component.json';
            if (file_exists($configFile)) {
                $file = new FileHandling();
                $c = $file->open($configFile, 'readOnly')->read($configFile);
                $config = json_decode($c, true);
                if ($config['status'] === true) {
                    require_once route()->com.$scans.'/routes.php';
                }
            }
        }
        require_once 'dispatcher.php';
    }
}
