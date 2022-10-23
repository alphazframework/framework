<?php

namespace Framework\Tests\Common;

use alphaz\Common\Root;
use PHPUnit\Framework\TestCase;

class RootTest extends TestCase
{
    /**
     * @var \alphaz\Commoon\Configuraion
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
        $this->assertSame('root', $this->root->get('path'));
    }

    public function testGetWithDefault()
    {
        $this->assertSame('default', $this->root->get('not-exist', 'default'));
    }
}
