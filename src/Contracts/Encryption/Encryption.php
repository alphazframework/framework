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

namespace Zest\Contracts\Encryption;

interface Encryption
{
    /**
     * __construct.
     *
     * @since 3.0.0
     */
    public function __construct($adaoter = null);

    /**
     * Set the adapter.
     *
     * @param (string) $adapter
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setAdapter($adapter);

    /**
     * Encrypt the message.
     *
     * @param (mixed) $data data to be encrypted
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function encrypt($data);

    /**
     * Decrypt the message.
     *
     * @param (mixed) $token encrypted token
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function decrypt($token);
}
