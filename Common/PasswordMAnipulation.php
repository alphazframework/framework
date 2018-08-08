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

namespace Softhub99\Zest_Framework\Common;

class PasswordMAnipulation
{
    const PASS_MIN_LEN = 8;

    /**
     * Generate the password.
     *
     * @return mix-data
     */
    public function generatePassword()
    {
        $salts = (new \Softhub99\Zest_Framework\Site\Site())->salts(12);
        $special_char1 = '~<>?|:.(),';
        $special_char2 = '!@#$%^&*_+-*+';
        $pass = $special_char2.$salts.$special_char1;

        return str_shuffle($pass);
    }

    /**
     * Match the password.
     *
     * @param $password userPassword , $hash password hash
     *
     * @return bool
     */
    public function hashMatched($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * Hash the password.
     *
     * @param $password userPassword
     *
     * @return bool
     */
    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }

    /**
     * Validate the password.
     *
     * @param $password userPassword
     *
     * @return int
     */
    public function isValid($password)
    {
        return ($this->isU($password) && $this->isL($password) && $this->isN($password) && $this->isS($password) && $this->len($password) >= self::PASS_MIN_LEN) ? true : false;
    }

    /**
     * Check is capital letter is included in password.
     *
     * @param $password userPassword
     *
     * @return int
     */
    public function isU($password)
    {
        return preg_match('/[A-Z]/', $password);
    }

    /**
     * Check is small letter is included in password.
     *
     * @param $password userPassword
     *
     * @return int
     */
    public function isL($password)
    {
        return preg_match('/[a-z]/', $password);
    }

    /**
     * Check is the integer included in password.
     *
     * @param $password userPassword
     *
     * @return int
     */
    public function isN($password)
    {
        return preg_match('/[0-9]/', $password);
    }

    /**
     * Check is special character is in password.
     *
     * @param $password userPassword
     *
     * @return int
     */
    public function isS($password)
    {
        return preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password);
    }

    /**
     * Get password length.
     *
     * @param $password userPassword
     *
     * @return int
     */
    public function len($password)
    {
        return strlen($password);
    }
}
