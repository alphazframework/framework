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

namespace Zest\Auth;

class Handler
{
    /**
     * check if the error has.
     *
     * @return bool
     */
    public function fail()
    {
        return Error::has();
    }

    /**
     * Store the error msgs.
     *
     * @return array
     */
    public function error()
    {
        $this->errors = Error::all();

        return $this;
    }

    /**
     * Get the error msg.
     *
     * @param $key , like username (optional)
     *
     * @return array
     */
    public function get($key = null)
    {
        return (isset($key)) ? $this->errors[$key] : $this->errors;
    }

    /**
     * Get last error msg.
     *
     * @param $key , like username (optional)
     *
     * @return string
     */
    public function last($key = null)
    {
        return end($this->get($key));
    }

    /**
     * Get first errror msg .
     *
     * @param $key , like username (optional)
     *
     * @return string
     */
    public function first($key = null)
    {
        return current($this->get($key));
    }

    /**
     * Get the success msg.
     *
     * @return string
     */
    public function success()
    {
        return Success::get();
    }
}
