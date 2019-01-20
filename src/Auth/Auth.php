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
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Auth;

use Zest\Contracts\Auth\Auth as AuthContract;

class Auth extends Handler implements AuthContract
{
    /**
     * Instance of signup class.
     *
     * @since 2.0.3
     *
     * @return object
     */
    public function signup()
    {
        return new Signup();
    }

    /**
     * Instance of signin class.
     *
     * @since 2.0.3
     *
     * @return object
     */
    public function signin()
    {
        return new Signin();
    }

    /**
     * Instance of logout class.
     *
     * @since 2.0.3
     *
     * @return object
     */
    public function logout()
    {
        return new Logout();
    }

    /**
     * Instance of update class.
     *
     * @since 2.0.3
     *
     * @return object
     */
    public function update()
    {
        return new Update();
    }

    /**
     * Instance of verify class.
     *
     * @since 2.0.3
     *
     * @return object
     */
    public function verify()
    {
        return new Verify();
    }

    /**
     * Instance of reset class.
     *
     * @since 2.0.3
     *
     * @return object
     */
    public function reset()
    {
        return new Reset();
    }
}
