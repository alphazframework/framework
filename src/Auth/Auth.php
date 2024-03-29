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

use alphaz\Contracts\Auth\Auth as AuthContract;

class Auth extends Handler implements AuthContract
{
    /**
     * Instance of signup class.
     *
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @return object
     */
    public function reset()
    {
        return new Reset();
    }
}
