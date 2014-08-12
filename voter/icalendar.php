<?php
session_start();
require_once ("../common/include/connect.php");
require_once ("../common/class/clscommon.php");
require_once ("../common/class/clselection_date.php");
define("DB_PREFIX","ei_");
error_reporting(0);
$objelectiondate=new election_date();
//print_r($_SESSION);
$condition=" and ed.election_type_id =1 and ed.state_id=".$_SESSION['EI_VOTER_SESSION_Home_State_ID'];
$electiondatedata=$objelectiondate->fetchAllAsArray($_SESSION['EI_VOTER_SESSION_Home_State_ID'],$condition);

$fullPath="ical.ics";
$buffer='';
//print "<pre>";
//print_r($electiondatedata);
for($i=0;$i<count($electiondatedata);$i++)
{
	$str.="BEGIN:VEVENT
LOCATION:Election
DTSTART;VALUE=".str_replace("-",'',$electiondatedata[$i]['election_date'])."T000000
DTSTAMP:".str_replace("-",'',$electiondatedata[$i]['created_date'])."T000000
SEQUENCE:1
PRIORITY:1
SUMMARY:".$electiondatedata[$i]['election_description']."
DTEND;VALUE=".str_replace("-",'',$electiondatedata[$i]['election_date'])."T000000
DESCRIPTION:".$electiondatedata[$i]['election_description']."
END:VEVENT";
}
if ($fd = fopen ($fullPath, "r")) {
    $fsize = filesize($fullPath);
	header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Pragma: no-cache');
	header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=ElectionImpactV4.ics");
    
	
    while(!feof($fd)) 
	{
        $buffer = fread($fd, 2048);

		/*$buffer =str_replace("{{summary}}",$electiondatedata[0]["election_description"],$buffer);
		$buffer =str_replace("{{Description}}",$electiondatedata[0]["election_description"],$buffer);
		$buffer =str_replace("{{STARTDATE}}",str_replace("-",'',$electiondatedata[0]["election_date"]),$buffer);
		$buffer =str_replace("{{ENDDATE}}",str_replace("-",'',$electiondatedata[0]["election_date"]),$buffer);*/
		
		$buffer =str_replace("{{electiondatedata}}",$str,$buffer);
		
		
		
		$buffer =str_replace("{{summary1}}",$electiondatedata[0]["reg_deadline_description"],$buffer);
		$buffer =str_replace("{{Description1}}",$electiondatedata[0]["reg_deadline_description"],$buffer);
		$buffer =str_replace("{{STARTDATE1}}",$electiondatedata[0]["reg_deadline_date"],$buffer);
		$buffer =str_replace("{{ENDDATE1}}",$electiondatedata[0]["reg_deadline_date"],$buffer);
		echo $buffer;
    }
}
fclose ($fd);
exit;


/*
$ical =    'BEGIN:VCALENDAR
PRODID:-//Microsoft Corporation//Outlook 11.0 MIMEDIR//EN
VERSION:2.0
METHOD:PUBLISH
BEGIN:VEVENT
ORGANIZER:MAILTO:'.$from_address.'
DTSTART:20110706T151200
DTEND:20110712T195000
LOCATION:Election
TRANSP:OPAQUE
SEQUENCE:0
UID:'.$cal_uid.'
DTSTAMP:'.$todaystamp.'
DESCRIPTION:Registration date for election is today
SUMMARY:'.$subject.'
PRIORITY:5
CLASS:PUBLIC
END:VEVENT
END:VCALENDAR'; 
*/
?>