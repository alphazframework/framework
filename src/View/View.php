<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\View;

use Zest\Common\Minify;
use Zest\Contracts\View\View as ViewContract;

class View implements ViewContract
{
    /**
     * files.
     *
     * @since 1.0.0
     *
     * @var resource
     */
    private static $file;
    /**
     * key for tamplate.
     *
     * @since 1.0.0
     *
     * @var array
     */
    private static $keys = [];
    /**
     * value for tamplet.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private static $Values = [];

    /**
     * Set file.
     *
     * @param $file name of files
     *
     * @since 1.0.0
     *
     * @return void
     */
    private static function setFile($file)
    {
        $file = __config()->config->theme_path.'/'.$file;
        if (file_exists($file)) {
            static::$file = $file;
        } else {
            return false;
        }
    }

    /**
     * Set the attribute for tamplet.
     *
     * @param $file name of files
     *        $params attributes
     *
     * @since 1.0.0
     *
     * @return void
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
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
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

    /**
     * views.
     *
     * @param $file name of files
     *        $args argoument need to be passed
     *
     * @since 1.0.0
     *
     * @return buffer
     */
    public static function views($file, array $args = [])
    {
        if (!empty($file)) {
            extract($args, EXTR_SKIP);
            $file = __config()->config->theme_path.'/'.$file.'.php';
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

    /**
     * Set file.
     *
     * @param $file name of files
     *        $args argoument need to be passed
     *        $minify is code should be minify
     *
     * @since 1.0.0
     *
     * @return bugger
     */
    public static function view($file, array $args = [], $minify = true)
    {
        if ($minify === true) {
            $minify = new Minify();
            self::views($file, $args);
            echo $minify->htmlMinify(ob_get_clean(), 'code');
        } else {
            self::views($file, $args);
            echo ob_get_clean();
        }
    }
}
