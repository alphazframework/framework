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
 *
 */

namespace Softhub99\Zest_Framework\CSRF;

use Softhub99\Zest_Framework\Site\Site;

class CSRF
{
    //default time
    private static $time;
    //System time
    private static $sysTime;

    /**
     * Do some important actions.
     *
     *
     * @return Void;
     */
    public static function action()
    {
        //delete expires tokens
        self::deleteExpires();
        //update system time
        self::updateSysTime();
        //session handler
        self::generateSession();
    }

    /**
     * Delete token with $keye.
     *
     * @key = $key token tobe deleted
     *
     * @return void;
     */
    public static function delete($token)
    {
        if (isset($_SESSION['security']['csrf'][$token])) {
            unset($_SESSION['security']['csrf'][$token]);
        }
    }

    /**
     * Delete expire tokens.
     *
     *
     * @return void;
     */
    public static function deleteExpires()
    {
        if (isset($_SESSION['security']['csrf'])) {
            foreach ($_SESSION['security']['csrf'] as $token => $value) {
                if (time() >= $value) {
                    unset($_SESSION['security']['csrf'][$token]);
                }
            }
        }
    }

    /**
     * Delete unnecessary tokens.
     *
     *
     * @return void;
     */
    public static function deleteUnnecessaryTokens()
    {
        $total = self::countsTokens();
        $delete = $total - 1;
        $tokens_deleted = $_SESSION['security']['csrf'];
        $tokens = array_slice($tokens_deleted, 0, $delete);
        foreach ($tokens as $token => $time) {
            self::delete($token);
        }
    }

    /**
     * Debug
     *	return all tokens.
     *
     * @return json object;
     */
    public static function debug()
    {
        echo json_encode($_SESSION['security']['csrf'], JSON_PRETTY_PRINT);
    }

    /**
     * Update time.
     *
     * @time = $time tobe updated
     *
     * @return bolean;
     */
    public static function updateTime($time)
    {
        if (is_int($time) && is_numeric($time)) {
            static::$time = $time;

            return static::$time;
        } else {
            return false;
        }
    }

    /**
     * Update system time.
     *
     * @return void;
     */
    final private function updateSysTime()
    {
        static::$sysTime = time();
    }

    /**
     * generate salts for files.
     *
     * @param string $length length of salts
     *
     * @return string;
     */
    public static function generateSalts($length)
    {
        return Site::salts($length);
    }

    /**
     * Generate tokens.
     *
     *@param
     *$time => $time
     *$multiplier => 3*3600
     *
     * @return mix-data;
     */
    public static function generateTokens($time, $multiplier)
    {
        self::action();
        $key = self::generateSalts(100);
        $utime = self::updateTime($time);
        $value = static::$sysTime + ($utime * $multiplier);
        $_SESSION['security']['csrf'][$key] = $value;

        return $key;
    }

    /**
     * Generate empty session.
     *
     * @return void;
     */
    public static function generateSession()
    {
        if (!isset($_SESSION['security']['csrf'])) {
            $_SESSION['security']['csrf'] = [];
        }
    }

    /**
     * View token.
     *
     * @token = $key
     *
     * @return mix-data;
     */
    public static function view($token)
    {
        static::action();
        if (isset($_SESSION['security']['csrf'][$token])) {
            return $_SESSION['security']['csrf'][$token];
        } else {
            return false;
        }
    }

    /**
     * Verify token exists or not.
     *
     * @token = $key
     *
     * @return boolean;
     */
    public static function verify($token)
    {
        if (isset($_SESSION['security']['csrf'][$token])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Last token.
     *
     * @return mix-data;
     */
    public static function lastToken()
    {
        if (isset($_SESSION['security']['csrf'])) {
            return end($_SESSION['security']['csrf']);
        } else {
            return false;
        }
    }

    /**
     * Count tokens.
     *
     * @return int;
     */
    public static function countsTokens()
    {
        if (isset($_SESSION['security']['csrf'])) {
            return count($_SESSION['security']['csrf']);
        } else {
            return 0;
        }
    }
}
