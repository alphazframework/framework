<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Common\Configuraion;

class ConfigurationTest extends TestCase
{
    /**
     * @var \Zest\Commoon\Configuraion
     */
    protected $config;

    /**
     * @var array
     */
    protected $configs;

    protected function setUp(): void
    {
        $this->config = new Configuration($this->configs = [
            'name' => 'Zest',
            'version' => '3.0.0',
            'null' => null,
            'encryption' => [
                'key' => 'xxx',
                'adapter' => 'yyy',
            ]
        ]);
        parent::setUp();
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(Configuration::class, $this->config);
    }

    public function testHasIsTrue()
    {
        $this->assertTrue($this->config->has('name'));
    }

    public function testHasIsFalse()
    {
        $this->assertFalse($this->config->has('database'));
    }

    public function testGet()
    {
        $this->assertSame('Zest', $this->config->get('name'));
    }

    public function testGetWithArrayOfKeys()
    {
        $this->assertSame(['name' => 'Zest'], $this->config->get('name'));
        $this->assertSame(['encryption.key' => 'xxx'], $this->config->get('encryption.key'));
    }

    public function testGetWithDefault()
    {
        $this->assertSame('default', $this->config->get('not-exist', 'default'));
    }

    public function testSet()
    {
        $this->config->set('key', 'value');
        $this->assertSame('value', $this->config->get('key'));
    }

    public function testSetArray()
    {
        $this->config->set([
            'key1' => 'value1',
            'key2' => 'value2',
        ]);
        $this->assertSame('value1', $this->config->get('key1'));
        $this->assertSame('value2', $this->config->get('key2'));
    }

    public function testAll()
    {
        $this->assertSame($this->configs, $this->config->all());
    }

}
