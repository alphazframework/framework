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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Common;

class Formats
{
    /**
     * Formats the bytes in human readable form.
     *
     * @param (int) $size The value that you want provided
     * @param (int) $pre  round the value default 2
     *
     * @since 3.0.0
     *
     * @return mixed
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
     * @param (int|string) $time Timestamp or English textual datetime (http://php.net/manual/en/function.strtotime.php)
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function friendlyTime($time)
    {
        $time = $this->formatTime($time);
        $s = 60;
        $hour = $s * $s;
        (int) $day = $hour * 24;
        (int) $week = $day * 7;
        (int) $month = $day * 30;
        (int) $year = $month * 12;
        if ($time <= 60) {
            $ago = ($time === 0 || $time === 1) ? printl('z:format:just:now') : sprintf(printl('z:format:secs'), $time).' '.printl('z:format:ago');
        } elseif ($time >= $s && $time < $hour) {
            $ago = (round($time / $s) === 1) ? '1 '.printl('z:format:min').' '.printl('z:format:ago') : sprintf(printl('z:format:mints'), round($time / $s)).' '.printl('z:format:ago');
        } elseif ($time >= $hour && $time < $day) {
            $ago = (round($time / $hour) === 1) ? '1 '.printl('z:format:hour').' '.printl('z:format:ago') : sprintf(printl('z:format:hours'), round($time / $hour)).' '.printl('z:format:ago');
        } elseif ($time >= $day && $time < $week) {
            $ago = (round($time / $day) === 1) ? '1 '.printl('z:format:day').' '.printl('z:format:ago') : sprintf(printl('z:format:days'), round($time / $day)).' '.printl('z:format:ago');
        } elseif ($time >= $week && $time < $month) {
            $ago = (round($time / $week) === 1) ? '1 '.printl('z:format:week').' '.printl('z:format:ago') : sprintf(printl('z:format:weeks'), round($time / $week)).' '.printl('z:format:ago');
        } elseif ($time >= $month && $time < $year) {
            $ago = (round($time / $month) === 1) ? '1 '.printl('z:format:month').' '.printl('z:format:ago') : sprintf(printl('z:format:months'), round($time / $month)).' '.printl('z:format:ago');
        } elseif ($time >= $month) {
            $ago = (round($time / $month) === 1) ? '1 '.printl('z:format:year').' '.printl('z:format:ago') : sprintf(printl('z:format:years'), round($time / $year)).' '.printl('z:format:ago');
        }

        return $ago;
    }

    /**
     * Formats the time.
     *
     * @param (int|string) $time Timestamp or English textual datetime (http://php.net/manual/en/function.strtotime.php)
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function formatTime($time)
    {
        $time = preg_match('~\D~', $time) ? strtotime($time) : $time;

        return time() - $time;
    }

    /**
     * Converts the timestamp in to h:m:s form.
     *
     * @param (int) $time Timestamp
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function formatsSeconds($seconds)
    {
        $h = ($seconds >= 3600) ? (int) round($seconds / 3600) : 0;
        $time = ($seconds >= 3600) ? $seconds % 3600 : $seconds;
        $m = (int) $time / 60;
        $s = (int) $time % 60;

        return (int) $h.':'.(int) $m.':'.(int) $s;
    }
}
