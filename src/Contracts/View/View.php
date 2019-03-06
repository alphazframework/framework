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
     * Render a view template.
     *
     * @param (string) $file Name of files.
     * @param (array)  $args Attributes.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public static function randerTemplate($file, $args = []);

    /**
     * Compile.
     *
     * @todo future
     *
     * @return void
     */
    public function compile();
}
