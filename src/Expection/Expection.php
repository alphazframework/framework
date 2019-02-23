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
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\Expection;

use Zest\Whoops\Whoops;

class Expection
{
    /**
     * __construct.
     *
     * @since 3.0.0
     */
    public function __construct()
    {
        (new Whoops());
    }
}
