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
    public function setLanguage($value)
    {
        cookie_set('lang', $value, time() + 100000, '/', $_SERVER['SERVER_NAME'], false, false);
    }

    /**
     * Get the current language.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function getLang()
    {
        if (is_cookie('lang')) {
            $language = get_cookie('lang');
        } else {
            $language = __config()->config->language;
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
        $data = array_merge($data1, $data2);

        return $data;
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
    public function print($key)
    {
        if (!empty($key)) {
            if (array_key_exists(strtolower($key), $this->languageString())) {
                return $this->languageString()[strtolower($key)];
            } else {
                return strtolower($key);
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
    public function debug($params)
    {
        if (is_array($params)) {
            if (isset($params['allkeys']) and strtolower($params['allkeys']) === 'on') {
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
