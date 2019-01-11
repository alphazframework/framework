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

namespace Zest\Site;

use Zest\http\Redirect;
use Zest\http\Request;

class Site
{
    private function requestInstance()
    {
        return new Request();
    }

    /**
     * Return site URL.
     *
     * @return string
     */
    public static function siteUrl()
    {
        $base_url = self::requestInstance()->getScheme().'://'.self::requestInstance()->getServerName().':'.self::requestInstance()->getServerPort().self::getUri();

        return $base_url;
    }

    /**
     * Return site base URL.
     *
     * @return string
     */
    public static function siteBaseUrl()
    {
        $base_url = self::requestInstance()->getScheme().'://'.self::requestInstance()->getServerName().':'.self::requestInstance()->getServerPort().self::getBase();

        return $base_url;
    }

    /**
     * Return Current Page.
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
     * @return string example.com/login
     */
    public function getBase()
    {
        return dirname(self::requestInstance()->getSelf());
    }

    /**
     * Get script path like example.com/login.
     *
     * @return string example.com/login
     */
    public static function getUri()
    {
        return parse_url(self::requestInstance()->getRequestUrl(), PHP_URL_PATH);
    }

    /**
     * Redirect to another page.
     *
     * @param (string) $url optional
     *                      self => itself page
     *                      prev => previous page
     *                      else => any page you want
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
     * @return void
     */
    private static function previous()
    {
        self::redirect(self::requestInstance()->getReference());
    }

    /**
     * Get all URL parts based on a / seperator.
     *
     * @param string $url → URI to segment
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
     * generate salts for files.
     *
     * @param string $length length of salts
     *
     * @return string
     */
    public static function salts($length)
    {
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        $stringlength = count($chars); //Used Count because its array now
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $chars[rand(0, $stringlength - 1)];
        }

        return $randomString;
    }
}
