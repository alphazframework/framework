<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * @author Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Console;

use Zest\Data\Arrays;

class Colorize
{
    /**
     * Foregroud colors.
     *
     * @since 3.0.0
     *
     * @var array
     */
    public $styles = [
        'bold'          => '1m',
        'faded'         => '2m',
        'underlined'    => '4m',
        'blinking'      => '5m',
        'reversed'      => '7m',
        'hidden'        => '8m',
        'red'           => '31m',
        'green'         => '32m',
        'yellow'        => '33m',
        'blue'          => '34m',
        'magenta'       => '35m',
        'cyan'          => '36m',
        'light_gray'    => '37m',
        'dark_gray'     => '90m',
        'white'         => '0m',
        'bg:red'        => '41m',
        'bg:green'      => '42m',
        'bg:yellow'     => '53m',
        'bg:blue'       => '44m',
        'bg:magenta'    => '45m',
        'bg:cyan'       => '46m',
        'bg:light_gray' => '47m',
        'bg:dark_gray'  => '100m',
        'bg:white'      => '0m',
    ];

    /**
     * Get the color by key.
     *
     * @param string $color      Color key
     * @param bool   $background
     *
     * @since 3.0.0
     *
     * @var string
     */
    public function get(string $style)
    {
        if (Arrays::has($this->styles, $style, '.')) {
            return Arrays::get($this->styles, $style, '.');
        }
    }
}
