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

namespace Zest\Console;

abstract class Command
{
    /**
     * Sign of the command.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $sign;

    /**
     * Description of the command.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $description;

    /**
     * Should the command hidden form list.
     *
     * @since 3.0.0
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * Accpet flag parameter in command.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $flags = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //todo
    }

    /**
     * Get hidden.
     *
     * @return string
     */
    public function getHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * Get sign.
     *
     * @return string
     */
    public function getSign(): string
    {
        return $this->sign ?? '';
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description ?? '';
    }

    /**
     * Get flags.
     *
     * @return array
     */
    public function getFlags(): array
    {
        return $this->flags ?? [];
    }

    /**
     * Function to handle the class.
     *
     * @param string $str
     * @param bool   $newLine
     *
     * @return void
     */
    public function write(string $str, bool $newLine = true)
    {
        (new Output())->write($str, $newLine);
    }

    /**
     * Prompt user for input.
     *
     * @param string $str
     *
     * @return void
     */
    public function ask(string $str)
    {
        $this->write("<white>$str</white>", false);

        return (new Input())->ask();
    }

    /**
     * Terminate the console.
     *
     * @return void
     */
    public function terminate(): void
    {
        exit();
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
    abstract public function handle(Output $output, Input $input, $prams = []): void;
}
