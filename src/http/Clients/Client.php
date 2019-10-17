<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\http\Clients;

class Client
{
    /**
     * Access to curl clients.
     *
     * @param (string) $url
     *                      (string) $method
     *                      (array) $options
     *
     * @since 3.0.0
     */
    public function curl($url, $method = 'GET', array $options = null)
    {
        return new CURL($url, $method, $options);
    }
}
