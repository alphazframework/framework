<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Data\Arrays;

class ArraysTest extends TestCase
{
    public function testIsReallyArray()
    {
        $this->assertTrue(Arrays::isReallyArray([0, 1]));
        $this->assertTrue(Arrays::isReallyArray(['name' => 
            'someName', 'username' => '@username']));

        $this->assertFalse(Arrays::isReallyArray([]));
        $this->assertFalse(Arrays::isReallyArray(null));
        $this->assertFalse(Arrays::isReallyArray('abc'));
    }    
}
