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

namespace alphaz\Auth;

use alphaz\Common\PasswordManipulation;
use alphaz\Contracts\Auth\Update as UpdateContract;
use alphaz\Database\Db as DB;
use alphaz\Hashing\Hash;
use alphaz\Validation\Validation;

class Update extends Handler implements UpdateContract
{
    /**
     * Update the users.
     *
     * @param (array) $params fields like  [name => thisname]
     * @param (int)   $id     id of user
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function update($params, $id)
    {
        if (is_array($params)) {
            foreach (array_keys($params) as $key => $value) {
                $paramsRules = [$value => ['required' => true]];
            }
            $paramsValidate = new Validation($params, $paramsRules);
            if ($paramsValidate->fail()) {
                Error::set($paramsValidate->error()->get());
            }
        }
        if ($this->fail() !== true) {
            $fields = [
                'db_name' => __config()->auth->db_name,
                'table'   => __config()->auth->db_table,
                'columns' => $params,
                'wheres'  => ['id = '.$id],
            ];
            $db = new DB();
            $db->db()->update($fields);
            $db->db()->close();
            Success::set(__printl('auth:success:update'));
        }
    }

    /**
     * Check is username is exists or not.
     *
     * @param (mixed) $password password of user
     * @param (mixed) $repeat   confirm password
     * @param (int)   $id       id of user
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function updatePassword($password, $repeat, $id)
    {
        if ($password !== $repeat) {
            Error::set(__printl('auth:error:password:confirm'), 'password');
        } elseif (__config()->auth->sticky_password === true) {
            if (!(new PasswordManipulation())->isValid($password)) {
                Error::set(__printl('auth:error:password:sticky'), 'password');
            }
        }
        if ($this->fail() !== true) {
            $password_hash = Hash::make($password);
            $params = ['password' => $password_hash];
            $fields = [
                'db_name' => __config()->auth->db_name,
                'table'   => __config()->auth->db_table,
                'columns' => $params,
                'wheres'  => ['id = '.$id],
            ];
            $db = new DB();
            $db->db()->update($fields);
            $db->db()->close();
            Success::set(__printl('auth:success:update_password'));
        }
    }
}
