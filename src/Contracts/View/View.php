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

namespace alphaz\Contracts\View;

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
    public static function renderTemplate($file, $args = []);

    /**
     * Compile.
     *
     * @todo future
     *
     * @return void
     */
    public function compile();
}
