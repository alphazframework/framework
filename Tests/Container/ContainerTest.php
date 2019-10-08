<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Container\Container;
use Zest\http\Message;

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

        try {
            $instance3 = $container->register(['Invalid', 'Invalid'], null, true);
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Claass should be valid instance of Invalid.', $e->getMessage());
        }
    }
}
