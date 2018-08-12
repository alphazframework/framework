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
use Softhub99\Zest_Framework\Session\Session;
use Softhub99\Zest_Framework\Validation\Validation;

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
            Error::set(Auth::AUTH_ERRORS['username_not_exist'], 'username');
        } else {
            $password_hash = $user->getByWhere('username', $username)[0]['password'];
            if (!(new PasswordMAnipulation())->hashMatched($password, $password_hash)) {
                Error::set(Auth::AUTH_ERRORS['password_match'], 'password');
            } else {
                $token = $user->getByWhere('username', $username)[0]['token'];
                $email = $user->getByWhere('username', $username)[0]['email'];
                if ($token !== 'NULL') {
                    $subject = Auth::AUTH_SUBJECTS['need_verify'];
                    $link = site_base_url().Auth::VERIFICATION_LINK.'/'.$token;
                    $html = Auth::AUTH_MAIL_BODIES['need_verify'];
                    $html = str_replace(':email', $email, $html);
                    $html = str_replace(':link', $link, $html);
                    (new EmailHandler($subject, $html, $email));
                    Error::set(Auth::AUTH_ERRORS['account_verify'], 'email');
                }
            }
        }
        if (!$user->isLogin()) {
            if ($this->fail() !== true) {
                $salts = $user->getByWhere('username', $username)[0]['salts'];
                Session::setValue('user', $salts);
                set_cookie('user', $salts, 3600, '/', $_SERVER['SERVER_NAME'], false, false);
                Success::set(Auth::SUCCESS['signin']);
            }
        } else {
            Error::set(Auth::AUTH_ERRORS['already_login'], 'login');
        }
    }
}
