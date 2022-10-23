<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * @author Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace alphaz\Console;

class Input extends Colorize
{
    /**
     * Prompt for input secret input like password.
     *
     * @param string $prompt        Message to display.
     * @param bool   $show_asterisk Show asterisk or not.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function secret(string $prompt)
    {
        $os = (new \alphaz\Common\OperatingSystem())->get();
        $current_dir = __DIR__;
        $current_dir = str_replace('\\', '/', $current_dir);
        $command = $current_dir.'/bin/';
        if ($os === 'Windows') {
            $command .= 'windows.exe';
        } elseif ($os === 'macos') {
            $command .= 'macos';
        } else {
            $command .= 'linux';
        }
        $value = shell_exec($command);

        return $value;
    }

    /**
     * Prompt for input confirm.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function confirm(): bool
    {
        $confirm = $this->ask();
        $confirmed = ['y', 'yes'];

        return in_array(strtolower($confirm), $confirmed);
    }

    /**
     * Prompt for input input.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function ask(): string
    {
        $os = (new \alphaz\Common\OperatingSystem())->get();
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
