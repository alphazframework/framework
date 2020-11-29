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
use Zest\Console\Input\Table;

class Console
{

    /**
     * Instance of container.
     *
     * @since 3.0.0
     *
     * @var \Zest\Container\Container
     */
    private $container;

    /**
     * Commanads.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $commands = [];

    /**
     * Create a new console instance.
     *
     * @return void
     */
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

    /**
     * Get all commands.
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Run the Zest console.
     *
     * @return void
     */
    public function run($param): void
    {

        // registering the commands to container.
        foreach ($this->commands as $command) {
            $this->container->register([$command[1], $command[0]], new $command[1]);
        }

        $sign = isset($param[1]) ? $param[1] : 'list';
        $output = new Output();
        if ($this->container->has($sign)) {
            $cmd = $this->container->get($sign);
            
            if (!isset($param[2])) {
                $cmd->handle($output);
            }
            if (isset($param[2]) && strtolower($param[2]) == '-q') {
                $cmd->handle($output->quiet());
            }
            if (isset($param[2]) && strtolower($param[2]) == '-h') {
                $output->write('<yellow>Description:</yellow>', true);
                $output->write("<blue>\t".$cmd->getDescription().'</blue>', true);
                $output->write("\n<yellow>Usage:</yellow>", true);
                $output->write("<blue>\t".$cmd->getSign().'</blue>', true);
                $output->write("\n<yellow>Options:</yellow>", true);
                $output->write('<green>-h, --help</green>');
                $output->write("<blue>\tDisplay this help message</blue>", true);
                $output->write('<green>--q, --quiet</green>');
                $output->write("<blue>\tDo not output any message</blue>", true);
            }            
        } else {
            $output->error("Sorry, the given command ${sign} not found")->exit();
        }
    }
}
