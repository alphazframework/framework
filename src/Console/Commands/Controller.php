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
use Zest\Console\Input;

class Controller extends Command
{
    /**
     * Sign of the command.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $sign = 'make:controller';

    /**
     * Description of the command.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $description = 'Create a new Controller class';

    /**
     * Accpet flag parameter in command.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $flags = [
        'name'
    ];

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
     * @param \Zest\Console\Output $output
     * @param \Zest\Console\Input  $input
     * @param array                $param
     *
     * @return void
     */
    public function handle(Output $output, Input $input, $param = []): void
    {
        $name = $this->ask('Enter name of controller: ');
        $file = route('root').'App/Controllers/'.$name.'.php';
        if (!file_exists($file)) {
            $fh = fopen($file, 'w');
            fwrite($fh, $this->controller($name));
            fclose($fh);
        }
    }

    // should replace with like {stubs}
    public function controller($name)
    {
        return  <<<code
<?php

namespace App\Controllers;
//for using View
use Zest\View\View;

class {$name} extends \Zest\Controller\Controller
{
    /**
     * Show the index page.
     *
     * @return void
     */
    public function index()
    {
        echo View::view('{$name}/index');
    }
}

code;
    }
}
