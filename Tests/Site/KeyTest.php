<?php

namespace Framework\Tests\Site;

use alphaz\Site\Key;
use PHPUnit\Framework\TestCase;

class KeyTest extends TestCase
{
    public function testGenerate(): void
    {
        $key = Key::generate(16);
        $this->assertEquals(16, mb_strlen($key, '8bit'));
    }

    public function testEncodeAndDecode(): void
    {
        $key = Key::generate(16);
        $this->assertEquals(16, mb_strlen($key, '8bit'));
        $encoded = Key::encode($key);
        $this->assertEquals(32, mb_strlen($encoded, '8bit'));
        $this->assertEquals($key, Key::decode($encoded));
    }

    public function testGenerateEncode(): void
    {
        $key = Key::generateEncode(16);
        $this->assertEquals(32, mb_strlen($key, '8bit'));
    }
}
