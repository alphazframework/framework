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
        if (!function_exists('sodium_crypto_secretbox_keygen')) {
            throw new \Exception('The sodium php extension does not installed or enabled', 500);
        }

        if (isset(__config()->encryption->key) && strtolower(__config()->encryption->key) !== 'your-key') {

            //$this->key = sodium_crypto_secretbox_keygen();
            //Should use user define key.
            $this->key = substr(hash('sha512', __config()->encryption->key), 0, 32);
        } else {
            throw new \Exception('Crypto key not found', 500);
        }
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
        $token = base64_encode($nonce.sodium_crypto_secretbox($data, $nonce, $this->key).'&&'.$this->key);

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
        $nonce, $this->key);

        if ($plain === false) {
            throw new \Exception('The message was tampered with in transit');
        }

        return $plain;
    }
}
