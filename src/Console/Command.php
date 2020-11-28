<?php
namespace Zest\Console;

use Zest\Console\Output;
use Zest\Console\Input;

abstract class Command
{

    protected $sign;
    protected $description;

    public function getSign(): string
	{
		return $this->sign ?? '';
    }

	public function getDescription(): string
	{
		return $this->description ?? '';
    }

    public function write($str, $newLine = true)
    {
        (new Output())->write($str, $newLine);
    }

    public function ask($str)
    {
        $this->write("<white>$str</white>", false);
        return (new Input())->ask();       
    }
    abstract public function handle();
}