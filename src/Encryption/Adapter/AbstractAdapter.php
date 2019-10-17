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

namespace Zest\Encryption\Adapter;

use Zest\Contracts\Encryption\Adapter\AbstractAdapter as AbstractAdapterContract;

abstract class AbstractAdapter implements AbstractAdapterContract
{
    /**
     * Store the secret key.
     *
     * @since 3.0.0
     *
     * @var key
     */
    protected $key;

    /**
     * Encrypt the message.
     *
     * @param (mixed) $data data to be encrypted
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    abstract public function encrypt($data);

    /**
     * Decrypt the message.
     *
     * @param (mixed) $token encrypted token
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    abstract public function decrypt($token);
}
