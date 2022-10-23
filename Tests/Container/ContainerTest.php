<?php

namespace Framework\Tests\Container;

use alphaz\Container\Container;
use alphaz\http\Message;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testContainer()
    {
        $container = new Container();
        $msg = new Message();

        $instance = $container->register([Message::class, 'Message'], $msg, false);

        $this->assertFalse($container->isSingleton('Message'));

        $instance2 = $container->register([Message::class, 'Message'], $msg, true);

        $this->assertTrue($container->isSingleton('Message'));
    }

    public function testException()
    {
        $container = new Container();

        $this->expectException(\InvalidArgumentException::class);

        $instance3 = $container->register(['Invalid', 'Invalid'], null, true);
    }
}
