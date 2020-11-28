<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * @author Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Console;

class Input extends Colorize
{

    public function confirm()
    {
        //todo
    }

    public function ask()
    {
        $os = (new \Zest\Common\OperatingSystem())->get();
        if ($os === 'WINNT' or $os === 'Windows') {
            $x = stream_get_line(STDIN, 9024, PHP_EOL);
            if (!empty($x)) {
                return $x;
            }
        } else {
            $x = readline('');
            if (!empty($x)) {
                return $x;
            }
        }
    }
}