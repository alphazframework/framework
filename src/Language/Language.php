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
     * @return string
     */
    public function setLanguage($value)
    {
        Cookies::set(['name'=>'lang', 'expir'=>time() + 100000, 'value'=>$value, 'domain'=>$_SERVER['SERVER_NAME'], 'path'=>'/', 'secure'=>false, 'httponly'=>false]);
    }

    /**
     * Get the current language.
     *
     * @return string
     */
    public function getLang()
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
     * @return string
     */
    public function languageString()
    {
        $data = $data1 = $data2 = [];
        $language = $this->getLang();
        if (file_exists(route()->locale."{$language}.php")) {
            $data1 += require route()->locale."{$language}.php";
        } 
        $path = route()->com;
        $disk_scan = array_diff(scandir($path), ['..', '.']);
        foreach ($disk_scan as $scans) {
            if (file_exists($path.$scans."/Locale/{$language}.php")) {
                $data2 += require $path.$scans."/Locale/{$language}.php";
            }
        }
        $data = array_merge($data1,$data2);

        return $data;        
    }

    /**
     * for getting language key and return its value.
     *
     * @param $key language key
     *
     * @return string
     */
    public function print($key)
    {
        if (!empty($key)) {
            if (array_key_exists(Str::stringConversion($key, 'lowercase'), $this->languageString())) {
                return $this->languageString()[Str::stringConversion($key, 'lowercase')];
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
     * @return string
     */
    public function debug($params)
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
