<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Convert a stdClass to an Array.
function object_to_array(stdClass $Class){
    //# Typecast to (array) automatically converts stdClass -> array.
    $Class = (array)$Class;
   
    //# Iterate through the former properties looking for any stdClass properties.
    //# Recursively apply (array).
    foreach($Class as $key => $value){
        if(is_object($value)&&get_class($value)==='stdClass'){
            $Class[$key] = object_to_array($value);
        }
    }
    return $Class;
}

// Convert an Array to stdClass.
function array_to_object(array $array){
    //# Iterate through our array looking for array values.
    //# If found recurvisely call itself.
    foreach($array as $key => $value){
        if(is_array($value)){
            $array[$key] = array_to_object($value);
        }
    }
   
    //# Typecast to (object) will automatically convert array -> stdClass
    return (object)$array;
}

//function for get IP address
function getRealIpAddr()
{
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
}


    
function grab_image($url,$saveto)
{
    //$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, wie z. B. Gecko) Chrome/13.0.782.215 Safari/525.13.";
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	/** ignore ssl verificaion */
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	/** end of ignore ssl verification */
    $raw=curl_exec($ch);
    curl_close ($ch);
    if(file_exists($saveto)){
        unlink($saveto);
    }
    $fp = fopen($saveto,'x');
    fwrite($fp, $raw);
    fclose($fp);
}

function get_fb_last_work($work_array)
{
	foreach($work_array as $work)
	{
		if(!isset($last_work_time) || (isset($work->start_date) && (strtotime($work->start_date) > $last_work_time)))
		{
			if(isset($work->start_date))
				$last_work_time = strtotime($work->start_date);
			$last_work = $work->employer->name;
		}
	}
	
	return $last_work;
}

function get_fb_last_edu($edu_array)
{
	foreach($edu_array as $edu)
	{
		if(!isset($last_edu_time) || (isset($edu->year->name) && (strtotime($edu->year->name) > $last_edu_time)))
		{
			if(isset($edu->year->name))
				$last_edu_time = strtotime($edu->year->name);
			$last_edu = $edu->school->name;
		}
	}
	
	return $last_edu;
}
?>
