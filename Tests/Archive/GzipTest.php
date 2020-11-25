<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Archive\Adapter\Gzip;

class GzipTest extends TestCase
{
    public function testExtract()
    {
        $Path = __DIR__ . DIRECTORY_SEPARATOR . 'Zest.png';
        $Archive = new Gzip();
        $Archive->compress($Path, __DIR__ . DIRECTORY_SEPARATOR . 'Zest.png.gz');
        $Results = $Archive->extract(__DIR__ . DIRECTORY_SEPARATOR . 'Zest.png.gz', __DIR__ . DIRECTORY_SEPARATOR . 'Zest.png.new');
        $this->assertTrue($Results);
    }

    public function testCompress()
    {
        $Path = __DIR__ . DIRECTORY_SEPARATOR . 'Zest.png';
        $Archive = new Gzip();
        $Results = $Archive->compress($Path, __DIR__ . DIRECTORY_SEPARATOR . 'Zest.png.gz');
        $this->assertTrue($Results);
    }
}
