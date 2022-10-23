<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 1.0.0
 *
 * @license MIT
 */

namespace alphaz\Site;

use alphaz\http\Redirect;
use alphaz\http\Request;

class Site
{
    /**
     * Get the Request instance.
     *
     * @since 1.0.0
     *
     * @return object
     */
    private static function requestInstance()
    {
        return new Request();
    }

    /**
     * Return site URL.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function siteUrl()
    {
        $base_url = self::requestInstance()->getDeterminedScheme().'://'.self::requestInstance()->getServerName().':'.self::requestInstance()->getServerPort().self::getUri();

        return $base_url;
    }

    /**
     * Return site base URL.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function siteBaseUrl()
    {
        $base_url = self::requestInstance()->getDeterminedScheme().'://'.self::requestInstance()->getServerName().':'.self::requestInstance()->getServerPort().self::getBase();

        return $base_url;
    }

    /**
     * Return Current Page.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function crrentPage()
    {
        $base_url = self::getUri();

        return $base_url;
    }

    /**
     * Get script path like example.com/login.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function getBase()
    {
        return preg_replace('{/$}', '', dirname(self::requestInstance()->getSelf()));
    }

    /**
     * Get script path like example.com/login.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function getUri()
    {
        return parse_url(self::requestInstance()->getRequestUrl(), PHP_URL_PATH);
    }

    /**
     * Redirect to another page.
     *
     * @param (string) $url url to be redirected.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function redirect($url = null)
    {
        if ($url === null or empty($url)) {
            $base_url = self::siteBaseUrl();
        } elseif ($url === 'self') {
            $base_url = self::siteUrl();
        } elseif ($url === 'prev') {
            $base_url = self::previous();
        } else {
            $base_url = $url;
        }
        ob_start();
        (new Redirect($base_url, 200));
    }

    /**
     * Go to the previous URL.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private static function previous()
    {
        self::redirect(self::requestInstance()->getReference());
    }

    /**
     * Get all URL parts based on a / seperator.
     *
     * @param (string) $url URI to segment.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function segmentUrl($url = null)
    {
        if (!is_null($url) && !empty($url)) {
            $url = $url;
        } else {
            $url = self::requestInstance()->getRequestUrl();
        }

        return explode('/', trim($url, '/'));
    }

    /**
     * Get first item segment.
     *
     * @param (mixed) $segments Url segments.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function getFirstSegment($segments)
    {
        if (is_array($segments)) {
            $vars = $segments;
        } else {
            $vars = self::segmentUrl($segments);
        }

        return current($vars);
    }

    /**
     * Get last item segment.
     *
     * @param (mixed) $segments Url segments.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function setLastSegment($segments)
    {
        if (is_array($segments)) {
            $vars = $segments;
        } else {
            $vars = self::segmentUrl($segments);
        }

        return end($vars);
    }

    /**
     * Generate salts.
     *
     * @param (int)  $length  Length of salts.
     * @param (bool) $special Should special chars include or not.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function salts(int $length, bool $special = false)
    {
        $s = ($special === true) ? ['@', '#', '$', '%', '^', '&', '*', '-', '_'] : [];
        $chars = array_merge(
            range(0, 9),
            range('a', 'z'),
            $s,
            range('A', 'Z'),
            range(0, 9),
            $s
        );
        $stringlength = count($chars); //Used Count because its array now
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $chars[rand(0, $stringlength - 1)];
        }

        return $randomString;
    }
}
