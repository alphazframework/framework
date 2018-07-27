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

namespace Softhub99\Zest_Framework\Component;

class routes extends Component
{
    public function __construct()
    {
    }

    public function loadComs()
    {
        $com = new Component();
        $path = '../App/Components/';
        $disk_scan = array_diff(scandir($path), ['..', '.']);
        foreach ($disk_scan as $scans) {
            require_once '../App/Components/'.$scans.'/routes.php';
        }
        require_once 'dispatcher.php';
    }
}
