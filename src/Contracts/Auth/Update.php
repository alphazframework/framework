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
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Contracts\Auth;

interface Update
{
    /**
     * Update the users.
     *
     * @param (array) $paramsfields like  [name => thisname]
     * @param (int)   $id           id of user
     *
     * @return void
     */
    public function update($params, $id);

    /**
     * Check is username is exists or not.
     *
     * @param (mixed)$password password of user
     * @param (mixed) $repeat confirm password
     * @param (int)   $id     id of user
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function updatePassword($password, $repeat, $id);
}
