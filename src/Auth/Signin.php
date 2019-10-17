<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Auth;

use Zest\Hashing\Hash;
use Zest\http\Request;
use Zest\Session\Session;
use Zest\Validation\Validation;

class Signin extends Handler
{
    /**
     * Store the errors msgs.
     *
     * @since 2.0.3
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Signin the users.
     *
     * @param (string) $username username of user
     * @param (mixed)  $password password of user
     *
     * @since 2.0.3
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
            Error::set(__printl('auth:error:username:not:exists'), 'username');
        } else {
            $password_hash = $user->getByWhere('username', $username)[0]['password'];
            if (!Hash::verify($password, $password_hash)) {
                Error::set(__printl('auth:error:password:confirm'), 'password');
            } else {
                $token = $user->getByWhere('username', $username)[0]['token'];
                $email = $user->getByWhere('username', $username)[0]['email'];
                if (__config()->auth->is_verify_email === true) {
                    if ($token !== 'NULL') {
                        $subject = __printl('auth:subject:need:verify');
                        $link = site_base_url().__config()->auth->verification_link.'/'.$token;
                        $html = __printl('auth:body:need:verify');
                        $html = str_replace(':email', $email, $html);
                        $html = str_replace(':link', $link, $html);
                        (new EmailHandler($subject, $html, $email));
                        Error::set(__printl('auth:error:need:verification'), 'email');
                    }
                }
            }
        }
        if (!$user->isLogin()) {
            if ($this->fail() !== true) {
                $salts = $user->getByWhere('username', $username)[0]['salts'];
                Session::set('user', $salts);
                $request = new Request();
                set_cookie('user', $salts, 31104000, '/', $request->getServerName(), false, true);
                $password_hash = $user->getByWhere('username', $username)[0]['password'];
                if (Hash::needsRehash($password_hash) === true) {
                    $hashed = Hash::make($password);
                    $update = new Update();
                    $update->update(['password'=>$hashed], $user->getByWhere('username', $username)[0]['id']);
                }

                Success::set(__printl('auth:success:signin'));
            }
        } else {
            Error::set(__printl('auth:error:already:login'), 'login');
        }
    }
}
