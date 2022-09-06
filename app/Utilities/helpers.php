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

function generateReferralCode()
{    
    $length_of_string = 8;
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; 
    $generate_code = substr(str_shuffle($str_result), 0, $length_of_string);                    
    $code_exists = App\User::where('referral_code', '=', $generate_code)->first();
    if(!isset($code_exists->id)){
        return $generate_code;exit();
    }
    else{
    	generateReferralCode();
    }    	
}
