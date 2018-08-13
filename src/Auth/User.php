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

use Config\Auth;
use Zest\Database\Db as DB;
use Zest\Session\Session;

class User extends Handler
{
    /**
     * Get all the users.
     *
     * @return array
     */
    public function getAll()
    {
        $db = new DB();
        $result = $db->db()->select(['db_name'=>Auth::AUTH_DB_NAME, 'table'=>Auth::AUTH_DB_TABLE]);
        $db->db()->close();

        return $result;
    }

    /**
     * Get users using specific field.
     *
     * @param $where , field of user e.g username
     *        $value , value fo field like , usr01
     *
     * @return bool
     */
    public function getByWhere($where, $value)
    {
        $db = new DB();
        $result = $db->db()->select(['db_name'=>Auth::AUTH_DB_NAME, 'table'=>Auth::AUTH_DB_TABLE, 'wheres'=>["{$where} ="."'{$value}'"]]);
        $db->db()->close();

        return $result;
    }

    /**
     * Check is username is exists or not.
     *
     * @param $username , username of user
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
     * @param $email , email of user
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
     * @param $token , token of user
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
     * @param $token , token  of user
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
	 * @return string|boolean
	 */		    
	public function loginUser()
	{
		$salts = $this->sessionuser();
		$user = $this->getByWhere("salts",$salts);
		return $user;
	}
	/**
	 * Get the current session user.
	 *
	 * @return string|boolean
	 */		
	public function sessionUser()
	{
		return (Session::isSession('user')) ? Session::getValue('user') : false;
	}
    /**
     * Check user is login or not.
     *
     * @return bool
     */
    public function isLogin()
    {
        return (Session::isSession('user')) ? true : false;
    }

    /**
     * Logout the user.
     *
     * @return bool
     */
    public function logout()
    {
        delete_cookie('user');

        return Session::unsetValue('user');
    }
}
