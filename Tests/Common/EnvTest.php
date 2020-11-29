<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Common\Env;

class EnvTest extends TestCase
{
    /**
     * @var \Zest\Commoon\Env
     */
    protected $config;

    /**
     * @var array
     */
    protected $configs;

    protected function setUp(): void
    {
        $this->config = new Env($this->configs = [
            'name'        => 'Zest',
            'version'     => '3.0.0',
            'null'        => null,
            'encryption'  => [
                'key'     => 'xxx',
                'adapter' => 'yyy',
            ],
        ]);
        parent::setUp();
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(Env::class, $this->config);
    }

    public function testGet()
    {
        $this->assertSame('Zest', $this->config->get('name'));
    }

    public function testGetWithArrayOfKeys()
    {
        $this->assertSame('Zest', $this->config->get('name'));
    }

    public function testGetWithDefault()
    {
        $this->assertSame('default', $this->config->get('not-exist', 'default'));
    }

    public function testAll()
    {
        $this->assertSame($this->configs, $this->config->all());
    }
}
