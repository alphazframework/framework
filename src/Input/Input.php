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

namespace alphaz\Input;

use alphaz\http\Request;

class Input
{
    /**
     * Wordwrap.
     *
     * @param (string) $str Str to be wordwraped
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function wordWrapEnable($str, $width)
    {
        if (!empty($str) && !empty($width) && $width >= 1) {
            return wordwrap($str, $width, '<br />\n');
        } else {
            return false;
        }
    }

    /**
     * Check form sbumit or not.
     *
     * @param (string) $name name of submit button/ field
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
     * Support get.post,put,patch,delete,others.
     *
     * @param (string) $key name of filed (required in get,post request)
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function input($key)
    {
        $request = new Request();
        if ($request->isGet() || $request->isHead()) {
            $string = $request->getQuery($key);
        } elseif ($request->isPost()) {
            $string = $request->getPost($key);
        } elseif ($request->isPatch()) {
            $string = $request->getPatch($key);
        } elseif ($request->isPut()) {
            $string = $request->getPut($key);
        } elseif ($request->isDelete()) {
            $string = $request->getDelete($key);
        } elseif ($request->hasFiles()) {
            $string = $request->getFiles($key);
        } else {
            parse_str(file_get_contents('php://input'), $_STR);
            $string = $_STR[$key];
        }

        return (isset($string) && !empty($string)) ? $string : false;
    }

    /**
     * Accpet input
     * Support get.post,put,patch,delete,others.
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function inputAll()
    {
        $request = new Request();
        if ($request->isGet() || $request->isHead()) {
            $string = $request->getQuery();
        } elseif ($request->isPost()) {
            $string = $request->getPost();
        } elseif ($request->isPatch()) {
            $string = $request->getPatch();
        } elseif ($request->isPut()) {
            $string = $request->getPut();
        } elseif ($request->isDelete()) {
            $string = $request->getDelete();
        } elseif ($request->hasFiles()) {
            $string = $request->getFiles();
        } else {
            parse_str(file_get_contents('php://input'), $_STR);
            $string = $_STR;
        }

        return (isset($string) && !empty($string)) ? $string : false;
    }

    /**
     * Clean input.
     *
     * @param (string) $input string
     * @param (string) $type  secured,root
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function clean($input, $type)
    {
        if (!empty($input)) {
            if (!empty($type)) {
                if ($type === 'secured') {
                    return stripslashes(trim(htmlentities($input, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
                } elseif ($type === 'root') {
                    return stripslashes(trim(htmlentities(htmlspecialchars(strip_tags($input), ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Decode HTML entity.
     *
     * @param (string) $input string.
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function decodeHtmlEntity($input)
    {
        return html_entity_decode($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Restore new lines.
     *
     * @param (string) $str string that tobe restored new lines
     *
     * @since 1.0.0
     *
     * @return mixed
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
