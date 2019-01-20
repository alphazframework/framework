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

namespace Zest\Encryption\Adapter;

class SodiumEncryption extends AbstractAdapter
{

    /**
     * __Construct.
     *
     * @since 3.0.0
     */
    public function __construct()
    {
        $this->key = sodium_crypto_secretbox_keygen();
    }

    /**
     * Encrypt the message.
     *
     * @param (mixed) $data data to be encrypted
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function encrypt($data)
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $token =  base64_encode($nonce.sodium_crypto_secretbox($data,$nonce,$this->key).'&&'.$this->key);

        return $token;       
    }

    /**
     * Decrypt the message.
     *
     * @param (mixed) $token encrypted token
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function decrypt($token)
    {
        $decoded = base64_decode($token);
        list($decoded, $this->key) = explode('&&', $decoded);
        if ($decoded === false) {
            throw new Exception('The decoding failed');
        }
        if (mb_strlen($decoded, '8bit') < (SODIUM_CRYPTO_SECRETBOX_NONCEBYTES + SODIUM_CRYPTO_SECRETBOX_MACBYTES)) {
            throw new \Exception('The token was truncated');
        }
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');

        $plain = sodium_crypto_secretbox_open($ciphertext,
        $nonce,$this->key );

        if ($plain === false) {
             throw new \Exception('The message was tampered with in transit');
        }

        return $plain;    
    }
}
