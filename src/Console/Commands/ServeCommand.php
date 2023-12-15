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
use alphaz\Console\Input;
use alphaz\Console\Output;

class ServeCommand extends Command
{
    /**
     * Sign of the command.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $sign = 'serve';

    /**
     * Description of the command.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $description = 'Serve the application on the PHP development server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
        // generate random 4 digit number
        $port = rand(1000, 9999);
        $output->write('<white>alphaz Framewor: </white>', false);
        $output->write('<yellow>'.V::VERSION.'</yellow>', true);
        // check if the server is running on $port.
        $host = 'localhost:'.$port;
        $command = 'php -S '.$host;
        $output->write("<green>\n PHP local development server has been started locat at localhost:8080. If the public directory is the root, then localhost:8080/public \n</green>");
        shell_exec($command);
    }
}
