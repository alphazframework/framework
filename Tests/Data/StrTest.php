<?php

namespace Framework\Tests\Data;

use alphaz\Data\Str;
use PHPUnit\Framework\TestCase;

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
        $this->assertFalse(Str::hasUpperCase('camel'));
        $this->assertFalse(Str::hasUpperCase('camel!'));
        $this->assertTrue(Str::hasUpperCase('Uppercase'));
        $this->assertTrue(Str::hasUpperCase('uppercase in a String'));
        $this->assertTrue(Str::hasUpperCase('Éé'));
        $this->assertTrue(Str::hasUpperCase('#-<ae|9_+0a*a!Q?@(z,3R>.BAb)^%R&*+~RG:$'));
        $this->assertFalse(Str::hasUpperCase('#©-<ae|9_+0a*a!q?@(z,3r>.bab)^%r&*+~rg:$'));
    }

    public function testHasLowerCase()
    {
        $this->assertFalse(Str::hasLowerCase('CAMEL'));
        $this->assertFalse(Str::hasLowerCase('CAMEL!'));
        $this->assertTrue(Str::hasLowerCase('lowercase'));
        $this->assertTrue(Str::hasLowerCase('lowercase in STRING'));
        $this->assertTrue(Str::hasLowerCase('iou'));
        $this->assertTrue(Str::hasLowerCase('#-<ae|9_+0a*a!Q?@(z,3R>.BAb)^%R&*+~RG:$'));
        $this->assertFalse(Str::hasLowerCase('#©-<AE|9_+0A*A!Q?@(Z,3R>.BAB)^%R&*+~RG:$'));
    }

    public function testConvertCase()
    {
        $this->assertSame('AAaaĄaśćŻŹ', Str::ConvertCase('aaAAąAŚĆżź', 'UTF-8'));
        $this->assertSame('camel', Str::ConvertCase('CAMEL', 'UTF-8'));
        $this->assertSame('UPPERcase', Str::ConvertCase('upperCASE', 'UTF-8'));
        $this->assertSame('LOWERCASE IN string', Str::ConvertCase('lowercase in STRING', 'UTF-8'));
    }

    public function testIsBase64()
    {
        $this->assertFalse(Str::isBase64('4rdHFh%2BHYoS8oLdVvbUzEVqB8Lvm7kSPnuwF0AAABYQ%3D'));
        $this->assertTrue(Str::isBase64('YW1vdXJmYXlh'));
        $this->assertTrue(Str::isBase64('ejJlQUVFSFpCcUpjVDNlWW5WcEd0QQ=='));
        $this->assertTrue(Str::isBase64('dGhpc2lzdmFsaWR0ZXN0ZGF0YQ=='));
        $this->assertFalse(Str::isBase64('aWFtd3Jvbmc==='));
        $this->assertFalse(Str::isBase64('thisisnobase64encodedstring'));
    }

    public function testSubstring()
    {
        $this->assertSame('Amourfaya', Str::substring('Amourfaya', 0));
        $this->assertNotSame('Amourfaya', Str::substring('Amourfaya', 2, 4));
        $this->assertSame('ourf', Str::substring('Amourfaya', 2, 4));
        $this->assertSame('def', Str::substring('abcdef', 3, 3));
        $this->assertSame('def', Str::substring('abcdef', 3));
        $this->assertSame('ĄaśćŻ', Str::substring('AAaaĄaśćŻŹ', 4, 5));
        $this->assertSame('AbCdEf', Str::substring('AbCdEf', 0, 6, 'iso-8859-1'));
        $this->assertSame('ćŻŹ', Str::substring('ĄaśćŻŹ', 3, 3));
        $this->assertNotSame('ćŻŹ', Str::substring('ĄaśćŻŹ', 3, 3, 'iso-8859-1'));
    }

    public function testStripWhitespaces()
    {
        $this->assertSame('This string is stripped', Str::stripWhitespaces(' This string is stripped '));
        $this->assertNotSame(' This string is stripped ', Str::stripWhitespaces(' This string is stripped '));
    }

    public function testRepeat()
    {
        $this->assertSame('--', Str::repeat('--', 1));
        $this->assertNotSame('--', Str::repeat('--', 3));
        $this->assertSame('------', Str::repeat('--', 3));
        $this->assertSame('-=--=--=--=--=-', Str::repeat('-=-', 5));
    }

    public function testSlice()
    {
        $this->assertFalse(Str::slice('String', -3, -10));
        $this->assertSame(
            'The apple does not fall far from the tree',
            Str::slice('The apple does not fall far from the tree', 0)
        );
        $this->assertSame(
            'The apple does',
            Str::slice('The apple does not fall far from the tree', 0, 14)
        );
        $this->assertSame(
            'tree',
            Str::slice('The apple does not fall far from the tree', -4)
        );
        $this->assertNotSame('good shit', Str::slice('This is good shit', 8, 2));
    }

    public function testShuffle()
    {
        $this->assertNotSame('This is string is not shuffled', Str::shuffle('This string is not shuffled'));
    }
}
