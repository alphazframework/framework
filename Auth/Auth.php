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

class Auth extends Handler
{
    public function signup()
    {
        return new Signup();
    }

    public function signin()
    {
        return new Signin();
    }

    public function logout()
    {
        return new Logout();
    }

    public function update()
    {
        return new Update();
    }

    public function verify()
    {
        return new Verify();
    }

    public function reset()
    {
        return new Reset();
    }
}
