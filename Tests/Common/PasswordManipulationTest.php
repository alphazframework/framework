<?php

namespace Framework\Tests\Common;

use PHPUnit\Framework\TestCase;
use Zest\Common\PasswordManipulation;

class PasswordManipulationTest extends TestCase
{
    public function testGeneratePassword()
    {
        $pass = new PasswordManipulation();
        $this->assertNotEmpty($pass->generatePassword());
    }

    public function testCountTes()
    {
        $pass = new PasswordManipulation();
        $this->assertSame(6, $pass->len(123456));
    }

    public function testIsValid()
    {
        $pass = new PasswordManipulation();
        $this->assertTrue($pass->isValid($pass->generatePassword()));
        $this->assertFalse($pass->isValid('1234dasd'));
    }

    public function testSetLength()
    {
        $pass = new PasswordManipulation();
        $pass->setLength(21);
        $this->assertNotEmpty($pass->getLength());
    }

    public function testGetLength()
    {
        $pass = new PasswordManipulation();
        $this->assertNotEmpty($pass->getLength());
    }
}
