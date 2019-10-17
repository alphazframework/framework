<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Auth;

class Logout
{
    /**
     * Logout the user.
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function __construct()
    {
        $user = new User();
        $user->logout();
    }
}
