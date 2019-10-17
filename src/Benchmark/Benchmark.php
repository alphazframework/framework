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
 * @since 2.0.0
 *
 * @license MIT
 */

namespace Zest\Benchmark;

use Zest\Contracts\Benchmark as BenchmarkContract;

class Benchmark implements BenchmarkContract
{
    /**
     * Store start time.
     *
     * @since 2.0.0
     *
     * @var int
     */
    private $start;

    /**
     * Store end time.
     *
     * @since 2.0.0
     *
     * @var int
     */
    private $end;

    /**
     * Start time.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function start()
    {
        $this->start = microtime(true);
    }

    /**
     * end time.
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function end()
    {
        $this->end = microtime(true);
    }

    /**
     * Get the elapsed time.
     *
     * @param (int) $round round.
     *
     * @since 2.0.0
     *
     * @return float
     */
    public function elapsedTime(int $round = null)
    {
        $time = $this->end - $this->start;
        if (!is_null($round)) {
            $time = round($time, $round);
        }

        return (float) $time;
    }
}
