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
 * @deprecated 3.0.0
 * @since 2.9.7
 *
 * @license MIT
 */

namespace Zest\Common;

class PasswordManipulation
{
    /**
     * Store password default length.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $password_len = 8;

    /**
     * Set the password default length.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function setLength($length)
    {
        return (is_int($length)) ? $this->password_len = $length : false;
    }

    /**
     * Get the password default length.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getLength()
    {
        return $this->password_len;
    }

    /**
     * Generate the password.
     *
     * @since 2.9.7
     *
     * @return mix-data
     */
    public function generatePassword()
    {
        $salts = (new \Zest\Site\Site())->salts(12);
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
     * @since 2.9.7
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
     * @since 2.9.7
     *
     * @return bool
     */
    public function hashPassword($password)
    {
        if (\defined('PASSWORD_ARGON2I')) {
            $algorithm = PASSWORD_ARGON2I;
        } elseif (\define('PASSWORD_BCRYPT')) {
            $algorithm = PASSWORD_BCRYPT;
        } else {
            $algorithm = PASSWORD_DEFAULT;
        }

        return password_hash($password, $algorithm);
    }

    /**
     * Validate the password.
     *
     * @param $password userPassword
     *
     * @since 2.9.7
     *
     * @return int
     */
    public function isValid($password)
    {
        return ($this->isU($password) && $this->isL($password) && $this->isN($password) && $this->isS($password) && $this->len($password) >= $this->getLength()) ? true : false;
    }

    /**
     * Check is capital letter is included in password.
     *
     * @param $password userPassword
     *
     * @since 2.9.7
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
     * @since 2.9.7
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
     * @since 2.9.7
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
     * @since 2.9.7
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
     * @since 2.9.7
     *
     * @return int
     */
    public function len($password)
    {
        return strlen($password);
    }
}
