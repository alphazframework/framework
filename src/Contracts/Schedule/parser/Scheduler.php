<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Contracts\Sechdule\Parser;

interface Scheduler
{

    /**
     * Parse the expression.
     *
     * @param array $expression Expression to be parsed.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function parser($expression);
}
