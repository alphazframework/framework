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

namespace Zest\Auth;

use Zest\Common\PasswordManipulation;
use Zest\Database\Db as DB;
use Zest\Validation\Validation;

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
                    'db_name' => __config()->auth->db_name,
                    'table'   => __config()->auth->db_table,
                    'columns' => $params,
                    'wheres'  => ['id = '.$id],
                ];
            $db = new DB();
            $db->db()->update($fields);
            $db->db()->close();
            Success::set(__config()->auth->success->update);
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
            Error::set(__config()->auth->errors->password_confirm, 'password');
        } elseif (__config()->auth->sticky_password === true) {
            if (!(new PasswordManipulation())->isValid($password)) {
                Error::set(__config()->auth->errors->sticky_password, 'password');
            }
        }
        if ($this->fail() !== true) {
            $password_hash = (new PasswordManipulation())->hashPassword($password);
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
            Success::set(__config()->auth->success->update_password);
        }
    }
}
