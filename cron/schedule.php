<?php
define("SERVER_ROOT","/var/www/html/");
define("DB_PREFIX","ei_");
define("MAIN_DB_NAME","`election_impact_production`");

$db_host="eimdb.sterling.local";
$db_name="election_impact_production_reports";
$db_user="eiadmin";
$db_password="V0t3n3tdbadmin";
$sestime=1000;
$link = mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name);

function __autoload($className)
{
	require_once (SERVER_ROOT."common/class/cls".$className.".php");
}

$objCronReport = new cron_report();
$new_last_voter_id = $objCronReport->getLastVoterId();
$masterArr = $objCronReport->getRptMasterInformation();
$last_inserted_date = $masterArr['report_date'];
$last_field_id = $masterArr['last_field_id'];
$last_voter_id = $masterArr['last_voter_id'];

$objCronReport->addFieldDetail();
$objCronReport->addPageDetail();
$objCronReport->addClientDetail();

$new_last_field_id = $objCronReport->alterRegistrationTable($last_field_id);


/**START********************************  State By State Summary Report   ***********************************************/

$last_inserted_date = $masterArr['report_date'];
$today = date("Y-m-d");
while($last_inserted_date != $today)
{	
	$objCronReport->addStateRptDetail($last_inserted_date, $new_last_voter_id);
	$last_inserted_date = date("Y-m-d",strtotime($last_inserted_date)+86400);	
}	
$objCronReport->addStateRptDetail($today, $new_last_voter_id);
/**END********************************  State By State Summary Report   ***********************************************/

/**START********************************  Registration Source Report   ***********************************************/

$last_inserted_date = $masterArr['report_date'];
$today = date("Y-m-d");
while($last_inserted_date != $today)
{	
	$objCronReport->addRegSourceRptDetail($last_inserted_date, $new_last_voter_id);
	$last_inserted_date = date("Y-m-d",strtotime($last_inserted_date)+86400);	
}	
$objCronReport->addRegSourceRptDetail($today, $new_last_voter_id);
/**END********************************  Registration Source Report   ***********************************************/

/**START********************************  Most Active Times Of The Day Report   ***********************************************/
$last_inserted_date = $masterArr['report_date'];
$today = date("Y-m-d");
while($last_inserted_date != $today)
{	
	$objCronReport->addRegTimingDetail($last_inserted_date, $new_last_voter_id);
	$last_inserted_date = date("Y-m-d",strtotime($last_inserted_date)+86400);	
}	
$objCronReport->addRegTimingDetail($today, $new_last_voter_id);
/**END********************************  Most Active Times Of The Day Report   ***********************************************/


/**START********************************  Hits Report   ***********************************************/
$last_inserted_date = $masterArr['report_date'];
$today = date("Y-m-d");
while($last_inserted_date != $today)
{	
	$objCronReport->addHitDetail($last_inserted_date);
	$last_inserted_date = date("Y-m-d",strtotime($last_inserted_date)+86400);	
}	
$objCronReport->addHitDetail($today);
/**END********************************  Hits Report   ***********************************************/

$objCronReport->addVoterRegistrationDetail($last_voter_id, $new_last_voter_id);

$objCronReport->addRptMasterInformation($today, $new_last_voter_id, $new_last_field_id);
?>
