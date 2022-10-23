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

namespace alphaz\Console\Commands;

use alphaz\Common\Version as V;
use alphaz\Console\Command;
use alphaz\Console\Input;
use alphaz\Console\Output;

class Version extends Command
{
    /**
     * Sign of the command.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $sign = 'version';

    /**
     * Description of the command.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $description = 'Get the version of alphaz framework installed';

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
        $output->write('<white>alphaz Framewor: </white>', false);
        $output->write('<yellow>'.V::VERSION.'</yellow>', true);
    }
}
