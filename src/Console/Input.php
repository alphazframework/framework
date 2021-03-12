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
    /**
     * Prompt for input secret input like password.
     *
     * @param string $prompt Message to display.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function secret(string $prompt)
    {
        $os = (new \Zest\Common\OperatingSystem())->get();
        $command = './resources/secretinput.exe';
        if ($os !== 'Window') {
            $command = "/usr/bin/env bash -c 'read -s -p \""
            .addslashes($prompt)
            ."\" mypassword && echo \$mypassword'";
        }
        $value = rtrim(shell_exec($command), "\n");

        return $value;
    }

    /**
     * Prompt for input confirm.
     *
     * @since 3.0.0
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
     * @since 3.0.0
     *
     * @return string
     */
    public function ask(): string
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
