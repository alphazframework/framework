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
use Zest\http\Response;

class View implements ViewContract
{
    /**
     * Is component.
     *
     * @since 3.0.0
     *
     * @var bool
     */
    protected static $isCom = false;

    /**
     * File.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected static $file = '';

    /**
     * Set file.
     *
     * @param $file file with path.
     *
     * @since 1.0.0
     *
     * @return void
     */
    protected static function setFile($file)
    {
        if (self::$isCom === false) {
            $incFile = __config()->config->theme_path.'/'.$file.'.php';
            if (file_exists($incFile)) {
                self::$file = $incFile;
            }
        } else {
            $incFile = route()->com.$file.'.php';
            if (file_exists($incFile)) {
                self::$file = $incFile;
            }
        }
    }

    /**
     * Render a view template.
     *
     * @param (string) $file Name of files.
     * @param (array)  $args Attributes.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function randerTemplate($file, $args = [])
    {
        if (!empty($file)) {
            self::setFile($file);
            extract($args, EXTR_SKIP);
            if (file_exists(self::$file)) {
                ob_start();
                require_once self::$file;
            } else {
                throw new \Exception("Sorry, view file {$file} not exists", 404);
            }
        } else {
            throw new \Exception('Sorry, file much be provided', 404);
        }
    }

    /**
     * Rander the view.
     *
     * @param (string) $file    Name of files
     * @param (array)  $args    Attributes.
     * @param (bool)   $minify  Is code should be minify
     * @param (array)  $headers Custom headers.
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function view($file, array $args = [], bool $minify = false, array $headers = [])
    {
        $headers['Content-Type'] = 'text/html';
        if ($minify === true) {
            $minify = new Minify();
            self::randerTemplate($file, $args);
            $config = [
                'body'    => $minify->htmlMinify(ob_get_clean(), 'code'),
                'headers' => [
                    $headers,
                ],
            ];
            $response = new Response($config);
            $response->send();
        } else {
            self::randerTemplate($file, $args);
            $config = [
                'body'    => ob_get_clean(),
                'headers' => [
                    $headers,
                ],
            ];
            $response = new Response($config);
            $response->send();
        }
    }

    /**
     * Compile.
     *
     * @todo future
     *
     * @return void
     */
    public function compile()
    {
    }
}
