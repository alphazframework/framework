<?php 
namespace Softhub99\Zest_Framework\Benchmark;

class Benchmark implements BenchmarkInterface
{
	public static $start;
	public static $end;
	public static function start(){
		static::$start = microtime(true);
	}
	public static function end(){
		static::$end = microtime(true);
	}
	public static function elapsedTime(int $round = null){
		$time = static::$end - static::$start;
		if(!is_null($round)){
			$time = round($time,$round);
		}
		return (float)$time;
	}
}