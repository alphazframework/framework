<?php

namespace Framework\Tests\Archive;

use alphaz\Archive\Adapter\Bzip;
use PHPUnit\Framework\TestCase;

class BzipTest extends TestCase
{
    public function testExtract()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'alphaz.png';
        $Archive = new Bzip();
        $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.bz');
        $Results = $Archive->extract(
            __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.bz',
            __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.new'
        );
        $this->assertTrue($Results);
    }

    public function testCompress()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'alphaz.png';
        $Archive = new Bzip();
        $Results = $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.bz');
        $this->assertTrue($Results);
    }
}
