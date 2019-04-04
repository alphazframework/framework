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

    public function testNow()
    {
        $this->assertIsInt(Time::now());
        $this->assertIsInt(Time::now('Asia/Taipei'));
    }

    public function daysInMonthDataProvider()
    {
        return [
            [2, 2019, 28],
            [3, 2019, 31],
            [4, 2019, 30],
            [2, 2012, 29],
            [2, 2016, 29],
        ];
    }

    /**
     * @dataProvider daysInMonthDataProvider
     */
    public function testDaysInMonth($month, $year, $expected)
    {
        $this->assertSame($expected, Time::daysInMonth($month, $year));
    }

    public function formatsSecondsDataProvider()
    {
        return [
            [1554339600, '09:00:00'],
            [1554343200, '10:00:00'],
        ];
    }

    /**
     * @dataProvider formatsSecondsDataProvider
     */
    public function testFormatsSecondsDataProvider($seconds, $expected)
    {
        $this->assertSame($expected, Time::formatsSeconds($seconds, 'Asia/Taipei'));
    }
}
