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

namespace alphaz\Console\Commands;

use alphaz\Common\Version as V;
use alphaz\Console\Command;
use alphaz\Console\Console;
use alphaz\Console\Input;
use alphaz\Console\Output;
use alphaz\Container\Container;

class ListCmd extends Command
{
    /**
     * Sign of the command.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $sign = 'list';

    /**
     * Description of the command.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $description = 'List the available commands';

    /**
     * Commands.
     *
     * @since 1.0.0
     *
     * @var array
     */
    private $cmds;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->container = new Container();
    }

    /**
     * Get the list of commandss.
     *
     * @return void
     */
    public function getList(): void
    {
        $console = new Console();
        $this->cmds = $console->getCommands();
    }

    /**
     * Function to handle the class.
     *
     * @param \alphaz\Console\Output $output
     * @param \alphaz\Console\Input  $input
     * @param array                  $param
     *
     * @return void
     */
    public function handle(Output $output, Input $input, $param = []): void
    {
        $output->write('<white>alphaz Framewor: </white>', false);
        $output->write('<yellow>'.V::VERSION.'</yellow>', true);
        $this->getList();
        $list = [];
        foreach ($this->cmds as $command) {
            $this->container->register([$command[1], $command[0]], new $command[1]());
            $class = $this->container->get($command[0]);
            if (!$class->getHidden()) {
                $sign = $class->getSign();
                $desc = $class->getDescription();
                $output->write("<green>${sign} :</green>", true);
                $output->write("<blue>\t${desc}</blue>", true);
            }
        }
    }
}
