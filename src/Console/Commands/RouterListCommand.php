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

namespace Zest\Console\Commands;

use Zest\Console\Command;
use Zest\Console\Output;
use Zest\Router\App;

class RouterListCommand extends Command
{
    /**
     * Sign of the command.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $sign = 'route:list';

    /**
     * Description of the command.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $description = 'List all registered routes';

    /**
     * App instance.
     *
     * @since 3.0.0
     *
     * @var \Zest\Router\App
     */
    private $app;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->app = new App();
    }

    /**
     * Function to handle the class.
     *
     * @param \Zest\Console\Output $output
     * @param \Zest\Console\Input  $input
     * @param array                $param
     *
     * @return void
     */
    public function handle(Output $output, Input $input, $param = []): void
    {
        $routers = $this->app->getRoutes();
        //var_dump($routers);
    }
}
