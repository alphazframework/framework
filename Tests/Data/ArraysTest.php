<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Data\Arrays;

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

    public function testMultiToAssocWithSpecificOpr()
    {
        $opr = '@';
        $array = Arrays::multiToAssocWithSpecificOpr(['foo' => ['bar' => 'baz']], $opr);
        $this->assertEquals(['foo@bar' => 'baz'], $array);
        $array = Arrays::multiToAssocWithSpecificOpr(['name' => 'Alex', 'languages' => ['cpp' => true]], $opr);
        $this->assertEquals($array, ['name' => 'Alex', 'languages@cpp' => true]);
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
        $array = ['name' => 'AleX'];
        $this->assertSame(['name' => 'alex'], Arrays::arrayChangeCaseValue($array));
        $this->assertNotSame(['name' => 'Alex'], Arrays::arrayChangeCaseValue($array));
        $this->assertSame(['name' => 'ALEX'], Arrays::arrayChangeCaseValue($array, CASE_UPPER));
        $this->assertNotSame(['name' => 'Alex'], Arrays::arrayChangeCaseValue($array, CASE_UPPER));
    }

    public function testRemoveDuplicates()
    {
        $dataSet1 = [
            'users' => 
            [
                'id'       => 1,
                'name'     => "Umer",
                'username' => 'peter',
            ],
            [
                'id'       => 2,
                'name'     => "Umer",
                'username' => 'umer01'
            ],
            [
                'id'       => 3,
                'name'     => "Peter Khot",
                'username' => 'peter',
            ]
        ];
        $dataSet2 = ["a" => "green", "red", "b" => "green", "blue", "red"];
        $dataSet3 = [1,2,3,4,2,5,6,3,7,8,9];

        $this->assertSame([
            0 => [
                'id'       => 1,
                'name'     => 'Umer',
                'username' => 'peter'
            ],
            1 => [
                'id'       => 2,
                'name'     => 'Umer',
                'username' => 'umer01'
            ],
        ], Arrays::removeDuplicates($dataSet1, 'username'));
        $this->assertSame(['a' => 'green', 0 => 'red', 1 => 'blue' ], Arrays::removeDuplicates($dataSet2, 'username'));
        $this->assertSame([
           0 => 1,
           1 => 2,
           2 => 3,
           3 => 4,
           4 => 5,
           5 => 6,
           6 => 7,
           7 => 8,
           8 => 9
        ], Arrays::removeDuplicates($dataSet3));
    }
}
