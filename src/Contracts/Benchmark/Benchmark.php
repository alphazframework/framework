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
 * @since 2.0.0
 *
 * @license MIT
 */

namespace Zest\Contracts\Benchmark;

interface Benchmark
{
    public function start();

    public function end();

    public function elapsedTime(int $round);
}
