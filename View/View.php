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

namespace Softhub99\Zest_Framework\View;

use Config\Config;
use Softhub99\Zest_Framework\Common\Minify;

class View
{
    //file
    private static $file;
    //key for template data
    private static $keys = [];
    //value for template data
    private static $Values = [];

    /**
     * Set file.
     *
     * @param $file name of files
     *
     * @return void
     */
    private static function setFile($file)
    {
        $file = Config::THEME_PATH.'/'.$file;
        if (file_exists($file)) {
            static::$file = $file;
        } else {
            return false;
        }
    }

    /**
     * Set attributes for template.
     *
     * @param $arrays
     *
     * @return booleans
     */
    public static function randerTemplate($file, $params = [])
    {
        if (!empty($file)) {
            static::setFile($file);
        } else {
            return false;
        }
        $keys = array_keys($params);
        $value = array_values($params);
        static::$keys = $keys;
        static::$Values = $value;

        return static::rander();
    }

    /**
     * Get content form file.
     *
     * @return raw-data
     */
    public static function fetchFile()
    {
        if (static::isFile()) {
            $file = static::$file;

            return file_get_contents($file);
        } else {
            return false;
        }
    }

    /**
     * Check file exists or not.
     *
     * @return bool
     */
    public static function isFile()
    {
        $file = static::$file;
        if (file_exists($file)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Rander template.
     *
     * @return raw-data
     */
    public static function rander()
    {
        $file = static::fetchFile();
        $CountKeys = count(static::$keys);
        $CountValues = count(static::$Values);
        if ($CountKeys === $CountValues && static::IsFile()) {
            $counter = $CountKeys = $CountValues;
            for ($i = 0; $i < $counter; $i++) {
                $keys = static::$keys[$i];
                $values = static::$Values[$i];
                $tag = "{% $keys %}";
                $pattern = "/$tag/";
                $file = preg_replace("/$tag/i", $values, $file);
            }

            return $file;
        } else {
            return false;
        }
    }

    public function views($file, array $args = [])
    {
        if (!empty($file)) {
            extract($args, EXTR_SKIP);
            $file = Config::THEME_PATH.'/'.$file.'.php';
            if (file_exists($file)) {
                ob_start();
                require_once $file;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function view($file, array $args = [], $minify = true)
    {
        if ($minify) {
            $minify = new Minify();
            self::views($file, $args);
            echo $minify->htmlMinify(ob_get_clean(), 'code');
        } else {
            self::views($file, $args);
            echo ob_get_clean();
        }
    }
}
