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

class Output extends Colorize
{

    public function write($value, $newLine = false)
    {
        preg_match("/<\b[^>]*>/i", $value, $matches);
        $color = $matches[0] ?? "default";
        $color = str_replace("<", "", $color);
        $color = str_replace(">", "", $color);
        $regx = "/<$color\b[^>]*>(.*?)<\/$color>/i";
        $text = preg_replace($regx, "\\1", $value);
        $line = ($newLine) ? "\n" : "";
        print("\033[".$this->get($color)."".$text . $line);
        return $this;
    }
    public function error($msg): self
    {
        $this->write("<red>$msg</red>", true);
        return $this;
    }
    public function exit()
    {
        exit(1);
    }
}