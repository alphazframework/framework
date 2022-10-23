<?php

namespace Framework\Tests\Data;

use alphaz\Data\Conversion;
use PHPUnit\Framework\TestCase;

class ConversionTest extends TestCase
{
    public function testBitToBytes()
    {
        $this->assertSame('1 K', Conversion::bitToBytes(1024));
        $this->assertNotSame('2 K', Conversion::bitToBytes(1024));
    }
}
