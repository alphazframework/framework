<?php

namespace Softhub99\Zest_Framework\UserInfo;

class UserInfo
{
    /**
     * Get user agente.
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
     * @return void
     */
    public function operatingSystem()
    {
        $UserAgent = self::agent();
        if (preg_match_all('/windows/i', $UserAgent)) {
            $PlatForm = 'Windows';
        } elseif (preg_match_all('/lunix/i', $UserAgent)) {
            $PlatForm = 'Lunix';
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
     * @return void
     */
    public function browser()
    {
        $UserAgent = self::agent();
        if (preg_match_all('/Edge/i', $UserAgent)) {
            $Browser = 'Microsoft Edge';
            $B_Agent = 'Edge';
        } elseif (preg_match_all('/MSIE/i', $UserAgent)) {
            $Browser = 'Internet Explorer';
            $B_Agent = 'MSIE';
        } elseif (preg_match_all('/Firefox/i', $UserAgent)) {
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
        } elseif (preg_match_all('/Safari/i')) {
            $Browser = 'Apple Safari';
            $B_Agent = 'AppleWebKit';
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
        }

        return $oSVersion;
    }

    /**
     * Get Browser version.
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
                    $Version = $matches['version'][1];
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

        return $ip_add;
    }

    /**
     * Check user from mobile or not.
     *
     * @return void
     */
    public function isMobile()
    {
        $agent = self::agent();

        return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $agent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($agent, 0, 4))) ? true : false;
    }
}
