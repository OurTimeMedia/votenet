<?php	
//exit;
require_once (COMMON_CLASS_DIR ."clscommon.php");
$cmn1 = new common();

require_once (COMMON_CLASS_DIR ."clsfield.php");
$objField = new field();
$objField->client_id = $objWebsite->client_id;
$objField->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);

require_once (COMMON_CLASS_DIR ."clsvalidationlang.php");
$objvalidation = new validationlang();
$hiddenvar = "";
foreach($_POST as $key => $value)
{
/*    if ($key == 'user_email' || $key == 'is_send_email') {
        $hiddenvar.= '<input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$value.'" />';
        continue;
    }*/


	if(is_array($value))
		$value = implode("|^|",$value);
	else 
		$value = $cmn->setVal(trim($cmn->readValueSubmission($value,"")));
	
	$hiddenvar.= '<input type="hidden" name="'.$key.'" id="'.$key.'" value="'.$cmn->readValue($value).'" />';	

	$keyValue = explode("_",$key);
	$hdnField = str_replace("frmfld","frmhdn",$key);
	$hdnValue = $_POST[$hdnField];
	
	if($hdnValue == 14 && $value != "" && $hdnField != $key)
	{
		$cmn1->setSession('Home_ZipCode', $value);	
	}

	$shwField = "";
	$isRequiredField = 0;
	if(isset($keyValue[2]) && $keyValue[2]!="") {
		$shwField = "frmshw_".$keyValue[2];

		$isRequiredField = $objField->fieldValue("is_required",$keyValue[2]);
		$fieldCaption = $cmn->readValueSubmission(addslashes($objField->fieldValueFront("field_caption",$keyValue[2])));
	}

	if($isRequiredField==1 && strpos($key,"frmfld")!==false && !is_array($value))
	{	
		if($shwField!="" && isset($_POST[$shwField]) && $_POST[$shwField]=="yes")
		{
			if($hdnValue==2 || $hdnValue==3 || $hdnValue==4 || $hdnValue==6 || $hdnValue==7 || $hdnValue==8 || $hdnValue==9 || $hdnValue==10 || $hdnValue==13 || $hdnValue==15)
			{	
				$objvalidation->addValidation($key, $fieldCaption, "selone");
			}
			if($hdnValue==11){
				$objvalidation->addValidation($key, $fieldCaption, "req");
				$objvalidation->addValidation($key, $fieldCaption, "date");				
			}
			else
			{					
				$objvalidation->addValidation($key, $fieldCaption, "req");
			}						
		}
	}
}

if($objvalidation->validateWithMessage())
{ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<form id="frm1" name="frm1" method="post" action="registrationform2.php">
<?php echo $hiddenvar;?>
</form>
<script type="text/javascript">
setTimeout('document.frm1.submit()', 200);
</script>
</body>
</html>
<?php exit; }
?>