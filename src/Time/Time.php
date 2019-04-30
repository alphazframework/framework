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
     * Converts the timestamp in to human readable form.
     *
     * @param int|string $time Timestamp or English textual datetime (http://php.net/manual/en/function.strtotime.php)
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function friendlyTime($time)
    {
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
