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

class Verify extends Handler
{
    /**
     * Verify the user base on token.
     *
     * @param (mixed) $token token of user
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function verify($token)
    {
        $user = new User();
        if ($token === 'NULL' || $user->isToken($token) !== true) {
            Error::set(__printl('auth:error:token'), 'token');
        }
        if ($this->fail() !== true) {
            if (!(new User())->isLogin()) {
                $id = $user->getByWhere('token', $token)[0]['id'];
                $email = $user->getByWhere('token', $token)[0]['email'];
                $update = new Update();
                $update->update(['token' => 'NULL'], $id);
                $subject = __printl('auth:subject:verified');
                $link = __config()->auth->verification_link.'/'.$token;
                $html = __printl('auth:body:verified');
                $html = str_replace(':email', $email, $html);
                $email = new EmailHandler($subject, $html, $email);
                Success::set(__config()->auth->success->verified);
            } else {
                Error::set(__printl('auth:error:already:login'), 'login');
            }
        }
    }
}
