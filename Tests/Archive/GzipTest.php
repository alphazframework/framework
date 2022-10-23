<?php

namespace Framework\Tests\Archive;

use alphaz\Archive\Adapter\Gzip;
use PHPUnit\Framework\TestCase;

class GzipTest extends TestCase
{
    public function testExtract()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'alphaz.png';
        $Archive = new Gzip();
        $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.gz');
        $Results = $Archive->extract(
            __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.gz',
            __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.new'
        );
        $this->assertTrue($Results);
    }

    public function testCompress()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'alphaz.png';
        $Archive = new Gzip();
        $Results = $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.gz');
        $this->assertTrue($Results);
    }
}
