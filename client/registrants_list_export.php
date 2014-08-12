<?php 
require_once 'include/general_includes.php';
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

header('Content-Type: application/x-msexcel; name=RegistrantsList.xls');
header('Content-Disposition: inline;filename=RegistrantsList.xls');
header("Content-Transfer-Encoding: binary ");
	
	
$objpaging = new paging();
$userID = $cmn->getSession(ADMIN_USER_ID);
	
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$objRegistrant = new registrantreport();
$objRegistrant->client_id = $client_id;

$condition = '';
$objpaging->strorderby = "rr.rpt_reg_id";
$objpaging->strorder = "desc";

$condition.= " AND rr.client_id = '".$objRegistrant->client_id."' ";

if(isset($_REQUEST['txtdatefrom']))
{
	if (trim($_REQUEST['txtdatefrom'])!="")			
		$condition .= " AND DATE(rr.voting_date) >= date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdatefrom'])."', '%m/%d/%Y' ) , '%Y-%m-%d' )";								
}

if(isset($_REQUEST['txtdateto']))
{
	if (trim($_REQUEST['txtdateto'])!="")
		$condition .= " AND DATE(rr.voting_date) <= date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdateto'])."', '%m/%d/%Y' ) , '%Y-%m-%d' )";		
}

if(isset($_REQUEST['selState']))
{
	if (trim($_REQUEST['selState'])!="")
		$condition .= " AND rr.voter_state_id = '".$_REQUEST['selState']."'";								
}
	
$objRegistrant->pagingType = "cReports";
$pagedata = $objpaging->setPageDetails($objRegistrant,"registrants_list.php",-1,$condition);	
	
$objExcelWriter = new excelwriter();
// start the file
$objExcelWriter->xlsBOF();
// these will be used for keeping things in order.
$col = 0;
$row = 0;
// This tells us that we are on the first row
$first = true;
$str1 = "Voter Email^^^	Voter State^^^Voter Zip Code^^^Voting Date^^^Registration Source###";

for ($i=0;$i<count($pagedata);$i++)
{		 
	$str1.=$cmn->readValueDetail($pagedata[$i]['voter_email'])."^^^".$cmn->readValueDetail($pagedata[$i]['state_name'])."^^^".$cmn->readValueDetail($pagedata[$i]['voter_zipcode'])."^^^".$cmn->readValueDetail($pagedata[$i]['voting_date'])."^^^".$cmn->readValueDetail($pagedata[$i]['voter_reg_source'])."###";

}
	
$str1 = substr($str1,0,-3);

$aTest = explode('###', $str1);
for ($i=0; $i<count($aTest); $i++)
{
	$aItems = explode('^^^', $aTest[$i]);
	// go through the data
    foreach($aItems as $value)
    {
        // write it out
        $objExcelWriter->xlsWriteLabel( $row, $col, $value );
        $col++;
    }
    // reset col and goto next row
    $col = 0;
    $row++;
}
$objExcelWriter->xlsEOF();
exit();
?>