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

use alphaz\Site\Site;
use alphaz\Validation\Validation;

class Reset extends Handler
{
    /**
     * Store the error msgs.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Add the reset password request.
     *
     * @param (string) $email email of user
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function reset($email)
    {
        $rules = [
            'email' => ['required' => true, 'email' => true],
        ];
        $input = [
            'email' => $email,
        ];
        $requireValidate = new Validation($input, $rules);
        if ($requireValidate->fail()) {
            Error::set($requireValidate->error()->get());
        }
        $user = new User();
        if (!$user->isEmail($email)) {
            Error::set(__config()->auth->errors->email_not_exist, 'username');
        }
        if (!$user->isLogin()) {
            if ($this->fail() !== true) {
                $id = $user->getByWhere('email', $email)[0]['id'];
                $resetToken = (new Site())::salts(8);
                $update = new Update();
                $update->update(['resetToken' => $resetToken], $id);
                $link = site_base_url().__config()->auth->reset_password_link.$resetToken;
                $subject = __printl('auth:subject:reset');
                $link = site_base_url().__config()->auth->reset_password_link.'/'.$token;
                $html = __printl('auth:body:reset');
                $html = str_replace(':email', $email, $html);
                $html = str_replace(':link', $link, $html);
                new EmailHandler($subject, $html, $email);
                Success::set(__printl('auth:success:reset'));
            }
        } else {
            Error::set(__printl('auth:error:already:login'), 'login');
        }
    }

    /**
     * check token is exists or not.
     *
     * @param (mixed) $token token of user
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function resetUpdate($token)
    {
        $user = new User();
        if ($token === 'NULL' || $user->isResetToken($token) !== true) {
            Error::set(__printl('auth:error:token'), 'token');
        }
        if ($this->fail() !== true) {
            Success::set(true);
        }
    }
}
