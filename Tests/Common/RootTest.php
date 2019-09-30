<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Common\Root;

class RootTest extends TestCase
{
    /**
     * @var \Zest\Commoon\Configuraion
     */
    protected $root;

    /**
     * @var array
     */
    protected $roots;

    protected function setUp(): void
    {
        $this->root = new Root($this->roots = [
            'path'        => 'root',
        ]);
        parent::setUp();
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(Root::class, $this->root);
    }

    public function testGet()
    {
        $this->assertSame('root', $this->config->get('path'));
    }

    public function testGetWithDefault()
    {
        $this->assertSame('default', $this->config->get('not-exist', 'default'));
    }
}
