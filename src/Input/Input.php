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
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\Input;

use Zest\View\View;

class Input
{
    /**
     * method.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private static $method;

    /**
     * CSRF method.
     *
     * @since 3.0.0
     *
     * @var string
     */
    private static $csrf_method;

    /**
     * Wordwrap.
     *
     * @param  $str Str to be wordwraped
     *
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
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
                    return $string;
                } else {
                    return false;
                }
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
     * @since 1.0.0
     *
     * @return string | boolean
     */
    public static function clean($input, $type)
    {
        if (!empty($input)) {
            if (!empty($type)) {
                if ($type === 'secured') {
                    return stripslashes(trim(htmlspecialchars($input, ENT_QUOTES)));
                } elseif ($type === 'root') {
                    return stripslashes(trim(htmlspecialchars(htmlspecialchars(strip_tags($input), ENT_HTML5), ENT_QUOTES)));
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
     * @since 1.0.0
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
}
