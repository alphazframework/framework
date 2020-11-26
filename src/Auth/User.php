<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Auth;

use Zest\Contracts\Auth\User as UserContract;
use Zest\Cookies\Cookies;
use Zest\Database\Db as DB;
use Zest\http\Request;
use Zest\Session\Session;

class User extends Handler implements UserContract
{
    /**
     * Get all the users.
     *
     * @since 2.0.3
     *
     * @return array
     */
    public function getAll()
    {
        $db = new DB();
        $result = $db->db()->select(['db_name'=>__config()->auth->db_name, 'table'=>__config()->auth->db_table]);
        $db->db()->close();

        return $result;
    }

    /**
     * Get users using specific field.
     *
     * @param (string) $where field of user e.g username
     * @param (string) $value value fo field like , usr01
     *
     * @since 2.0.3
     *
     * @return bool
     */
    public function getByWhere($where, $value)
    {
        $db = new DB();
        $result = $db->db()->select(['db_name'=>__config()->auth->db_name, 'table'=>__config()->auth->db_table, 'wheres'=>["{$where} ="."'{$value}'"]]);
        $db->db()->close();

        return $result;
    }

    /**
     * Delete user by id.
     *
     * @param $id id or guide of user
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function delete($id)
    {
        $db = new DB();
        $result = $db->db()->delete(['db_name'=>__config()->auth->db_name, 'table'=>__config()->auth->db_table, 'wheres'=>['id ='."'{$id}'"]]);
        $db->db()->close();

        return $result;
    }

    /**
     * Check is username is exists or not.
     *
     * @param (string) $username username of user
     *
     * @since 2.0.3
     *
     * @return bool
     */
    public function isUsername($username)
    {
        if (count($this->getByWhere('username', $username)) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check is email is exists or not.
     *
     * @param (mixed) $email email of user
     *
     * @since 2.0.3
     *
     * @return bool
     */
    public function isEmail($email)
    {
        if (count($this->getByWhere('email', $email)) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check is is verification token is exists or not.
     *
     * @param (mixed) $token token of user
     *
     * @since 2.0.3
     *
     * @return bool
     */
    public function isToken($token)
    {
        if (count($this->getByWhere('token', $token)) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check is reset token is exists or not.
     *
     * @param (mixed) $token token  of user
     *
     * @since 2.0.3
     *
     * @return bool
     */
    public function isResetToken($token)
    {
        if (count($this->getByWhere('resetToken', $token)) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the details of login user.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function loginUser()
    {
        $salts = $this->sessionUser();
        $user = $this->getByWhere('salts', $salts);

        return $user;
    }

    /**
     * Get the current session user.
     *
     * @since 2.0.3
     *
     * @return mixed
     */
    public function sessionUser()
    {
        return (Session::has('user')) ? Session::get('user') : false;
    }

    /**
     * Check user is login or not.
     *
     * @since 2.0.3
     *
     * @return bool
     */
    public function isLogin()
    {
        return (Session::has('user')) ? true : false;
    }

    /**
     * Logout the user.
     *
     * @since 2.0.3
     *
     * @return bool
     */
    public function logout()
    {
        $request = new Request();
        (new Cookies())->delete('user', '/', $request->getServerName());
        session_regenerate_id(); //Avoid session hijacking

        return Session::delete('user');
    }
}
