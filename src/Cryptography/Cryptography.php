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

namespace Zest\Cryptography;

use Config\Config;

class Cryptography
{
    private $secret_key;
    const CIPHER_16 = 'AES-128-CBC';
    const CIPHER_32 = 'AES-256-CBC';
    const DEFAULT = 32;

    public function encrypt($str, $cl = 32)
    {
        return $this->encyptedDecypted('encrypt', $str, $cl);
    }

    public function decrypt($str, $cl = 32)
    {
        return $this->encyptedDecypted('decrypt', $str, $cl);
    }

    public function encyptedDecypted($action, $str, $cl)
    {
        $this->secret_key = Config::CRYPTO_KEY;
        $cl = (int) $cl;

        if ($cl === 16) {
            $cipher = Cryptography::CIPHER_16;
            $length = 16;
        } elseif ($cl === 32) {
            $cipher = Cryptography::CIPHER_32;
            $length = Cryptography::DEFAULT;
        } else {
            $cipher = Cryptography::CIPHER_32;
            $length = Cryptography::DEFAULT;
        }
        $iv = $iv = substr(hash('sha256', $this->secret_key), 0, $length);
        $key = hash('sha512', $this->secret_key);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($str, $cipher, $key, 0, $iv);
            $output = base64_encode($output);
            $output = $output;
        } elseif ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($str), $cipher, $key, 0, $iv);
        }

        return $output;
    }
}
