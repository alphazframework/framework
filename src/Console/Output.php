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
    public function quiet(): self
    {
        $this->quiet = true;

        return $this;
    }

    /**
     * Ring the bell.
     *
     * @param int $times
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function bell(int $times = 1): self
    {
        for ($i = 1; $i <= $times; $i++) {
            echo "\x07";
        }

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
     * @param string $value
     * @param bool   $newLine
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
            $line = ($newLine) ? "\n" : '';

            if (preg_match($regx, $value)) {
                $text = preg_replace($regx, '\\1', $value);
                echo "\033[".$this->get($color);
            }

            $text = isset($text) ? $text : $value;
            preg_match("/<\b[^>]*>/i", $text, $_bg);
            $bg = $_bg[0] ?? 'bg:default';
            $bg = str_replace(['<', '>'], '', $bg);
            $_regx = "/<$bg\b[^>]*>(.*?)<\/$bg>/i";
            if (preg_match($_regx, $text)) {
                $text = preg_replace($_regx, '\\1', $text);
                echo "\033[".$this->get($bg);
            }

            echo ''.$text.$line;

            // reset to default
            echo "\033[0m";
            echo "\033[39m";
        }

        return $this;
    }

    /**
     * Output the error.
     *
     * @param string $msg
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
     * Output the danger.
     *
     * @param string $msg
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function danger($msg): self
    {
        $this->write("<bg:red><black>$msg</black></bg:red>", true);

        return $this;
    }

    /**
     * Output the info.
     *
     * @param string $msg
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function info($msg): self
    {
        $this->write("<bg:blue><black>$msg</black></bg:blue>", true);

        return $this;
    }

    /**
     * Output the warning.
     *
     * @param string $msg
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function warning($msg): self
    {
        $this->write("<bg:yellow><black>$msg</black></bg:yellow>", true);

        return $this;
    }

    /**
     * Output the warning.
     *
     * @param string $msg
     *
     * @since 3.0.0
     *
     * @return self
     */
    public function success($msg): self
    {
        $this->write("<bg:green><black>$msg</black></bg:green>", true);

        return $this;
    }

    /**
     * Exit.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function exit(): void
    {
        exit(1);
    }
}
