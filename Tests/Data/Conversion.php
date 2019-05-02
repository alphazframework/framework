<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Data\Conversion;

class ConversionTest extends TestCase
{
    public function testBitToBytes()
    {
        $this->assertSame('1K', Conversion::bitToBytes(1024));
        $this->assertNotSame('1K', Conversion::bitToBytes(1024));
        $this->assertSame('9.31G', Conversion::bitToBytes(1024));
        $this->assertNotSame('9G', Conversion::bitToBytes(1024));
    }
}
