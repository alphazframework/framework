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

class Commands
{
    /**
     * Internal commands.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $commands = [
        ['version', \Zest\Console\Commands\Version::class],
        ['list', \Zest\Console\Commands\ListCmd::class],
        ['make:controller',  \Zest\Console\Commands\Controller::class],
        ['clear:cache', \Zest\Console\Commands\Cache::class],
        ['serve', \Zest\Console\Commands\ServeCommand::class],

    ];

    /**
     * Get commands.
     *
     * @since 3.0.0
     *
     * @var array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}
