<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Data\Str;

class StrTest extends TestCase
{
    public function testReverse()
    {
        $this->assertSame('olleh', Str::reverse('hello'));
        $this->assertNotSame('hello', Str::reverse('hello'));
    }

    public function testConcat()
    {
        $this->assertSame('this  is  a  book', Str::concat(' ', 'this', ' is', ' a', ' book'));
        $this->assertNotSame('thisisabook', Str::concat(' ', 'this', ' is', ' a', ' book'));
    }

    public function testCount()
    {
        $this->assertSame(5, Str::count('hello'));
        $this->assertNotSame(9, Str::count('hello'));
    }

    public function testHasUpperCase()
    {
        $this->assertTrue(Str::hasUpperCase('UPPERCASE'));
        $this->assertTrue(Str::hasUpperCase('upperCase'));
        $this->assertFalse(Str::hasUpperCase('uppercase'));
    }

    public function testHasLowerCase()
    {
        $this->assertTrue(Str::hasLowercase('uppercase'));
        $this->assertTrue(Str::hasLowerCase('upperCase'));
        $this->assertFalse(Str::hasLowerCase('UPPERCASE'));
    }
}
