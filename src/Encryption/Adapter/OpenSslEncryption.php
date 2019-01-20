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

namespace Zest\Encryption\Adapter;

class OpenSslEncryption
{
    /**
     * Store the secret key.
     *
     * @since 1.0.0
     *
     * @var key
     */
    private $key;

    /**
     * Store the cipher iv.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $iv;

    /**
     * Cipher.
     *
     * @since 1.0.0
     *
     * @var string
     */
    private $cipher = 'AES-256-CBC';

    /**
     * __Construct.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function __construct()
    {
        if (isset(__config()->encryption->openssl->key) && strtolower(__config()->encryption->openssl->key) !== 'your-key') {
            $this->iv = openssl_random_pseudo_bytes($this->iv_bytes($cipher));
            $this->key = hash('sha512', __config()->encryption->openssl->key);
        } else {
            throw new \Exception('Crypto key not found', 500);
        }
    }

    /**
     * Encrypt the message.
     *
     * @param $data => data to be encrypted
     *
     * @since 1.0.0
     *
     * @return token
     */
    public function encrypt($data)
    {
        return base64_encode(openssl_encrypt($data, $this->cipher, $this->key, 0, $this->iv).'&&'.bin2hex($this->iv));
    }

    /**
     * Decrypt the message.
     *
     * @param $token => encrypted token
     *
     * @since 1.0.0
     *
     * @return mix-data
     */
    public function decrypt($token)
    {
        $token = base64_decode($token);
        list($token, $this->iv) = explode('&&', $token);

        return openssl_decrypt($token, $this->cipher, $this->key, 0, hex2bin($this->iv));
    }

    /**
     * Get the length of cipher.
     *
     * @param $method
     *
     * @since 3.0.0
     *
     * @return int
     */
    protected function iv_bytes($method)
    {
        return openssl_cipher_iv_length($method);
    }
}
