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

interface User
{
    /**
     * Get all the users.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function getAll();

    /**
     * Get users using specific field.
     *
     * @param (string) $where field of user e.g username
     * @param (string) $value value fo field like , usr01
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function getByWhere($where, $value);

    /**
     * Delete user by id.
     *
     * @param $id id or guide of user
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function delete($id);

    /**
     * Check is username is exists or not.
     *
     * @param (string) $username username of user
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function isUsername($username);

    /**
     * Check is email is exists or not.
     *
     * @param (mixed) $email email of user
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function isEmail($email);

    /**
     * Check is is verification token is exists or not.
     *
     * @param (mixed) $token token of user
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function isToken($token);

    /**
     * Check is reset token is exists or not.
     *
     * @param (mixed) $token token  of user
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function isResetToken($token);

    /**
     * Get the details of login user.
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function loginUser();

    /**
     * Get the current session user.
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public function sessionUser();

    /**
     * Check user is login or not.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function isLogin();

    /**
     * Logout the user.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function logout();
}
