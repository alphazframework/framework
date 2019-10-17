<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Common;

class OperatingSystem
{
    /**
     * Get the operating system name.
     *
     * @since 2.0.3
     *
     * @return string
     */
    public function get()
    {
        if (\defined(PHP_OS_FAMILY)) {
            return PHP_OS_FAMILY;
        } else {
            return $this->phpOs();
        }
    }

    /**
     * Get the operating system name.
     *
     * @since 2.0.3
     *
     * @return string
     */
    public function phpOs()
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
