<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Container\Container;

class ContainerTest extends TestCase
{
    public function testContainer()
    {
        $container = new Container();
        $msg       = new \Zest\http\Message();

        $instance = $container->register(['Zest\http\Message', 'Message'], $msg, false);

        $this->assertFalse($container->isSingleton('Message'));

        $instance2 = $container->register(['Zest\http\Message', 'Message'], $msg, true);

        $this->assertTrue($container->isSingleton('Message'));
        // adds test cases here.
    }
}
