<?php

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
