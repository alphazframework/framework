<?php

namespace Framework\Tests\Archive;

use PHPUnit\Framework\TestCase;
use Zest\Archive\Adapter\Bzip;

class BzipTest extends TestCase
{
    public function testExtract()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'Zest.png';
        $Archive = new Bzip();
        $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'Zest.png.bz');
        $Results = $Archive->extract(
            __DIR__.DIRECTORY_SEPARATOR.'Zest.png.bz',
            __DIR__.DIRECTORY_SEPARATOR.'Zest.png.new'
        );
        $this->assertTrue($Results);
    }

    public function testCompress()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'Zest.png';
        $Archive = new Bzip();
        $Results = $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'Zest.png.bz');
        $this->assertTrue($Results);
    }
}
