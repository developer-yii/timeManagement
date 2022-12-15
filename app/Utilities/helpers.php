<?php

function secToHHmm($seconds = 0)
{
	return sprintf('%02d:%02d', ($seconds/ 3600),$seconds/ 60 % 60);
}

function secToHHPart($seconds = 0)
{
	if($seconds)
	{
		$hhmm = sprintf('%02d:%02d', ($seconds/ 3600),$seconds/ 60 % 60);

		$a = explode(':', $hhmm);
		return $a[0].':00';
	}

	return 0;
}

function secTOmmPart($seconds = 0)
{
	if($seconds)
	{
		$hhmm = sprintf('%02d:%02d', ($seconds/ 3600),$seconds/ 60 % 60);

		$a = explode(':', $hhmm);
		return '00:'.$a[1];
	}

	return 0;
}

function secToHHmm4($seconds = 0)
{
	return sprintf('%04d:%02d', ($seconds/ 3600),$seconds/ 60 % 60);
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
	
	$firstTime=hhmmToSec($firstTime);
    $lastTime=hhmmToSec($lastTime);
    
    $timeDiff=$lastTime-$firstTime;
    if($timeDiff < 0)
    	return "00:00";    
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

function pdfDate($date)
{
	if($date)
	{
		$date = date_create($date);
        return date_format($date,"F jS, Y");
	}

	return 0;
}

function pdfTableDate($date)
{
	if($date)
	{
		$date = date_create($date);
        return date_format($date,"l, F jS");
	}

	return 0;
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

function isSubscriptionActive()
{
	$s = \Auth::user()->subscription('Basic');
	if(!$s)
	{
		return false;
	}
	$sub = \Auth::user()->subscription('Basic')->asStripeSubscription();
    
    $current_time = \Carbon\Carbon::now();
    $expire_time = \Carbon\Carbon::createFromTimeStamp($sub->current_period_end);

    if($current_time > $expire_time)
    {
        return false;
    }
    else
    {
        return true;
    }    
}

function dddd($data)
{
	print_r($data);
	die;
}
