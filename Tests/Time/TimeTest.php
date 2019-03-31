<?php

namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Zest\Time\Time;

class TimeTest extends TestCase
{
	public function testLeapYear()
	{
	 	$this->assertTrue(Time::isLeapYear(2020));
	 	$this->assertFalse(Time::isLeapYear(2019));
	}
}
