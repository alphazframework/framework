<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Encryption;

use Zest\Contracts\Encryption\Encryption as EncryptionContract;

class Encryption implements EncryptionContract
{
    /**
     * Store the adapter object.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private $adapter = null;

    /**
     * __construct.
     *
     * @since 3.0.0
     */
    public function __construct($adapter = null)
    {
        ($adapter !== null) ? $this->setAdapter($adapter) : $this->setAdapter(__config('encryption.driver'));
    }

    /**
     * Set the adapter.
     *
     * @param (string) $adapter
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setAdapter($adapter)
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
        $this->adapter = new $adapterSet($key);

        return $this;
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
        return $this->adapter->encrypt($data);
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
        return $this->adapter->decrypt($token);
    }
}
