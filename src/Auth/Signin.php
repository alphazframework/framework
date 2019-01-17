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
use Zest\Session\Session;
use Zest\Validation\Validation;

class Signin extends Handler
{
    /*
      * Store the errors msgs
    */
    protected $errors = [];

    /**
     * Signin the users.
     *
     * @param $username , username of user
     *        $password , password of user
     *
     * @return void
     */
    public function signin($username, $password)
    {
        $rules = [
            'username' => ['required' => true],
            'password' => ['required' => true],
        ];
        $inputs = [
            'username' => $username,
            'password' => $password,
        ];
        $requireValidate = new Validation($inputs, $rules);
        if ($requireValidate->fail()) {
            Error::set($requireValidate->error()->get());
        }
        $user = new User();
        if (!$user->isUsername($username)) {
            Error::set(__config()->auth->errors->username_not_exist, 'username');
        } else {
            $password_hash = $user->getByWhere('username', $username)[0]['password'];
            if (!(new PasswordManipulation())->hashMatched($password, $password_hash)) {
                Error::set(__config()->auth->errors->password_match, 'password');
            } else {
                $token = $user->getByWhere('username', $username)[0]['token'];
                $email = $user->getByWhere('username', $username)[0]['email'];
                if (__config()->auth->is_verify_email === true) {
                    if ($token !== 'NULL') {
                        $subject = __config()->auth->subjects->need_verify;
                        $link = site_base_url().__config()->auth->verification_link.'/'.$token;
                        $html = __config()->auth->bodies->need_verify;
                        $html = str_replace(':email', $email, $html);
                        $html = str_replace(':link', $link, $html);
                        (new EmailHandler($subject, $html, $email));
                        Error::set(__config()->auth->errrs->need_verify, 'email');
                    }
                }
            }
        }
        if (!$user->isLogin()) {
            if ($this->fail() !== true) {
                $salts = $user->getByWhere('username', $username)[0]['salts'];
                Session::setValue('user', $salts);
                set_cookie('user', $salts, 31104000, '/', $_SERVER['SERVER_NAME'], false, false);
                Success::set(__config()->auth->success->signin);
            }
        } else {
            Error::set(__config()->auth->errors->already_login, 'login');
        }
    }
}
