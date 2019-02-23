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
 * @license MIT
 *
 * @since 2.0.0
 */

namespace Zest\Benchmark;

interface BenchmarkInterface
{
    public function start();

    public function end();

    public function elapsedTime(int $round);
}
