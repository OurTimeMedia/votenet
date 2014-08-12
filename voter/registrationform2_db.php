<?php	
$domain = $_REQUEST['domain'];
$objWebsite = new website();
$condition = " AND domain='".$domain."' ";
$client_id = $objWebsite->fieldValue("client_id","",$condition);
$is_sharing = $objWebsite->fieldValue("is_sharing","",$condition);
$sharing_redirect_url = $objWebsite->fieldValue("sharing_redirect_url","",$condition);

if((isset($_POST['btnsubmit1']) && $_POST['btnsubmit1'] != "") || (isset($_POST['btnsubmit1_x']) && $_POST['btnsubmit1_x'] != "") )
{
require_once (COMMON_CLASS_DIR ."clscommon.php");
$cmn = new common();

require_once (COMMON_CLASS_DIR ."clsvoter.php");
$objVoter = new voter();
$objVoter->client_id = $client_id;
$objVoter->voter_email = $cmn->getSession('voter_email');
$objVoter->voter_state_id = $cmn->getSession('Home_State_ID');
$objVoter->voter_zipcode = $cmn->getSession('Home_ZipCode');
$objVoter->voter_isactive = 1;
$objVoter->created_by = 0;
$objVoter->updated_by = 0;
if ($cmn->getSession('votingSource') != "")
{
	$objVoter->voter_reg_source = $cmn->getSession('votingSource');	
}	

$objVoter->add();

require_once (COMMON_CLASS_DIR ."clsentry.php");
$objEntry = new entry();
$objEntry->voter_id = $objVoter->voter_id;
$objEntry->entry_status = 1;
$objEntry->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
$objEntry->created_by = $objEntry->voter_id;
$objEntry->updated_by = $objEntry->voter_id;
$objEntry->entry_id = $objEntry->insertEntryForm();
				
require_once (COMMON_CLASS_DIR ."clsfield.php");
$objField = new field();
$objField->client_id = $client_id;
$objField->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
	
foreach($_POST as $key => $value)
{
	if(!is_array($value)) 
		$value = $cmn->readValue($value);
	
	if(strpos($key,"frmfld")!==false)
	{
		$keyValue = explode("_",$key);
		
		if(isset($keyValue[2]) && $keyValue[2]!="" && $value!="") {
		
			$objEntry->field_caption = addslashes($objField->fieldValueFront("field_caption",$keyValue[2]));			
			$objEntry->created_by = $objVoter->voter_id;
			$objEntry->updated_by = $objVoter->voter_id;
			
			if(!is_array($value)) {
				$sValue = explode("_",$value);
				if(isset($sValue[3]) && $sValue[3]!="")
				{	$objEntry->field_value = $sValue[3]; 
				} else
				{	$objEntry->field_value = addslashes($cmn->readValue($value)); 
				} 
			}
			else {
				$objEntry->field_value = "";
			}
			
	
			$objEntry->field_id = $keyValue[2];
			$objEntry->entry_detail_id = $objEntry->insertEntryDetail();
			
			if (is_array($value))
			{			
				foreach($value as $key_arr => $value_arr)
				{
					$value_arrv = explode("_",$value_arr);
					$objEntry->field_option_id = $value_arrv[0];
					$objEntry->field_id = $keyValue[2];
					$objEntry->field_option_value = $objEntry->fieldValueFront("field_option",$objEntry->field_option_id);
					$objEntry->insertEntryOptions();
				}				
			}
		}
	}	
}

$ismobile = ismobile();

if($ismobile == 1)
{
require_once (COMMON_CLASS_DIR ."clsencdec.php");
$objEncDec = new encdec();

$emailTo = $cmn->getSession('voter_email');
$emailFrom = "no-reply@votenet.com";

$registration_link = SERVER_HOST."download_registration_form.php?eid=".$objEncDec->encrypt($objEntry->entry_id);
$objEntry->entrySubmissionMail(ENTRY_MAIL_TO_VOTER,$emailTo,$emailFrom, SERVER_HOST, $registration_link, $client_id);	

exit;
}

require_once (COMMON_CLASS_DIR ."clsclient.php");
$objClient = new client();

require_once (COMMON_CLASS_DIR ."clsstate.php");
$objState=new state();
$conditionStateData = "  and s.state_id=".$cmn->getSession('Home_State_ID');
$statedetail = $objState->fetchStateAddressInfoFront(1,$conditionStateData);

$ch = curl_init();
$timeout = 5;
$postdata = "";

if( is_array( $_POST ) )
{
	$postdataarr = array();
	foreach($_POST as $pkey=>$pval)
	{
		if($pkey == "ForPDF")
		{
			foreach($pval as $ppkey=>$ppval)
			{
				$postdata.= $ppval['field_id']."|^|".$ppval['field_mapping_id']."|^|".$ppval['pdffieldname']."|^|".$cmn->readValue($ppval['value'])."######";
			}
			
			$postdata = "ForPDF=".$postdata;
		}			
	}
	
$postdata = $postdata."&client_id=".$_POST['client_id'];
$postdata = $postdata."&lang=".$cmn->getSession('voter_language_code');
$postdata = $postdata."&pdfAddressField1=".$cmn->readValue($statedetail[0]['state_secretary_fname'])." ".$cmn->readValue($statedetail[0]['state_secretary_mname'])." ".$cmn->readValue($statedetail[0]['state_secretary_lname']);
$postdata = $postdata."&pdfAddressField2=".$cmn->readValue($statedetail[0]['state_address1']);
$postdata = $postdata."&pdfAddressField3=".$cmn->readValue($statedetail[0]['state_address2']);
$postdata = $postdata."&pdfAddressField4=".$cmn->readValue($statedetail[0]['state_city'])." ".$statedetail[0]['state_code']." ".$statedetail[0]['zipcode'];
}
?>
<script type="text/javascript">
// setTimeout("redirectPage();",3000);

function downloadPDF(rand)
{
	<?php if ($cmn->getSession('votingSource') == "Facebook"){ ?>
	document.getElementById('pdfgeneration').innerHTML = "<h1 class='download_h1'><?php echo LANG_DOWNLOAD_YOUR_NATIONAL_VOTER_REGISTERATION_FORM;?>:</h1><div class='step-table'><div style='width:100%; text-align:center; padding-top:10px;  padding-bottom:20px;'><strong><?php echo LANG_YOU_ARE_DONE_DONT_FORGET_TO_SEND;?></strong><br><br><strong><?php echo str_replace('"',"'",LANG_ADOBE_REQUIRED_TEXT);?></strong><br><br><a href='pdfdownload.php?rand="+rand+"' target='_blank'><img src='../images/<?php echo BTN_DOWNLOAD;?>' border='0'></a></div></div>";
	<?php } else { ?>
	document.getElementById('pdfgeneration').innerHTML = "<h1 class='download_h1'><?php echo LANG_DOWNLOAD_YOUR_NATIONAL_VOTER_REGISTERATION_FORM;?>:</h1><div class='step-table'><div style='width:100%; text-align:center; padding-top:10px; padding-bottom:20px;'><strong><?php echo LANG_YOU_ARE_DONE_DONT_FORGET_TO_SEND;?></strong><br><br><strong><?php echo str_replace('"',"'",LANG_ADOBE_REQUIRED_TEXT);?></strong><br><br><a href='pdfdownload.php?rand="+rand+"' target='_blank' onclick='moveto3rdstep();'><img src='../images/<?php echo BTN_DOWNLOAD;?>' border='0'></a></div></div>";
	<?php } ?>
}

function moveto3rdstep()
{
	setTimeout("redirectPage();",1000);
}

<?php if($is_sharing == 0) { ?>
function redirectPage(rand)
{	
	document.getElementById('pdfgeneration').innerHTML = "<h1 class='download_h1'><?php echo LANG_DOWNLOAD_YOUR_NATIONAL_VOTER_REGISTERATION_FORM;?>:</h1><div class='step-table'><div style='width:100%; text-align:center; height:100px; padding-top:10px;'><strong><?php echo LANG_THANKS_FOR_DOWNLOAD_NVRF;?></strong></div></div>";
	
	<?php if($sharing_redirect_url != "") { ?>
	location.href="<?php echo $sharing_redirect_url;?>";
	<?php } ?>
}
<?php } else { ?>
function redirectPage(rand)
{	
	document.getElementById('pdfgeneration').innerHTML = "<h1 class='download_h1'><?php echo LANG_DOWNLOAD_YOUR_NATIONAL_VOTER_REGISTERATION_FORM;?>:</h1><div class='step-table'><div style='width:100%; text-align:center; height:100px; padding-top:10px;'><strong><?php echo LANG_THANKS_FOR_DOWNLOAD_NVRF;?></strong></div></div>";
	
	location.href="registrationform3.php?entry_id=<?php echo $objEntry->entry_id;?>&voter_id=<?php echo $objVoter->voter_id;?>";
}
<?php } ?>
</script>

<iframe src="pdfcreation.php?data=<?php echo rawurlencode($postdata);?>" id="pdfdownload" width="1" height="1" style="border:none;"></iframe>
<?php } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<script type="text/javascript">
setTimeout("redirectPage();",1000);

function redirectPage()
{
	location.href="index.php";
}
</script>
</body>
</html>
<?php } ?>