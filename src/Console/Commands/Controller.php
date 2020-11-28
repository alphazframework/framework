<?php

namespace Zest\Console\Commands;
use Zest\Console\Command;

class Controller extends Command
{
    protected $sign = "make:controller";
    protected $description = "Create a new Controller class";

    public function handle()
    {
        $name = $this->ask("Enter name of controller: ");
        $file = '../App/Controllers/'.$name.'.php';
        if (!file_exists($file)) {
            $fh = fopen($file, 'w');
            fwrite($fh, $this->controller());
            fclose($fh);
        }
    }

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