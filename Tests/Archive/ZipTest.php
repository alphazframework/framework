<?php

namespace Framework\Tests\Archive;

use alphaz\Archive\Adapter\Zip;
use PHPUnit\Framework\TestCase;

class ZipTest extends TestCase
{
    public function testExtract()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'alphaz.png';
        $Archive = new Zip();
        $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.zip');
        $Results = $Archive->extract(
            __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.zip',
            __DIR__.DIRECTORY_SEPARATOR.'new'
        );
        $this->assertTrue($Results);
    }

    public function testCompress()
    {
        $Path = __DIR__.DIRECTORY_SEPARATOR.'alphaz.png';
        $Archive = new Zip();
        $Results = $Archive->compress($Path, __DIR__.DIRECTORY_SEPARATOR.'alphaz.png.zip');
        $this->assertTrue($Results);
    }
}
