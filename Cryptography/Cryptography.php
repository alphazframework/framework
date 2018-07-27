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
 *
 */

namespace Softhub99\Zest_Framework\Cryptography;

use Config\Config;
use Softhub99\Zest_Framework\Site\Site;

class Cryptography
{
    private static $secret_key;
    const CIPHER_16 = 'AES-128-CBC';
    const CIPHER_32 = 'AES-256-CBC';
    const DEFAULT = 32;

    public function encrypt($str, $cl = 32)
    {
        return static::encyptedDecypted('encrypt', $str, $cl);
    }

    public function decrypt($str, $cl = 32)
    {
        return static::encyptedDecypted('decrypt', $str, $cl);
    }

    public function encyptedDecypted($action, $str, $cl)
    {
        static::$secret_key = Config::CRYPTO_KEY;
        $cl = (int) $cl;

        if ($cl === 16) {
            $cipher = static::CIPHER_16;
            $length = 16;
        } elseif ($cl === 32) {
            $cipher = static::CIPHER_32;
            $length = static::DEFAULT;
        } else {
            $cipher = static::CIPHER_32;
            $length = static::DEFAULT;
        }
        $iv = $iv = substr(hash('sha256', static:: $secret_key), 0, $length);
        $key = hash('sha512', static::$secret_key);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($str, $cipher, $key, 0, $iv);
            $output = base64_encode($output);
            $output = static::securesalts($length).$output.static::securesalts($length);
        } elseif ($action == 'decrypt') {
            $str = $text = substr($str, $length, -$length);
            $output = openssl_decrypt(base64_decode($str), $cipher, $key, 0, $iv);
        }

        return $output;
    }

    private static function securesalts($length)
    {
        return Site::Salts($length);
    }
}
