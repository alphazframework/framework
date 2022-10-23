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

namespace alphaz\Contracts\Common;

interface Root
{
    /**
     * Get the specified path value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function get($key, $default = null);
}
