<?php

namespace Softhub99\Zest_Framework\Common;

class OperatingSystem
{
    public static function get()
    {
        if (\define(PHP_OS_FAMILY)) {
            return PHP_OS_FAMILY;
        } else {
            return static::phpOs();
        }
    }

    public static function phpOs()
    {
        $os = PHP_OS;
        switch ($os) {
            case 'WINNT':
            case 'WINNT32':
            case 'WINNT64':
            case 'Windows':
                $c_os = 'Windows';
                break;
            case 'DragonFly':
            case 'FreeBSD':
            case 'NetBSD':
            case 'OpenBSD':
                $c_os = 'BSD';
                break;
            case 'Linux':
                $c_os = 'Linux';
                break;
            case 'SunOS':
                $c_os = 'Solaris';
                break;
            default:
                $c_os = 'Unknown';
                break;
         }

        return $c_os;
    }
}
