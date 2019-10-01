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
        $this->assertTrue(Str::hasUpperCase('Éé'));
    }

    public function testHasLowerCase()
    {
        $this->assertTrue(Str::hasLowerCase('iou'));
    }

    public function testConvertStringToLowercase()
    {
        $this->assertEquals(
            "hello world123",
            Str::convertStringAsLowerCase("Hello World123")
        );
        $this->assertEquals(
            "asd",
            Str::convertStringAsLowerCase("asd")
        );
    }

    public function testConvertStringToUpercase()
    {
        $this->assertEquals(
            "HELLO WORLD123",
            Str::convertStringToUppercase("Hello World123")
        );
        $this->assertEquals(
            "ASD",
            Str::convertStringToUppercase("asd")
        );
        $this->assertEquals(
            "ASD",
            Str::convertStringToUppercase("ASD")
        );
    }

    public function testGetSubstring()
    {
        $this->assertEquals(
            "World",
            Str::getSubstring(
                "Hello World",
                6
            )
        );
        $this->assertEquals(
            "lo Wor",
            Str::getSubstring(
                "Hello World",
                3,
                8
            )
        );
        $this->assertEquals(
            "rldHel",
            Str::getSubstring(
                "Hello World",
                8,
                13
            )
        );
        $this->assertEquals(
            "",
            Str::getSubstring(
                "Hello World",
                1,
                -10
            )
        );
    }
}
