<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Console;

use Zest\Common\Version;

class Console
{
    public function createController()
    {
        echo "Enter name of controller that you want create \n";
        $name = $this->cliInput();
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
        $name = $this->cliInput();
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
        echo "\n PHP local development server has been started locat at localhost:8080. If the public directory is the root, then localhost:8080/public \n";
        shell_exec($command);
    }

    public function main()
    {
        do {
            echo " Zest CLI Environment. \n";
            echo " ***************************** \n";
            echo " Enter 'c' to create a controller. \n";
            echo " Enter 'v' for version information. \n";
            echo " Enter 's' to start a local development server. \n";
            echo " Enter 'x' to quit. \n";
            echo " ***************************** \n";
            $x = $this->cliInput();
            if ($x === 'c') {
                $this->createController();
            } elseif ($x === 'v') {
                echo 'Zest Framework Version is: '.Version::VERSION."\n";
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

    public function oS()
    {
        return (new \Zest\Common\OperatingSystem())->get();
    }

    public function cliInput()
    {
        if ($this->oS() === 'WINNT' or $this->oS() === 'Windows') {
            echo '? ';
            $x = stream_get_line(STDIN, 9024, PHP_EOL);
            if (!empty($x)) {
                return $x;
            }
        } else {
            $x = readline('? ');
            if (!empty($x)) {
                return $x;
            }
        }
    }
}
