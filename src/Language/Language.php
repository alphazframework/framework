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

namespace alphaz\Language;

use alphaz\http\Request;

class Language
{
    /* Use of language codes trait. */
    use LanguageCodesTrait;

    /**
     * Set the language.
     *
     * @param $value=> language symbol
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function setLanguage($value)
    {
        cookie_set('lang', $value, time() + 100000, '/', (new Request())->getServerName(), false, false);
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
            $language = (array_key_exists(get_cookie('lang'), $this->_languages)) ? get_cookie('lang') : __config('app.language');
        } else {
            $language = __config('app.language', 'en');
        }

        return $language;
    }

    /**
     * Get the language name by key.
     *
     * @param (string) $key valid key
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function getNameByKey($key)
    {
        return (array_key_exists($key, $this->_languages)) ? $this->_languages[$key] : null;
    }

    /**
     * Include lang string file.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function languageString()
    {
        $data = $data1 = $data2 = [];
        $language = $this->getLang();
        if (file_exists(route('locale')."{$language}.php")) {
            $data1 += require route('locale')."{$language}.php";
        }
        $path = route('com');
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
    public function print($key, $default = null)
    {
        if (!empty($key)) {
            return $this->languageString()[strtolower($key)] ?? $default;
        } else {
            return false;
        }
    }
}
