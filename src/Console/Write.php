<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Console;

class Write
{
    public function controller($name, $data)
    {
        $file = './App/Controllers/'.$name.'.php';
        if (!file_exists($file)) {
            $fh = fopen($file, 'w');
            fwrite($fh, $data);
            fclose($fh);

            return true;
        } else {
            return false;
        }
    }

    public function model($name, $data)
    {
        $file = './App/Models/'.$name.'.php';
        if (!file_exists($file)) {
            $fh = fopen($file, 'w');
            fwrite($fh, $data);
            fclose($fh);

            return true;
        } else {
            return false;
        }
    }
}
