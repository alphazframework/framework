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

use Zest\Common\Version;
use Zest\Container\Container;
use Zest\Console\Colorize;
use Zest\Console\Commands as InternalCommands;

class Console
{

    private $container;
    private $commands = [];

    public function __construct()
    {
        $this->container = new Container();
        $internalCommands = (new InternalCommands())->getCommands();
        $externalCommands = [];
        if (class_exists("\Config\Commands")) {
            $externalCommands = (new \Config\Commands())->getCommands();
        }
        $this->commands = array_merge($internalCommands, $externalCommands);
    }

    public function getCommands()
    {
        return $this->commands;
    }

    public function run($param)
    {
        $output = new Output();
        foreach ($this->commands as $command) {
            $this->container->register([$command[1], $command[0]], new $command[1]);
        }

       $sign = isset($param[1]) ? $param[1] : $output->error("Sorry, no command provided")->exit();

        if ($this->container->has($sign)) {
            $cmd = $this->container->get($sign);
            $cmd->handle();
        } else {
            $output->error("Sorry, the given command ${sign} not found")->exit();
        }
    }
}
