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
 */

namespace Zest\Common;

class Formats
{
    /**
     * Formats the bytes in human readable form.
     *
     * @param $size The value that you want provided
     *        $pre round the value default 2
     *
     * @return mix-data
     */
    public function formatBytes($size, $pre = 2)
    {
        $base = log($size) / log(1024);
        $suffix = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $f_base = floor($base);

        return round(pow(1024, $base - floor($base)), $pre).$suffix[$f_base];
    }

    /**
     * Converts the timestamp in to human readable form.
     *
     * @param $time timespam or English textual datetime (http://php.net/manual/en/function.strtotime.php)
     *
     * @return mix-data
     */
    public function friendlyTime($time)
    {
        $time = (is_string($time)) ? strtotime($time) : $time;
        $time = time() - $time;
        (int) $s = 60;
        (int) $hour = $s * $s;
        (int) $day = $hour * 24;
        (int) $week = $day * 7;
        (int) $month = $day * 30;
        (int) $year = $month * 12;
        if ($time <= 60) {
            $ago = ($time === 0 || $time === 1) ? 'Just now' : $time.' secs ago';
        } elseif ($time >= $s && $time < $hour) {
            $ago = (round($time / $s) === 1) ? '1 min ago' : round($time / $s).' mins ago';
        } elseif ($time >= $hour && $time < $day) {
            $ago = (round($time / $hour) === 1) ? '1 hour ago' : round($time / $hour).' hours ago';
        } elseif ($time >= $day && $time < $week) {
            $ago = (round($time / $day) === 1) ? '1 day ago' : round($time / $day).' days ago';
        } elseif ($time >= $week && $time < $month) {
            $ago = (round($time / $week) === 1) ? '1 week ago' : round($time / $week).' weeks ago';
        } elseif ($time >= $month && $time < $year) {
            $ago = (round($time / $month) === 1) ? '1 month ago' : round($time / $month).' months ago';
        } elseif ($time >= $month) {
            $ago = (round($time / $month) === 1) ? '1 year ago' : round($time / $month).' years ago';
        }

        return $ago;
    }
}
