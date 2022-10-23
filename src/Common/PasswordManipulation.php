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
 * @since 2.9.7
 *
 * @license MIT
 */

namespace alphaz\Common;

use alphaz\Data\Str;
use alphaz\Site\Site;

class PasswordManipulation
{
    /**
     * Store password default length.
     *
     * @since 1.0.0
     *
     * @var int
     */
    private $password_len = 30;

    /**
     * Set the password default length.
     *
     * @param (int) $length Length of password.
     *
     * @since 1.0.0
     *
     * @return self
     */
    public function setLength(int $length)
    {
        $this->password_len = $length;

        return $this;
    }

    /**
     * Get the password default length.
     *
     * @since 1.0.0
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
     * @param (int) $length Password length.
     *
     * @since 2.9.7
     *
     * @return string
     */
    public function generatePassword($length = 30)
    {
        $this->setLength($length);

        return Site::Salts($this->getLength(), true);
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
