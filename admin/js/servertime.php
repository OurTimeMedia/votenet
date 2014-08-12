<?php

// The statement above can even be placed in the <head> section of your page.
// 
// Supress errors
error_reporting(0);

$myTimeZone = -6;  //Edit for your timezone EST=-5 CST=-6 MST=-7 PST =-8 etc.
$daylight = 1; // Set to 1 if you observe daylight savings time, 0 if not
//
$myoffs = ($myTimeZone * 3600) - date("Z"); //number of seconds my zone - the server differs from UTC
$now = time() + $myoffs;  // Get my standard time & date off of UTC
	if ($daylight){
		$myoffs = $myoffs + DST($now)*3600;  // Correct for DST if date is in range
	}
// Get server date
$mydate = date("U");

// Adjust offsets for local machine
print "var tzoffset = $myoffs + (new Date().getTimezoneOffset()*60);";

// Set JavaScript variable to your server time as seen from client machine's location.
print "var servertimeOBJ=new Date(($mydate+tzoffset)*1000);";

//This function determines if the date is during daylight savings time in the USA
function DST ($date_ck){

		$DST_begin = OCR(2,0,3,date("Y",$date_ck)); //Find 2nd Sunday in March
		$DST_end = OCR(1,0,11,date("Y",$date_ck));  //Find 1st Sunday in November
	
	if (($date_ck >= $DST_begin) && ($date_ck + 3600 <= $DST_end)){
	return (1); // return one if DST is in effect on this date
	}
	else{
	return (0);  // return zero if DST is not in effect on this date
	}
}
//
// this function finds the requested (1st 2nd etc.)occurance of a day (0=Sunday - 6=Saturday) in the month (1-12) and year (xxxx) requested
function OCR ($occur,$day,$month,$year){
	$occur--;					//Decrement so multiplication works later
	if ($occur < 0){$occur = 0;}		//Limit to positive interger
 	if ($occur > 4){$occur = 4;}		//Limit to 5th occurance in month
 	$dom = 1;
 	$Ocr_date = mktime (2,0,0,$month,$dom,$year); //Start at 2:00am on 1st of the month
 	while (date("w",$Ocr_date) != $day){  //Check to see if it is the day wanted
 	$dom++;	//Increment the day of the month
 	$Ocr_date = mktime (2,0,0,$month,$dom,$year); //Update the date
 	}
 	$dom = $dom + ($occur*7); //Add 7 times the occurance to the first occurance to get our date
 	if ($dom > date("t")){$dom = $dom - 7;} // If past the end of the month, subtract 7 days (finds last occurance in month)
 	$Ocr_date = mktime (2,0,0,$month,$dom,$year); //Update the date
return $Ocr_date;	//return the date found
}

?>