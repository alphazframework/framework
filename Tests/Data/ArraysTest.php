<?php

namespace Framework\Tests\Data;

use alphaz\Data\Arrays;
use PHPUnit\Framework\TestCase;

class ArraysTest extends TestCase
{
    public function testIsReallyArray()
    {
        $this->assertTrue(Arrays::isReallyArray([0, 1]));
        $this->assertTrue(Arrays::isReallyArray(['name' => 'someName', 'username' => '@username']));

        $this->assertFalse(Arrays::isReallyArray([]));
        $this->assertFalse(Arrays::isReallyArray(null));
        $this->assertFalse(Arrays::isReallyArray('abc'));
    }

    public function testIsSequential()
    {
        $this->assertFalse(Arrays::isSequential(['name' => 'Alex']));
        $this->assertTrue(Arrays::isSequential(['a', 'b']));
    }

    public function testIsAssoc()
    {
        $this->assertTrue(Arrays::isAssoc(['name' => 'Alex']));
        $this->assertFalse(Arrays::isAssoc(['a', 'b']));
    }

    public function testIsMulti()
    {
        $this->assertTrue(Arrays::isMulti(['members' => [
            'user1' => [
                'name' => 'Alex',
            ],
        ]]));
        $this->assertFalse(Arrays::isMulti(['name' => 'Alex']));
    }

    public function testGetType()
    {
        $this->assertSame('indexes', Arrays::getType([1, 2, 3]));
        $this->assertSame('assoc', Arrays::getType([
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ]));
        $this->assertSame('multi', Arrays::getType([
            'a' => [
                'A' => 1,
                'B' => 2,
            ],
            'b' => [
                'A' => 1,
                'B' => 2,
            ],
        ]));
        $this->assertNotSame('assoc', Arrays::getType([1, 2, 3]));
        $this->assertNotSame('multi', Arrays::getType([
            'a' => 1,
            'b' => 2,
            'c' => 3,
        ]));
        $this->assertNotSame('indexes', Arrays::getType([
            'a' => [
                'A' => 1,
                'B' => 2,
            ],
            'b' => [
                'A' => 1,
                'B' => 2,
            ],
        ]));
    }

    public function testAdd()
    {
        $array = Arrays::add(['id' => 1001, 'name' => 'Alex'], 'username', 'alex01', null);
        $this->assertEquals(['id' => 1001, 'name' => 'Alex', 'username' => 'alex01'], $array);
    }

    public function testMultiToAssoc()
    {
        $arrays = ['members' => [
            'user' => [
                'name' => 'Alex',
            ],
        ],
        ];
        $assoc = Arrays::multiToAssoc($arrays);
        $this->assertEquals(['name' => 'Alex'], $assoc);
    }

    public function testDot()
    {
        $array = Arrays::dot(['foo' => ['bar' => 'baz']]);
        $this->assertEquals(['foo.bar' => 'baz'], $array);
        $array = Arrays::dot(['name' => 'Alex', 'languages' => ['cpp' => true]]);
        $this->assertEquals($array, ['name' => 'Alex', 'languages.cpp' => true]);
    }

    public function testDotWithAssocArray()
    {
        $array = Arrays::dot(['foo' => ['bar' => ['one', 'three', 'two']]], true);
        $this->assertEquals(['foo.bar' => ['one', 'three', 'two']], $array);
    }

    public function testMultiToAssocWithSpecificOpr()
    {
        $opr = '@';
        $array = Arrays::multiToAssocWithSpecificOpr(['foo' => ['bar' => 'baz']], $opr);
        $this->assertEquals(['foo@bar' => 'baz'], $array);
        $array = Arrays::multiToAssocWithSpecificOpr(['name' => 'Alex', 'languages' => ['cpp' => true]], $opr);
        $this->assertEquals($array, ['name' => 'Alex', 'languages@cpp' => true]);
    }

    public function testMultiToAssocWithSpecificOprWithAssocArray()
    {
        $opr = '@';
        $array = Arrays::multiToAssocWithSpecificOpr(['foo' => ['bar' => ['one', 'three', 'two']]], $opr, true);
        $this->assertEquals(['foo@bar' => ['one', 'three', 'two']], $array);
    }

    public function testExcept()
    {
        $array = ['name' => 'Alex', 'age' => 18];
        $this->assertEquals(['age' => 18], Arrays::except($array, ['name']));
    }

    public function testAppend()
    {
        $array = ['name' => 'Alex'];
        $this->assertEquals(['name' => 'Alex', 'age' => 18], Arrays::append($array, 18, 'age'));
    }

    public function testPrepend()
    {
        $array = ['name' => 'Alex'];
        $this->assertEquals(['age' => 18, 'name' => 'Alex'], Arrays::prepend($array, 18, 'age'));
    }

    public function testUnique()
    {
        $array = ['name' => 'bob', 'name' => 'Alex'];
        $this->assertEquals(['name' => 'Alex'], Arrays::unique($array));
    }

    public function testGet()
    {
        $array = ['member.user' => ['name' => 'Alex']];
        $this->assertEquals(['name' => 'Alex'], Arrays::get($array, 'member.user'));
    }

    public function testHas()
    {
        $array = ['member' => ['user' => ['name' => 'Alex']]];
        $this->assertTrue(Arrays::has($array, 'member.user.name', '.'));
        $this->assertFalse(Arrays::has($array, 'member.user.age', '.'));
        $this->assertTrue(Arrays::has(['' => 'some'], ['']));
        $this->assertFalse(Arrays::has([''], ''));
        $this->assertFalse(Arrays::has([], ''));
        $this->assertFalse(Arrays::has([], ['']));
    }

    public function testOnly()
    {
        $array = ['id' => 10, 'name' => 'Alex', 'age' => 18];
        $array = Arrays::subSetOfArray($array, ['name', 'age']);
        $this->assertEquals(['age' => 18, 'name' => 'Alex'], $array);
    }

    public function testPull()
    {
        $array = ['name' => 'Alex', 'age' => 18];
        $name = Arrays::pull($array, 'name');
        $this->assertEquals('Alex', $name);
    }

    public function testSet()
    {
        $array = ['members' => ['users' => ['name' => 'Alex']]];
        Arrays::set($array, 'members.users.name', 'Alex', '.');
        $this->assertEquals(['members' => ['users' => ['name' => 'Alex']]], $array);
    }

    public function testForget()
    {
        $array = ['members' => ['users' => ['name' => 'Alex']]];
        Arrays::forget($array, 'members.users', '.');
        $this->assertEquals(['members' => []], $array);
    }

    public function testArrayChangeCaseKey()
    {
        $array = ['Name' => 'Alex'];
        $this->assertSame(['name' => 'Alex'], Arrays::arrayChangeCaseKey($array));
        $this->assertNotSame(['Name' => 'Alex'], Arrays::arrayChangeCaseKey($array));
        $this->assertSame(['NAME' => 'Alex'], Arrays::arrayChangeCaseKey($array, CASE_UPPER));
        $this->assertNotSame(['name' => 'Alex'], Arrays::arrayChangeCaseKey($array, CASE_UPPER));
    }

    public function testArrayChangeCaseValue()
    {
        $array = ['name' => ['AleX', 'Peter']];
        $this->assertSame(['name' => ['alex', 'peter']], Arrays::arrayChangeCaseValue($array));
        $this->assertNotSame(['name' => ['Alex', 'Peter']], Arrays::arrayChangeCaseValue($array));
        $this->assertSame(['name' => ['ALEX', 'PETER']], Arrays::arrayChangeCaseValue($array, CASE_UPPER));
        $this->assertNotSame(['name' => ['Alex', 'Peter']], Arrays::arrayChangeCaseValue($array, CASE_UPPER));
    }

    public function removeDuplicatesDataProvider()
    {
        return [
            [
                [
                    'users' => [
                        'id'       => 1,
                        'name'     => 'Umer',
                        'username' => 'peter',
                    ],
                    [
                        'id'       => 2,
                        'name'     => 'Umer',
                        'username' => 'umer01',
                    ],
                    [
                        'id'       => 3,
                        'name'     => 'Peter Khot',
                        'username' => 'peter',
                    ],
                ],
                'username',
                [
                    0 => [
                        'id'       => 1,
                        'name'     => 'Umer',
                        'username' => 'peter',
                    ],
                    1 => [
                        'id'       => 2,
                        'name'     => 'Umer',
                        'username' => 'umer01',
                    ],
                ],
            ],
            [
                ['a' => 'green', 'red', 'b' => 'green', 'blue', 'red'],
                'username',
                ['a' => 'green', 0 => 'red', 1 => 'blue'],
            ],
            [
                [1, 2, 3, 4, 2, 5, 6, 3, 7, 8, 9],
                '',
                [
                    0  => 1,
                    1  => 2,
                    2  => 3,
                    3  => 4,
                    5  => 5,
                    6  => 6,
                    8  => 7,
                    9  => 8,
                    10 => 9,
                ],
            ],
        ];
    }

    /**
     * @dataProvider removeDuplicatesDataProvider
     */
    public function testRemoveDuplicates($dataSet, $specificKey, $expected)
    {
        $this->assertSame($expected, Arrays::removeDuplicates($dataSet, $specificKey));
    }

    public function testMostOccurring()
    {
        $dataSet = [1, 2, 3, 1, 4, 6, 3];
        $this->assertSame([1, 3], Arrays::mostOccurring($dataSet));
    }

    public function testLeastOccurring()
    {
        $dataSet = [1, 2, 1, 3, 1, 3];
        $this->assertSame([2], Arrays::leastOccurring($dataSet));
    }

    public function testQuery()
    {
        $this->assertSame('', Arrays::query([]));
        $this->assertSame('foo=bar', Arrays::query(['foo' => 'bar']));
        $this->assertSame('name=alex&age=18', Arrays::query(['name' => 'alex', 'age' => '18']));
    }

    public function testWhere()
    {
        $array = [100, '200', 300, '400', 500];
        $array = Arrays::where($array, function ($value, $key) {
            return is_string($value);
        });
        $this->assertEquals([1 => '200', 3 => '400'], $array);
    }

    public function testShuffle()
    {
        $array1 = range(0, 100, 10);
        $array2 = range(0, 100, 10);
        Arrays::shuffle($array1);
        Arrays::shuffle($array2);
        $this->assertEquals($array1, $array2);
    }

    public function testRandom()
    {
        $random = Arrays::random(['foo', 'bar', 'baz'], 1);
        $this->assertContains($random[0], ['foo', 'bar', 'baz']);
    }

    public function testPluck()
    {
        $dataSet = [
            ['developer' => ['id' => 1, 'name' => 'Alex']],
            ['developer' => ['id' => 2, 'name' => 'Peter']],
        ];
        $this->assertSame(['Alex', 'Peter'], Arrays::pluck($dataSet, 'name'));
    }
}
