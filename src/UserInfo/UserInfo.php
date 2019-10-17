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
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\UserInfo;

class UserInfo
{
    /**
     * Get user agente.
     *
     * @since 1.0.0
     *
     * @return agent
     */
    public static function agent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * Get OperatingSystem name.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function operatingSystem()
    {
        $UserAgent = self::agent();
        if (preg_match_all('/windows/i', $UserAgent)) {
            $PlatForm = 'Windows';
        } elseif (preg_match_all('/linux/i', $UserAgent)) {
            $PlatForm = 'Linux';
        } elseif (preg_match('/macintosh|mac os x/i', $UserAgent)) {
            $PlatForm = 'Macintosh';
        } elseif (preg_match_all('/Android/i', $UserAgent)) {
            $PlatForm = 'Android';
        } elseif (preg_match_all('/iPhone/i', $UserAgent)) {
            $PlatForm = 'IOS';
        } elseif (preg_match_all('/ubuntu/i', $UserAgent)) {
            $PlatForm = 'Ubuntu';
        } else {
            $PlatForm = 'unknown';
        }

        return $PlatForm;
    }

    /**
     * Get Browser Name.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function browser()
    {
        $UserAgent = self::agent();
        if (preg_match_all('/Edge/i', $UserAgent)) {
            $Browser = 'Microsoft Edge';
            $B_Agent = 'Edge';
        } elseif (preg_match_all('/MSIE/i', $UserAgent)) {
            $Browser = 'Mozilla Firefox';
            $B_Agent = 'Firefox';
        } elseif (preg_match_all('/OPR/i', $UserAgent)) {
            $Browser = 'Opera';
            $B_Agent = 'Opera';
        } elseif (preg_match_all('/Opera/i', $UserAgent)) {
            $Browser = 'Opera';
            $B_Agent = 'Opera';
        } elseif (preg_match_all('/Chrome/i', $UserAgent)) {
            $Browser = 'Google Chrome';
            $B_Agent = 'Chrome';
        } elseif (preg_match_all('/Safari/i', $UserAgent)) {
            $Browser = 'Apple Safari';
            $B_Agent = 'Safari';
        } elseif (preg_match_all('/firefox/i', $UserAgent)) {
            $Browser = 'Mozilla Firefox';
            $B_Agent = 'Firefox';
        } else {
            $Browser = null;
            $B_Agent = null;
        }

        return [
            'browser' => $Browser,
            'agent'   => $B_Agent,
        ];
    }

    /**
     * Get Os version.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function oSVersion()
    {
        $UserAgent = self::agent();
        if (preg_match_all('/windows nt 10/i', $UserAgent)) {
            $OsVersion = 'Windows 10';
        } elseif (preg_match_all('/windows nt 6.3/i', $UserAgent)) {
            $OsVersion = 'Windows 8.1';
        } elseif (preg_match_all('/windows nt 6.2/i', $UserAgent)) {
            $OsVersion = 'Windows 8';
        } elseif (preg_match_all('/windows nt 6.1/i', $UserAgent)) {
            $OsVersion = 'Windows 7';
        } elseif (preg_match_all('/windows nt 6.0/i', $UserAgent)) {
            $OsVersion = 'Windows Vista';
        } elseif (preg_match_all('/windows nt 5.1/i', $UserAgent)) {
            $OsVersion = 'Windows Xp';
        } elseif (preg_match_all('/windows xp/i', $UserAgent)) {
            $OsVersion = 'Windows Xp';
        } elseif (preg_match_all('/windows me/i', $UserAgent)) {
            $OsVersion = 'Windows Me';
        } elseif (preg_match_all('/win98/i', $UserAgent)) {
            $OsVersion = 'Windows 98';
        } elseif (preg_match_all('/win95/i', $UserAgent)) {
            $OsVersion = 'Windows 95';
        } elseif (preg_match_all('/Windows Phone +[0-9]/i', $UserAgent, $match)) {
            $OsVersion = $match;
        } elseif (preg_match_all('/Android +[0-9]/i', $UserAgent, $match)) {
            $OsVersion = $match;
        } elseif (preg_match_all('/Linux +x[0-9]+/i', $UserAgent, $match)) {
            $OsVersion = $match;
        } elseif (preg_match_all('/mac os x [0-9]+/i', $UserAgent, $match)) {
            $OsVersion = $match;
        } elseif (preg_match_all('/os [0-9]+/i', $UserAgent, $match)) {
            $OsVersion = $match;
        }

        return isset($OsVersion) ? $OsVersion : false;
    }

    /**
     * Get Browser version.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function browserVersion()
    {
        $UserAgent = self::agent();
        $B_Agent = self::Browser()['agent'];
        if ($B_Agent !== null) {
            $known = ['Version', $B_Agent, 'other'];
            $pattern = '#(?<browser>'.implode('|', $known).
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            if (!preg_match_all($pattern, $UserAgent, $matches)) {
            }
            $i = count($matches['browser']);
            if ($i != 1) {
                if (strripos($UserAgent, 'Version') < strripos($UserAgent, $B_Agent)) {
                    $Version = $matches['version'][0];
                } else {
                    $Version = $matches['version'][0];
                }
            } else {
                $Version = $matches['version'][0];
            }
        }

        return $Version;
    }

    /**
     * Get The user ip.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_add = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWADED_FOR'])) {
            $ip_add = $_SERVER['HTTP_X_FORWADED_FOR'];
        } else {
            $ip_add = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_add;
    }
}
