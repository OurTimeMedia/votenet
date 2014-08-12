<?php
session_start();
require_once ("../common/include/connect.php");
require_once ("../common/class/clscommon.php");
require_once ("../common/class/clselection_date.php");
define("DB_PREFIX","ei_");
error_reporting(0);
$objelectiondate=new election_date();
//print_r($_SESSION);
$condition=" and ed.election_type_id =1 and ed.state_id=".$_REQUEST['sid'];
$electiondatedata=$objelectiondate->fetchAllAsArray($_REQUEST['sid'],$condition);

//print_r($electiondatedata);

$calStr = "BEGIN:VCALENDAR
VERSION:2.0
X-WR-CALNAME:Election Impact
CALSCALE:GREGORIAN
METHOD:PUBLISH";

for($i=0;$i<count($electiondatedata);$i++)
{
$calStr.= "
BEGIN:VEVENT
LOCATION:
DTSTAMP:".str_replace("-","",$electiondatedata[$i]['created_date'])."T000000
DTSTART:".str_replace("-","",$electiondatedata[$i]['election_date'])."T000001
SEQUENCE:1
PRIORITY:1
SUMMARY:".$electiondatedata[$i]['election_description']."
DTEND:".str_replace("-","",$electiondatedata[$i]['election_date'])."T235959
DESCRIPTION:".$electiondatedata[$i]['election_description']."
END:VEVENT";
}

$calStr.= "
END:VCALENDAR";

header("Content-Disposition: attachment; filename=ElectionImpactV5.ics");
header("Content-type: application/octet-stream");
header('Cache-Control: no-store, no-cache, must-revalidate');
header("Pragma: ");
header("Content-Length: " . strlen($calStr));
echo $calStr;
?>