<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Common\PasswordManipulation;

class PasswordManipulationTest extends TestCase
{
    public function testGeneratePassword()
    {
        $pass = new PasswordManipulation();
        $this->assertNotEmpty($pass->generatePassword(11));
    }

    public function testCountTes()
    {
        $pass = new PasswordManipulation();
        $this->assertSame(6, $pass->len(123456));
    }

    public function testIsValid()
    {
        $pass = new PasswordManipulation();
        $this->assertTrue($pass->isValid($pass->generatePassword(15)));
        $this->assertFalse($pass->isValid('1234dasd'));
    }

    public function testSetLength()
    {
        $pass = new PasswordManipulation();
        $pass->setLength(21);
        $this->assertNotEmpty($this->getLength());
    }

    public function testGetLength()
    {
        $pass = new PasswordManipulation();
        $this->assertNotEmpty($this->getLength());
    }
}
