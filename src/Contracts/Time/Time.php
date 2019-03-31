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

namespace Zest\Contracts\Time;

interface Time
{

	/**
	 * Get "now" time
	 *
	 * @param string $timezone Valid php supported timezone.
	 *
	 * @since 3.0.0
	 *
	 * @return	int
	 */
	public function now($timezone = NULL);

	/**
	 * Number of days in a month
	 *
	 * @param int $month A numeric month.
	 * @param int $year	 A numeric year.
	 *
	 * @since 3.0.0
	 *
	 * @return	int
	 */
	public function daysInMonth($month = 1, $year = 1970);

	/**
	 * Determine whether the year is leap or not
	 *
	 * @param int $year	A numeric year.
	 *
	 * @since 3.0.0
	 *
	 * @return	bool
	 */	
	public function isLeapYear($year = null);

	/**
	 * Converts a timestamp to GMT
	 *
	 * @param int $time Unix timestamp
	 *
	 * @since 3.0.0
	 *
	 * @return	int
	 */
	public function timestampToGmt($time = null);

    /**
     * Converts the timestamp in to human readable form.
     *
     * @param (int|string) $time Timestamp or English textual datetime (http://php.net/manual/en/function.strtotime.php)
     *
     * @since 3.0.0
     *
     * @return mixed
     */
	public function friendlyTime($time);

    /**
     * Converts the timestamp in to ago form.
     *
     * @param (int|string) $time Timestamp or English textual datetime (http://php.net/manual/en/function.strtotime.php)
     *
     * @since 3.0.0
     *
     * @return mixed
     */
	public function ago($time);

    /**
     * Converts the timestamp in to h:m:s form.
     *
     * @param (int) $time Timestamp
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function formatsSeconds($seconds);
}
