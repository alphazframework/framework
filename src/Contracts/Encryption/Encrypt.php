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

namespace alphaz\Contracts\Encryption;

interface Encrypt
{
    /**
     * Set the adapter.
     *
     * @param (string) $adapter
     *
     * @since 1.0.0
     *
     * @return object
     */
    public static function setAdapter($adapter);

    /**
     * Encrypt the message.
     *
     * @param (mixed) $data data to be encrypted
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function encrypt($data, $adapter = null);

    /**
     * Decrypt the message.
     *
     * @param (mixed) $token encrypted token
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function decrypt($token, $adapter = null);
}
