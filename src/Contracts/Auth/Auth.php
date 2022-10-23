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

namespace alphaz\Contracts\Auth;

interface Auth
{
    /**
     * Instance of signup class.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public function signup();

    /**
     * Instance of signin class.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public function signin();

    /**
     * Instance of logout class.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public function logout();

    /**
     * Instance of update class.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public function update();

    /**
     * Instance of verify class.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public function verify();

    /**
     * Instance of reset class.
     *
     * @since 1.0.0
     *
     * @return object
     */
    public function reset();
}
