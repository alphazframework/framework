<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Component\View;

class View extends \Zest\View\View
{
    /**
     * Rander the view.
     *
     * @param (string) $file    Name of files
     * @param (array)  $args    Attributes.
     * @param (bool)   $minify  Is code should be minify
     * @param (array)  $headers Custom headers.
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function rander($file, array $args = [], bool $minify = false, array $headers = [])
    {
        static::$isCom = true;
        self::view($file, $args, $minify);
    }
}
