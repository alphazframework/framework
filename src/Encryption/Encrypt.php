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

namespace alphaz\Encryption;

use alphaz\Contracts\Encryption\Encrypt as EncryptContract;

class Encrypt implements EncryptContract
{
    /**
     * Store the adapter object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    private static $adapter = null;

    /**
     * Set the adapter.
     *
     * @param (string) $adapter
     *
     * @since 1.0.0
     *
     * @return object
     */
    public static function setAdapter($adapter)
    {
        switch (strtolower($adapter)) {
            case 'sodium':
                $adapterSet = '\alphaz\Encryption\Adapter\SodiumEncryption';
                break;
            case 'openssl':
                $adapterSet = '\alphaz\Encryption\Adapter\OpenSslEncryption';
                break;
            default:
                $adapterSet = '\alphaz\Encryption\Adapter\OpenSslEncryption';
                break;
        }
        $key = __config('encryption.key');
        self::$adapter = new $adapterSet($key);

        return __CLASS__;
    }

    /**
     * Encrypt the message.
     *
     * @param (mixed) $data data to be encrypted
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function encrypt($data, $adapter = null)
    {
        ($adapter !== null) ? self::setAdapter($adapter) : self::setAdapter(__config('encryption.driver'));

        return self::$adapter->encrypt($data);
    }

    /**
     * Decrypt the message.
     *
     * @param (mixed) $token encrypted token
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function decrypt($token, $adapter = null)
    {
        ($adapter !== null) ? self::setAdapter($adapter) : self::setAdapter(__config('encryption.driver'));

        return self::$adapter->decrypt($token);
    }
}
