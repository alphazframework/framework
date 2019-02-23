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

namespace Zest\Contracts\View;

interface View
{
    /**
     * Set file.
     *
     * @param $file name of files
     *        $args argoument need to be passed
     *        $minify is code should be minify
     *
     * @since 1.0.0
     *
     * @return mixed
     */
    public static function view($file, array $args = [], $minify = true);
}
