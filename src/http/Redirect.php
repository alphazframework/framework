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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\http;

class Redirect extends HTTP
{
    /**
     * Send redirect.
     *
     * @param  (string) $url
     *   	   (int) $code
     *   	   (mixed) $version
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function __construct($url, $code = '302', $version = '1.1')
    {
        if (headers_sent()) {
            throw new Exception('The headers have already been sent.');
        }

        if (!array_key_exists($code, self::$responseCodes)) {
            throw new Exception('The header code '.$code.' is not allowed.');
        }

        header("HTTP/{$version} {$code} ".self::$responseCodes[$code]);
        header("Location: {$url}");
    }
}