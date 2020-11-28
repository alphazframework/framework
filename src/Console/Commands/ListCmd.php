<?php

namespace Zest\Console\Commands;
use Zest\Console\Command;
use Zest\Console\Console;
use Zest\Container\Container;

class ListCmd extends Command
{
    protected $sign = "list";
    protected $description = "List the available commands";
    private $cmds;

    public function __construct()
    {
        $this->container = new Container();
    }
    public function getList()
    {
        $console = new Console();
        $this->cmds = $console->getCommands();
        
    }
    public function handle()
    {
        $this->getList();
        $list = [];
        foreach ($this->cmds as $command) {
            $this->container->register([$command[1], $command[0]], new $command[1]);
            $class = $this->container->get($command[0]);
            $sign = $class->getSign();
            $desc = $class->getDescription();
            $this->write("<green>${sign} : </green>", false);
            $this->write("<blue>${desc}</blue>"); 
        }
    }
}