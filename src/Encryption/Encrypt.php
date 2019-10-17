<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Encryption;

use Zest\Contracts\Encryption\Encrypt as EncryptContract;

class Encrypt implements EncryptContract
{
    /**
     * Store the adapter object.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private static $adapter = null;

    /**
     * Set the adapter.
     *
     * @param (string) $adapter
     *
     * @since 3.0.0
     *
     * @return object
     */
    public static function setAdapter($adapter)
    {
        switch (strtolower($adapter)) {
            case 'sodium':
                $adapterSet = '\Zest\Encryption\Adapter\SodiumEncryption';
                break;
            case 'openssl':
                $adapterSet = '\Zest\Encryption\Adapter\OpenSslEncryption';
                break;
            default:
                $adapterSet = '\Zest\Encryption\Adapter\OpenSslEncryption';
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
     * @since 3.0.0
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
     * @since 3.0.0
     *
     * @return mixed
     */
    public static function decrypt($token, $adapter = null)
    {
        ($adapter !== null) ? self::setAdapter($adapter) : self::setAdapter(__config('encryption.driver'));

        return self::$adapter->decrypt($token);
    }
}
