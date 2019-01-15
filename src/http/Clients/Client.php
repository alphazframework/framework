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
