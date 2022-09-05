<?php

function secToHHmm($seconds = 0)
{
	return sprintf('%02d:%02d', ($seconds/ 3600),$seconds/ 60 % 60);
}

function hhmmToSec($time)
{
	$a = explode(':', $time);
	$sec = ($a[0] * 3600) + ( $a[1] * 60);
	return $sec;
}

function sectoHH($seconds)
{
	$h = round($seconds / 3600);
	return (int) $h;
}

function timeDiffHHmm($firstTime,$lastTime) {
	hhmmToSec($lastTime);
    
    $firstTime=hhmmToSec($firstTime);
    $lastTime=hhmmToSec($lastTime);
    
    $timeDiff=$lastTime-$firstTime;
    return secToHHmm($timeDiff);    
}
function getWidth($value,$max)
{
	if($max == 0)
	{
		return "0";
	}
	else
	{
		$c = ($value * 100) / $max;
		return round($c);	
	}
}

function convertToHH($time)
{
	$a = explode(':', $time);	
	$b = intval($a[0]);
	return $b;
}

