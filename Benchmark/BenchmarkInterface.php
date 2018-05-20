<?php 
namespace Softhub99\Zest_Framework\Benchmark;

interface BenchmarkInterface
{
	public static function start();
	public static function end();
	public static function elapsedTime(int $round);
}