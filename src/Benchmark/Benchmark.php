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
 *
 * @since 2.0.0
 */

namespace Zest\Benchmark;

class Benchmark implements BenchmarkInterface
{
    private $start;
    private $end;

    public function start()
    {
        $this->start = microtime(true);
    }

    public function end()
    {
        $this->end = microtime(true);
    }

    public function elapsedTime(int $round = null)
    {
        $time = $this->end - $this->start;
        if (!is_null($round)) {
            $time = round($time, $round);
        }

        return (float) $time;
    }
}
