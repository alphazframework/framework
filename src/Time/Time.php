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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Time;

use Zest\Common\TimeZone;
use Zest\Contracts\Time\Time as TimeContract;

class Time implements TimeContract
{
    /**
     * Get "now" time.
     *
     * @param string $timezone Valid php supported timezone.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public static function now($timezone = '')
    {
        TimeZone::seteDefaultTz($timezone);

        return time();
    }

    /**
     * Number of days in a month.
     *
     * @param int $month A numeric month.
     * @param int $year  A numeric year.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public static function daysInMonth($month = 1, $year = 1970)
    {
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }

    /**
     * Determine whether the year is leap or not.
     *
     * @param int $year A numeric year.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public static function isLeapYear($year = null)
    {
        $year = $year ?? date('Y');

        return (($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0);
    }

    /**
     * Converts a timestamp to GMT.
     *
     * @param int $time Unix timestamp
     *
     * @since 3.0.0
     *
     * @return int
     */
    public static function timestampToGmt($time = null)
    {
        $time = $time ?? time();
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($time)->modify('+2 hours');
        return $dateTime->format('d/m/Y H:i:s');

    }

    /**
     * Converts the timestamp in to ago form.
     *
     * @param int|string $time Timestamp or English textual datetime (http://php.net/manual/en/function.strtotime.php)
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function ago($time)
    {
        $time = self::formatTime($time);
        (int) $s = 60;
        (int) $hour = $s * $s;
        (int) $day = $hour * 24;
        (int) $week = $day * 7;
        (int) $month = $day * 30;
        (int) $year = $month * 12;
        if ($time <= 60) {
            $ago = ($time === 0 || $time === 1) ? ':just' : $time.' :secs';
        } elseif ($time >= $s && $time < $hour) {
            $ago = (round($time / $s) === 1) ? '1 :mint' : round($time / $s).' :mins';
        } elseif ($time >= $hour && $time < $day) {
            $ago = (round($time / $hour) === 1) ? '1 :hour' : round($time / $hour).'  :hours';
        } elseif ($time >= $day && $time < $week) {
            $ago = (round($time / $day) === 1) ? '1 :day' : round($time / $day).' :days';
        } elseif ($time >= $week && $time < $month) {
            $ago = (round($time / $week) === 1) ? '1 :week' : round($time / $week).' :weeks';
        } elseif ($time >= $month && $time < $year) {
            $ago = (round($time / $month) === 1) ? '1 :month' : round($time / $month).' :months';
        } elseif ($time >= $month) {
            $ago = (round($time / $month) === 1) ? '1 :year' : round($time / $month).' :years';
        }

        return $ago;
    }

    /**
     * Formats the time.
     *
     * @param (int|string) $time Timestamp or English textual datetime (http://php.net/manual/en/function.strtotime.php)
     *
     * @since 3.0.0
     * @author https://github.com/Maikuolan (https://github.com/zestframework/Zest_Framework/issues/131)
     *
     * @return int
     */
    protected static function formatTime($time)
    {
        $time = preg_match('~\D~', $time) ? strtotime($time) : $time;
        return time() - $time;
    }

    /**
     * Converts the timestamp in to h:m:s form.
     *
     * @param int    $time     Timestamp
     * @param string $timezone Valid php supported timezone.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function formatsSeconds($seconds, $timezone = '')
    {
        TimeZone::seteDefaultTz($timezone);

        return date('h:i:s', $seconds);
    }
}
