<?php
require_once 'include/general_includes.php';
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$objEncDec = new encdec();
$objpaging = new paging();
$objState = new state();
$rid = 0;

if (isset($_REQUEST['rid']) && trim($_REQUEST['rid'])!="")
{
	$rid = $objEncDec->decrypt($_REQUEST['rid']);	
}

if (!($cmn->isRecordExistsReport("rpt_registration", "rpt_reg_id", $rid, "")))
	$msg->sendMsg("registrants_list.php","",46);

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$ch = curl_init();
$timeout = 5;
$rand = rand();
$postdata = "";

$objFieldReport = new field();
$objFieldReport->language_id = 1;
$objFieldReport->client_id = $client_id;
$condSub = "";
$fieldListSub = $objFieldReport->fetchAllFieldReport($client_id, $condSub);

$objRegistrant = new registrantreport();
$objRegistrant->client_id = $client_id;
$entryDetailArr = $objRegistrant->setAllValues($rid);

$objState=new state();
$conditionStateData = "  and s.state_id=".$entryDetailArr['voter_state_id'];
$statedetail = $objState->fetchStateAddressInfoFront($entryDetailArr['voter_language_id'],$conditionStateData);

foreach($fieldListSub as $flskey=>$flsval)
{
	if($flsval['pdf_field_name'] != "")
		$postdata.= $flsval['rpt_field_id']."|^|".$flsval['field_mapping_id']."|^|".$flsval['pdf_field_name']."|^|".$cmn->readValue($entryDetailArr['field_'.$flsval['rpt_field_id']])."######";
}
								 
$postdata = "ForPDF=".$postdata;
$postdata = $postdata."&pdfAddressField1=".$statedetail[0]['state_secretary_fname']." ".$statedetail[0]['state_secretary_mname']." ".$statedetail[0]['state_secretary_lname'];
$postdata = $postdata."&pdfAddressField2=".$statedetail[0]['state_address1'];
$postdata = $postdata."&pdfAddressField3=".$statedetail[0]['state_address2'];
$postdata = $postdata."&pdfAddressField4=".$statedetail[0]['state_city']." ".$statedetail[0]['state_code']." ".$statedetail[0]['zipcode'];
			
$fp = @fopen(VOTER_PDF_DIR."tempvoter".$rand.".pdf", "w");	
curl_setopt($ch,CURLOPT_URL,"http://www.electionimpact.com/SetaPDF/Demos/demo1.php");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
curl_setopt($ch, CURLOPT_POST, true );
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<script type="text/javascript">
parent.downloadPDF('<?php echo $rand;?>');
</script>
</body>
</html>