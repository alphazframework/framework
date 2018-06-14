<?php

namespace Softhub99\Zest_Framework\UserInfo;

class UserInfo
{
    /**
     * For stroring user agent.
     */
    private $UserAgent;
    /**
     * For stroring Browser name.
     */
    private $Browser;
    /**
     * For stroring platform name.
     */
    private $PlatForm;
    /**
     * For stroring browser name.
     */
    private $Version;
    /**
     * For stroring Browser agent.
     */
    private $B_Agent;
    /**
     * For stroring user ip.
     */
    private static $Ip;
    /**
     * For stroring OsVersion.
     */
    private $OsVersion;

    /**
     * __construct.
     *
     * @return void
     */
    public function __construct()
    {
        $this->UserAgent = $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * Free the memory.
     *
     * @return void
     */
    public function free()
    {
        unset($this->UserAgent);
        unset($this->Browser);
        unset($this->PlatForm);
        unset($this->Version);
        unset($this->B_Agent);
        unset($this->Ip);
        unset($this->OsVersion);
    }

    /**
     * Get OperatingSystem name.
     *
     * @return void
     */
    public function operatingSystem()
    {
        if (preg_match_all('/windows/i', $this->UserAgent)) {
            $this->PlatForm = 'Windows';
        } elseif (preg_match_all('/lunix/i', $this->UserAgent)) {
            $this->PlatForm = 'Lunix';
        } elseif (preg_match('/macintosh|mac os x/i', $this->UserAgent)) {
            $this->PlatForm = 'Macintosh';
        } elseif (preg_match_all('/Android/i', $this->UserAgent)) {
            $this->PlatForm = 'Android';
        } elseif (preg_match_all('/iPhone/i', $this->UserAgent)) {
            $this->PlatForm = 'IOS';
        } elseif (preg_match_all('/ubuntu/i', $this->UserAgent)) {
            $this->PlatForm = 'Ubuntu';
        } else {
            $this->PlateFOrm = null;
        }
    }

    /**
     * Get Browser Name.
     *
     * @return void
     */
    public function browser()
    {
        if (preg_match_all('/MSIE/i', $this->UserAgent)) {
            $this->Browser = 'Internet Explorer';
            $this->B_Agent = 'MSIE';
        } elseif (preg_match_all('/Firefox/i', $this->UserAgent)) {
            $this->Browser = 'Mozilla Firefox';
            $this->B_Agent = 'Firefox';
        } elseif (preg_match_all('/OPR/i', $this->UserAgent)) {
            $this->Browser = 'Opera';
            $this->B_Agent = 'Opera';
        } elseif (preg_match_all('/Opera/i', $this->UserAgent)) {
            $this->Browser = 'Opera';
            $this->B_Agent = 'Opera';
        } elseif (preg_match_all('/Chrome/i', $this->UserAgent)) {
            $this->Browser = 'Google Chrome';
            $this->B_Agent = 'Chrome';
        } elseif (preg_match_all('/Safari/i', $this->UserAgent)) {
            $this->Browser = 'Apple Safari';
            $this->B_Agent = 'Safari';
        } elseif (preg_match_all('/Safari/i')) {
            $this->Browser = 'Apple Safari';
            $this->B_Agent = 'AppleWebKit';
        } else {
            $this->Browser = null;
            $this->B_Agent = null;
        }
    }

    /**
     * Get Os version.
     *
     * @return void
     */
    public function oSVersion()
    {
        if (preg_match_all('/windows nt 10/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows 10';
        } elseif (preg_match_all('/windows nt 6.3/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows 8.1';
        } elseif (preg_match_all('/windows nt 6.2/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows 8';
        } elseif (preg_match_all('/windows nt 6.1/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows 7';
        } elseif (preg_match_all('/windows nt 6.0/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows Vista';
        } elseif (preg_match_all('/windows nt 5.1/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows Xp';
        } elseif (preg_match_all('/windows xp/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows Xp';
        } elseif (preg_match_all('/windows me/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows Me';
        } elseif (preg_match_all('/win98/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows 98';
        } elseif (preg_match_all('/win95/i', $this->UserAgent)) {
            $this->OsVersion = 'Windows 95';
        } elseif (preg_match_all('/Windows Phone +[0-9]/i', $this->UserAgent, $match)) {
            $this->OsVersion = $match;
        } elseif (preg_match_all('/Android +[0-9]/i', $this->UserAgent, $match)) {
            $this->OsVersion = $match;
        }
    }

    /**
     * Get Browser version.
     *
     * @return void
     */
    public function browserVersion()
    {
        self::Browser();
        if ($this->B_Agent !== null) {
            $known = ['Version', $this->B_Agent, 'other'];
            $pattern = '#(?<browser>'.implode('|', $known).
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            if (!preg_match_all($pattern, $this->UserAgent, $matches)) {
            }
            $i = count($matches['browser']);
            if ($i != 1) {
                if (strripos($ $this->UserAgent, 'Version') < strripos($ $this->UserAgent, $this->B_Agent)) {
                    $this->Version = $matches['version'][0];
                } else {
                    $this->Version = $matches['version'][1];
                }
            } else {
                $this->Version = $matches['version'][0];
            }
        }
    }

    /**
     * Get The user ip.
     *
     * @return void
     */
    public function ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_add = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['        HTTP_X_FORWADED_FOR'])) {
            $ip_add = $_SERVER['HTTP_X_FORWADED_FOR'];
        } else {
            $ip_add = $_SERVER['REMOTE_ADDR'];
        }
        static::$Ip = $ip_add;

        return static::$Ip;
    }

    /**
     * Get The information.
     *
     * @return void
     */
    public function info()
    {
        self::operatingSystem();
        self::browser();
        self::ip();
        self::browserVersion();
        self::sSVersion();

        return [
            'Browser'         => $this->Browser,
            'OperatingSystem' => $this->PlatForm,
            'Version'         => $this->Version,
            'Ip'              => $this->Ip,
            'Os Version '     => $this->OsVersion,
         ];
    }
}
