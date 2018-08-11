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
use Softhub99\Zest_Framework\Database\Db as DB;
use Softhub99\Zest_Framework\Session\Session;
use Softhub99\Zest_Framework\Common\PasswordMAnipulation;

class User extends Handler
{
    public function getAll() 
    {
        $db = new DB();
        $result = $db->db()->select(['db_name'=>Auth::AUTH_DB_NAME,'table'=>Auth::AUTH_DB_TABLE]);
        $db->db()->close();
        return $result;
    }
    public function getByWhere($where,$value)
    {
        $db = new DB();
        $result = $db->db()->select(['db_name'=>Auth::AUTH_DB_NAME,'table'=>Auth::AUTH_DB_TABLE,'wheres'=>["{$where} =". "'{$value}'"]]);
        $db->db()->close();
        return $result;
    }
    public function isUsername($username) 
    {
        if (count($this->getByWhere('username',$username)) > 0) {
            return true;
        } else {
            return false;
        }
    }    
    public function isEmail($email) 
    {
        if (count($this->getByWhere('email',$email)) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function isToken($token) 
    {
        if (count($this->getByWhere('token',$token)) > 0) {
            return true;
        } else {
            return false;
        }
    }    
	/**
	 * Check user is login or not
	 *
	 * @return boolean
	 */	
	public function isLogin()
	{
		return (Session::isSession('user')) ? true : false;
    }  
	/**
	 * Logout the user
	 *
	 * @return boolean
	 */	
	public function logout()
	{
        delete_cookie("user");
		return Session::unsetValue('user');
	}          
}
