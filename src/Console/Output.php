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

use Zest\Console\Input\Table;

class Output extends Colorize
{
    /**
     * Quiet.
     *
     * @since 3.0.0
     *
     * @var bool
     */
    private $quiet = false;

    /**
     * Mark the console quiet.
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function quiet()
    {
        $this->quiet = true;

        return $this;
    }

    /**
     * Create the table on console.
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function table($header, $items): self
    {
        $table = new Table($header, $items);
        $table->draw();

        return $this;
    }

    /**
     * Write on console.
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function write($value, $newLine = false): self
    {
        if (!$this->quiet) {
            preg_match("/<\b[^>]*>/i", $value, $matches);
            $color = $matches[0] ?? 'default';
            $color = str_replace('<', '', $color);
            $color = str_replace('>', '', $color);
            $regx = "/<$color\b[^>]*>(.*?)<\/$color>/i";
            $text = preg_replace($regx, '\\1', $value);
            $line = ($newLine) ? "\n" : '';   
            echo "\033[".$this->get($color).''.$text.$line;
        }

        return $this;
    }

    /**
     * Output the admin.
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function error($msg): self
    {
        $this->write("<red>$msg</red>", true);

        return $this;
    }

    /**
     * Exit.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function exit()
    {
        exit(1);
    }
}
