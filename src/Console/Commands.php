<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * @author Muhammad Umer Farooq <lablnet01@gmail.com>
 *
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace alphaz\Console;

class Commands
{
    /**
     * Internal commands.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $commands = [
        ['version', \alphaz\Console\Commands\Version::class],
        ['list', \alphaz\Console\Commands\ListCmd::class],
        ['make:controller',  \alphaz\Console\Commands\Controller::class],
        ['clear:cache', \alphaz\Console\Commands\Cache::class],
        ['serve', \alphaz\Console\Commands\ServeCommand::class],

    ];

    /**
     * Get commands.
     *
     * @since 1.0.0
     *
     * @var array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
