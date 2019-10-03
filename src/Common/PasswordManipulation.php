<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 2.9.7
 *
 * @license MIT
 */

namespace Zest\Common;

use Zest\Data\Str;
use Zest\Site\Site;

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
     * @param (int) $length Length of password.
     *
     * @since 3.0.0
     *
     * @return mixed
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
     * @return mixed
     */
    public function generatePassword()
    {
        return Site::Salts(30, true);
    }

    /**
     * Validate the password.
     *
     * @param $password userPassword
     *
     * @since 2.9.7
     *
     * @return bool
     */
    public function isValid($password)
    {
        return (Str::hasUpperCase($password) && Str::hasLowerCase($password) && $this->isN($password) && $this->isS($password) && $this->len($password) >= $this->getLength()) ? true : false;
    }

    /**
     * Check is the integer included in password.
     *
     * @param $password userPassword
     *
     * @since 2.9.7
     *
     * @return bool
     */
    private function isN($password)
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
     * @return bool
     */
    private function isS($password)
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
        return Str::count($password);
    }
}
