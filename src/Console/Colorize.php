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
    public $foreground = [
        'red'     => '31m',
        'green'   => '32m',
        'yellow'  => '33m',
        'blue'    => '34m',
        'magenta' => '35m',
        'cyan'    => '36m',
        'gray'    => [
            'light' => '37m',
            'dark'  => '90m',
        ],
        'white' => '1m',
    ];

    /**
     * Background colors.
     *
     * @since 3.0.0
     *
     * @var array
     */
    public $background = [
        'red'     => '41m',
        'green'   => '42m',
        'yellow'  => '53m',
        'blue'    => '44m',
        'magenta' => '45m',
        'cyan'    => '46m',
        'gray'    => [
            'light' => '47m',
            'dark'  => '100m',
        ],
        'white' => '1m',
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
    public function get($color, $background = false)
    {
        $arr = ($background) ? $this->background : $this->foreground;
        if (Arrays::has($arr, $color, '.')) {
            return Arrays::get($arr, $color, '.');
        }
    }
}
