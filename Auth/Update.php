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
 * @license MIT
 */

namespace Softhub99\Zest_Framework\Auth;

use Config\Auth;
use Softhub99\Zest_Framework\Common\PasswordMAnipulation;
use Softhub99\Zest_Framework\Database\Db as DB;
use Softhub99\Zest_Framework\Validation\Validation;

class Update extends Handler
{
    /**
     * Update the users.
     *
     * @param $params , fields like  [name => thisname] array
     *        $id , id of user
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
                    'db_name' => Auth::AUTH_DB_NAME,
                    'table'   => Auth::AUTH_DB_TABLE,
                    'columns' => $params,
                    'wheres'  => ['id = '.$id],
                ];
            $db = new DB();
            $db->db()->update($fields);
            $db->db()->close();
            Success::set(Auth::SUCCESS['update']);
        }
    }

    /**
     * Check is username is exists or not.
     *
     * @param $password , password of user
     *        $repeat , confirm password
     *        $id , id of user
     *
     * @return void
     */
    public function updatePassword($password, $repeat, $id)
    {
        if ($password !== $repeat) {
            Error::set(Auth::AUTH_ERRORS['password_confitm'], 'password');
        } elseif (Auth::STICKY_PASSWORD) {
            if (!(new PasswordMAnipulation())->isValid($password)) {
                Error::set(Auth::AUTH_ERRORS['sticky_password'], 'password');
            }
        }
        if ($this->fail() !== true) {
            $password_hash = (new PasswordMAnipulation())->hashPassword($password);
            $params = ['password' => $password_hash];
            $fields = [
                    'db_name' => Auth::AUTH_DB_NAME,
                    'table'   => Auth::AUTH_DB_TABLE,
                    'columns' => $params,
                    'wheres'  => ['id = '.$id],
                ];
            $db = new DB();
            $db->db()->update($fields);
            $db->db()->close();
            Success::set(Auth::SUCCESS['update_password']);
        }
    }
}
