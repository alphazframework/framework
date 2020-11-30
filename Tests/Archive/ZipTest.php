<?php

namespace Framework\Tests\Archive;

use PHPUnit\Framework\TestCase;
use Zest\Archive\Adapter\Zip;

class ZipTest extends TestCase
{
    public function testExtract()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'Zest.png';
        $Archive = new Zip();
        $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'Zest.png.zip');
        $Results = $Archive->extract(
            __DIR__.DIRECTORY_SEPARATOR.'Zest.png.zip',
            __DIR__.DIRECTORY_SEPARATOR.'new'
        );
        $this->assertTrue($Results);
    }

    public function testCompress()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'Zest.png';
        $Archive = new Zip();
        $Results = $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'Zest.png.zip');
        $this->assertTrue($Results);
    }
}
