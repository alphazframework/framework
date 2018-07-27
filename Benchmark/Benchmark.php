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
 */

namespace Softhub99\Zest_Framework\Benchmark;

class Benchmark implements BenchmarkInterface
{
    public static $start;
    public static $end;

    public static function start()
    {
        static::$start = microtime(true);
    }

    public static function end()
    {
        static::$end = microtime(true);
    }

    public static function elapsedTime(int $round = null)
    {
        $time = static::$end - static::$start;
        if (!is_null($round)) {
            $time = round($time, $round);
        }

        return (float) $time;
    }
}
