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

namespace Zest\Language;

use Zest\Cookies\Cookies;
use Zest\Str\Str;

class Language
{
    /**
     * set the language.
     *
     * @param $value=> language symbol
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function setLanguage($value)
    {
        Cookies::set(['name'=>'lang', 'expir'=>time() + 100000, 'value'=>$value, 'domain'=>$_SERVER['SERVER_NAME'], 'path'=>'/', 'secure'=>false, 'httponly'=>false]);
    }

    /**
     * Get the current language.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function getLang()
    {
        if (Cookies::isCookie('lang')) {
            $language = Cookies::get('lang');
        } else {
            $language = \Config\Config::Language;
        }

        return $language;
    }

    /**
     * include lang string file.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function languageString()
    {
        $language = static::getLang();
        if (file_exists("../App//Locale/{$language}.php")) {
            return require "../App//Locale/{$language}.php";
        } else {
            return false;
        }
    }

    /**
     * for getting language key and return its value.
     *
     * @param $key language key
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function print($key)
    {
        if (!empty($key)) {
            if (array_key_exists(Str::stringConversion($key, 'lowercase'), static::languageString())) {
                return static::languageString()[Str::stringConversion($key, 'lowercase')];
            } else {
                return Str::stringConversion($key, 'lowercase');
            }
        } else {
            return false;
        }
    }

    /**
     * Only for debug purpose.
     *
     * @param =>$params (array)
     * 'allkeys'=>'on' ==> return all keys in array
     * 'search' => 'value' ==> return boolean true on find false not find Note: it only keys string in language file
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function debug($params)
    {
        if (is_array($params)) {
            if (isset($params['allkeys']) and Str::stringConversion($params['allkeys'], 'lowercase') === 'on') {
                return array_keys($this->languageString());
            }
            if (isset($params['search'])) {
                if (array_key_exists($params['search'], $this->languageString())) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
