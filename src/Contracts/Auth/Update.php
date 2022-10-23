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

namespace alphaz\Contracts\Auth;

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
     * @since 1.0.0
     *
     * @return void
     */
    public function updatePassword($password, $repeat, $id);
}
