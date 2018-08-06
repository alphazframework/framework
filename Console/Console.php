<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Softhub99\Zest_Framework\Console;

use Config\Config;

class Console
{
    public function createController()
    {
        echo "Enter name of controller that you want create \n";
        $handle = fopen('php://stdin', 'r');
        $name = fgets($handle);
        $name = trim($name);
        $code = new Code();
        $data = $code->controller($name);
        $writer = new Write();
        if ($writer->controller($name, $data)) {
            echo "Controller {$name} created successfully \n";
            $this->main();
        } else {
            echo "Something went wrong \n";
            $this->main();
        }
    }

    public function createModel()
    {
        echo "Enter name of model that you want create \n";
        $handle = fopen('php://stdin', 'r');
        $name = fgets($handle);
        $name = trim($name);
        $code = new Code();
        $data = $code->controller($name);
        $writer = new Write();
        if ($writer->controller($name, $data)) {
            echo "Model {$name} created successfully \n";
            $this->main();
        } else {
            echo "Something went wrong \n";
            $this->main();
        }
    }

    public function startServer()
    {
        $host = 'localhost:8080';
        $command = 'php -S '.$host;
        echo "\n PHP local development server has been started locat at localhost:8080 , if the public directory is the root then localhost:8080/public \n";
        shell_exec($command);
    }

    public function main()
    {
        do {
            echo " Zest CLI Enviroment \n";
            echo " ***************************** \n";
            echo " Enter 'c' for create controller \n";
            echo " Enter 'v' for version \n";
            echo " Enter 's' for start local development server \n";
            echo " Enter 'x' for Quit \n";
            echo " ***************************** \n";
            $handle = fopen('php://stdin', 'r');
            $x = fgets($handle);
            $x = strtolower(trim($x));
            fclose($handle);
            if ($x === 'c') {
                $this->createController();
            } elseif ($x === 'v') {
                echo 'Zest Framework Version is: '.Config::App_Version."\n";
                $this->main();
            } elseif ($x === 's') {
                $this->startServer();
            } elseif ($x === 'x') {
                echo 'GoodBye';
                exit();
            } else {
                $this->main();
            }
            echo "Enter 'r' to repeat";
        } while ($x === 'r');
    }

    public function run()
    {
        $this->main();
    }
}
