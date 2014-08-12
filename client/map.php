<?php
require_once 'include/general_includes.php';

$client_id = $_REQUEST['clientid'];

$objStateReg = new topclientreport();
$stateRs = $objStateReg->getAllStateByStateReportMap($client_id);

$stateData = array();
while($arrState= mysql_fetch_assoc($stateRs))
{ 
	if($arrState['tot_cnt'] == "")
		$arrState['tot_cnt'] = 0;
		
	$stateData[] = $arrState['state_code']."*".$arrState['tot_cnt']; 
} 

echo "rep_list=".implode(",", $stateData);;
?>