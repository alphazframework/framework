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

namespace Softhub99\Zest_Framework\Auth;

class Handler
{
    public function fail()
    {
        return Error::has();
    }

    public function error()
    {
        $this->errors = Error::all();

        return $this;
    }

    public function get($key = null)
    {
        return (isset($key)) ? $this->errors[$key] : $this->errors;
    }

    public function last($key = null)
    {
        return end($this->get($key));
    }

    public function first($key = null)
    {
        return current($this->get($key));
    }

    public function success()
    {
        return Success::get();
    }
}
