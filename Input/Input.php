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

namespace Softhub99\Zest_Framework\Input;

use Config\Config;
use Softhub99\Zest_Framework\CSRF\CSRF;
use Softhub99\Zest_Framework\View\View;

class Input
{
    private static $method;
    private static $csrf_method;

    public function __construct()
    {
    }

    /**
     * Wordwrap.
     *
     * @param  $str Str to be wordwraped
     *
     * @return string | boolean
     */
    public static function wordWrapEnable($str, $width)
    {
        if (!empty($str) && !empty($width) && $width >= 1) {
            return wordwrap($params['str'], $params['width'], '<br />\n');
        } else {
            return false;
        }
    }

    /**
     * Check form sbumit or not.
     *
     * @param  $name => name of submit button/ field
     *
     * @return bool
     */
    public static function isFromSubmit($name)
    {
        if (isset($_REQUEST[$name])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Accpet input
     * Support get.post,put.
     *
     * @param  $key
     * 'key' => name of filed (required in get,post request)
     *
     * @return string | boolean
     */
    public static function input($key)
    {
        static::$method = $_SERVER['REQUEST_METHOD'];
        if (isset(static::$method) && !empty(static::$method)) {
            if (isset($key) && !empty($key)) {
                if (static::$method === 'POST' && isset($_POST[$key])) {
                    $string = $_POST["$key"];
                } elseif (static::$method === 'GET' && isset($_GET[$key])) {
                    $string = $_GET[$key];
                } elseif (static::$method === 'PUT') {
                    parse_str(file_get_contents('php://input'), $_PUT);
                    $string = $_PUT[$key];
                } elseif (static::$method === 'DELETE') {
                    parse_str(file_get_contents('php://input'), $_DEL);
                    $string = $_DEL[$key];
                } elseif (static::$method === 'REQUEST') {
                    if (isset($_REQUEST[$key])) {
                        $string = $_REQUEST[$key];
                    }
                } else {
                    if (isset($_SERVER[$key])) {
                        $string = $_SERVER[$key];
                    }
                }
                if (isset($string) && !empty($string)) {
                    if (Config::AUTO_CSRF_VERIFIED) {
                        if (static::autoCsrf()) {
                            return $string;
                        } else {
                            return  View::view('errors/csrf');
                        }
                    } else {
                        return $string;
                    }

                    return $string;
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * Auto-validate csrf token.
     *
     * @return bool
     */
    public static function autoCsrf()
    {
        CSRF::action();
        if (self::csrfInput('csrf_token')) {
            $token = self::csrfInput('csrf_token');
            CSRF::action();
            CSRF::deleteUnnecessaryTokens();
            if (CSRF::verify($token)) {
                CSRF::delete($token);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Accpet csrf input
     * Support get.post,put,server.
     *
     * @param  $key
     * 'key' => name of filed (required in get,post request)
     *
     * @return string | boolean
     */
    public static function csrfInput($key)
    {
        static::$method = $_SERVER['REQUEST_METHOD'];
        if (isset(static::$method) && !empty(static::$method)) {
            if (isset($key) && !empty($key)) {
                if (static::$method === 'POST' && isset($_POST[$key])) {
                    $token = $_POST["$key"];
                } elseif (static::$method === 'GET' && isset($_GET[$key])) {
                    $token = $_GET[$key];
                } else {
                    $token = $_SERVER[$key];
                }
                if (isset($token)) {
                    return $token;
                }
            } else {
                return false;
            }
        }
    }

    /**
     * Clean input.
     *
     * @param  $params
     * 'input' => string
     * 'type' => secured , root
     *
     * @return string | boolean
     */
    public static function cleane($input, $type)
    {
        if (!empty($input)) {
            if (!empty($type)) {
                if ($type === 'secured') {
                    return  stripslashes(trim(htmlspecialchars(htmlspecialchars($input, ENT_HTML5), ENT_QUOTES)));
                } elseif ($type === 'root') {
                    return  stripslashes(trim(htmlspecialchars(htmlspecialchars(strip_tags($input), ENT_HTML5), ENT_QUOTES)));
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Restore new lines.
     *
     * @param  $params
     * 'str' => string that tobe restored new lines
     *
     * @return string | boolean
     */
    public static function restoreLineBreaks($str)
    {
        if (isset($str) and strlen($str) !== 0) {
            $result = str_replace(PHP_EOL, "\n\r<br />\n\r", $str);

            return $result;
        } else {
            return false;
        }
    }

    /**
     * Check request ajax or not.
     *
     * @return string | boolean
     */
    public static function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            return true;
        } else {
            return false;
        }
    }
}
