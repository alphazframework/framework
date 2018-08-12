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

class Verify extends Handler
{
    /**
     * Verify the user base on token.
     *
     * @param $token , token of user
     *
     * @return void
     */
    public function verify($token)
    {
        $user = new User();
        if ($token === 'NULL' || $user->isToken($token) !== true) {
            Error::set(Auth::AUTH_ERRORS['token'], 'token');
        }
        if ($this->fail() !== true) {
            if (!(new User())->isLogin()) {
                $id = $user->getByWhere('token', $token)[0]['id'];
                $email = $user->getByWhere('token', $token)[0]['email'];
                $update = new Update();
                $update->update(['token' => 'NULL'], $id);
                $subject = Auth::AUTH_SUBJECTS['verified'];
                $link = Auth::VERIFICATION_LINK.'/'.$token;
                $html = Auth::AUTH_MAIL_BODIES['verified'];
                $html = str_replace(':email', $email, $html);
                $email = new EmailHandler($subject, $html, $email);
                Success::set(Auth::SUCCESS['verified']);
            } else {
                Error::set(Auth::AUTH_ERRORS['already_login'], 'login');
            }
        }
    }
}
