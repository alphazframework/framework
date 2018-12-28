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
    /*
     * Store the secret key
    */
    private $key;
    /*
     * Store the iv cipher
    */
    private $iv;
    /*
     * Cipher
    */
    private $cipher = 'AES-256-CBC';

    /**
     * __Construct.
     *
     * @return void
     */
    public function __construct()
    {
        $this->iv = openssl_random_pseudo_bytes($this->iv_bytes($cipher));
        $this->key = hash('sha512', Config::CRYPTO_KEY);

    }

    /**
     * Encrypt the message.
     *
     * @param $data => data to be encrypted
     *
     * @return token
     */
    public function encrypt($data)
    {
        return base64_encode(openssl_encrypt($data, $this->cipher, $this->key, 0, $this->iv) . "&&" . bin2hex($this->iv));
    }

    /**
     * Decrypt the message.
     *
     * @param $token => encrypted token
     *
     * @return mix-data
     */    
    public function decrypt($token)
    {
        $token = base64_decode($token);
        list($token, $this->iv) = explode("&&", $token);
        return openssl_decrypt($token, $this->cipher, $this->key, 0,hex2bin($this->iv));

    }

    /**
     * Get the length of cipher.
     *
     * @param $method
     *
     * @return int
     */
    protected function iv_bytes($method)
    {
        return openssl_cipher_iv_length($method);
    }

}
