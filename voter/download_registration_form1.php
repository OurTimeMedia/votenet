<?php
define("REPORT_DB_PREFIX","election_impact_production_reports.ei_");
$page_id = 0;
require_once("include/common_includes.php");
require_once("include/general_includes.php");
require_once (COMMON_CLASS_DIR ."clsencdec.php");
require_once (COMMON_CLASS_DIR ."clsstate.php");

$objEncDec = new encdec();
$objState = new state();
$eid = 0;

if (isset($_REQUEST['eid']) && trim($_REQUEST['eid'])!="")
{
	$eid = $objEncDec->decrypt($_REQUEST['eid']);	
}

$eid = 5197;

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$ch = curl_init();
$timeout = 5;
$rand = rand();
$postdata = "";

$objentry = new entry1();
$objentry->setAllValues($eid);

$objvoter = new voter();
$objvoter->setAllValues($objentry->voter_id);

$objState=new state();
$conditionStateData = "  and s.state_id=".$objvoter->voter_state_id;
$statedetail = $objState->fetchStateAddressInfoFront($objentry->language_id,$conditionStateData);


$objFieldReport = new field();
$objFieldReport->language_id = $objentry->language_id;
$objFieldReport->client_id = $objvoter->client_id;
$condSub = "";
$fieldListSub = $objFieldReport->fetchAllFieldReport($client_id, $condSub);

$entryDetailArr = $objentry->fetchEntryDetailVal($eid);

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

$content = file_get_contents(VOTER_PDF_DIR."tempvoter".$rand.".pdf");
header("Content-type: application/pdf");
header("Content-Disposition:attachment;filename=voter".$rand.".pdf");
header("Content-Length: " . strlen($content));        
echo $content;
unlink(VOTER_PDF_DIR."tempvoter".$_REQUEST['rand'].".pdf");
?>