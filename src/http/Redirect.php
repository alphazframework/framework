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

namespace alphaz\http;

class Redirect extends HTTP
{
    /**
     * Send redirect.
     *
     * @param (string) $url
     * @param (int)    $code
     * @param (mixed)  $version
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct($url, $code = '302', $version = '1.1')
    {
        if (headers_sent()) {
            throw new \Exception('The headers have already been sent.');
        }

        if (!array_key_exists($code, self::$responseCodes)) {
            throw new \Exception('The header code '.$code.' is not allowed.');
        }

        header("HTTP/{$version} {$code} ".self::$responseCodes[$code]);
        header("Location: {$url}");

        //Need to stop current execution after redirect.
        exit();
    }
}
