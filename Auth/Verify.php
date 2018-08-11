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

use Softhub99\Zest_Framework\Validation\Validation;
use Config\Auth;
use Softhub99\Zest_Framework\Database\Db as DB;
use Softhub99\Zest_Framework\Common\PasswordMAnipulation;

class Verify extends Handler
{
    public function verify($token) 
    {
        $user = new User;
        if ($token === 'NULL' || $user->isToken($token) !== true) {
            Error::set(Auth::AUTH_ERRORS['token'],'token');
        }   
        if ($this->fail() !== true) {
            if (!(new User)->isLogin()) {
                $id = $user->getByWhere('token',$token)[0]['id'];
                $email = $user->getByWhere('token',$token)[0]['email'];
                $params = ['token' => 'NULL'];
                $fields = [
                    'db_name' => Auth::AUTH_DB_NAME,
                    'table' => Auth::AUTH_DB_TABLE,
                    'columns' => $params ,
                    'wheres' => ['id = '. $id ],
                ];
                $db = new DB();
                $db->db()->update($fields);
                $db->db()->close();
                $subject = Auth::AUTH_SUBJECTS['verified'];
                $link = Auth::VERIFICATION_LINK . '/' . $token;
                $html = Auth::AUTH_MAIL_BODIES['verified'];
                $html = str_replace(":email",$email,$html);
                $email = new EmailHandler($subject,$html,$email);
                Success::set(Auth::SUCCESS['verified']);
            } else {
                Error::set(Auth::AUTH_ERRORS['already_login'],'login');
            }    
        }
    }
       
}
