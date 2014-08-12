<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ;

//echo "<pre>";
//print_r($_POST);
	set_time_limit(0);
	$domain = $_REQUEST['domain'];
	
	$objWebsite = new website();
	$condition = " AND domain='".$domain."' ";
	$client_id = $objWebsite->fieldValue("client_id","",$condition);
	
	$form = array();
	
	$field = array();
	
	$field_options = array();
	
	$options = array();
	
	$arr_select  = array();
	$arr_checkbox = array();
	$arr_radio = array();
	
	$index = -1;

	require_once (COMMON_CLASS_DIR ."clscommon.php");
	require_once (COMMON_CLASS_DIR ."clseligibility_criteria.php");
	$cmn = new common();
	$objEC = new eligibility_criteria();
	
	require_once (COMMON_CLASS_DIR ."clsfield.php");
	$objField = new field();
	
	$objField->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
	$objField->client_id = $client_id;
	$condition = " AND field_mapping_id='1' ";
	$fieldList = $objField->fetchAllFieldFront($client_id, $condition);
	
	require_once (COMMON_CLASS_DIR ."clsfield_option.php");
	$objfield_option = new field_option();
	$objfield_option->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
	
	require_once (COMMON_CLASS_DIR ."clsfield_condition.php");
	$objfield_condition = new field_condition();
	
	require_once (COMMON_CLASS_DIR ."clsfield_attribute.php");
	$objfield_attribute = new field_attribute();
	
	require_once (COMMON_CLASS_DIR ."clsmessagelanguage.php");
	$msg = new messagelanguage();
	
	require_once (COMMON_CLASS_DIR ."clsencdec.php");
	$objEncDec = new encdec();

	
	$isShow = 0;
	$isComplete = 1;
	
	require_once (COMMON_CLASS_DIR ."clsentry.php");
	$objEntry = new entry();
	
	for($i=0;$i<count($fieldList);$i++)
	{
		$index = $index + 1;
		
		$field["field_id"] = $fieldList[$i]["field_id"];
		$field["form_id"] = $fieldList[$i]["form_id"];
		$field["field_type_id"] = $fieldList[$i]["field_type_id"];
		$field["field_name"] = $fieldList[$i]["field_name"];
		$field["field_caption"] = html_entity_decode($fieldList[$i]["field_caption"]);
		$field["is_required"] = $fieldList[$i]["is_required"];
		$field["field_ishide"] = $fieldList[$i]["field_ishide"];
		$field["field_iscondition"] = $fieldList[$i]["field_iscondition"];
		$field["field_order"] = $fieldList[$i]["field_order"];
		$field["field_mapping_id"] = $fieldList[$i]["field_mapping_id"];
		
		$form[$index] = $field;		
	}
	
	if(isset($_SESSION['err']))
	{
		echo str_replace("##imgpath##",BASE_DIR,$_SESSION['err']);
		$msg->clearMsg();
	}
	
	$isPreviewSite = 0;
	if(isset($_SESSION["isPreview"]) && $_SESSION["isPreview"]==1)
	{
		$isPreviewSite = 1;
	}
	
	if($isShow == 0)
	{		
?>
<input type="hidden" name="chksubmit" id="chksubmit" value="0" />

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblform">
<?php
$hiddenvar = "";
$hiddenvar1 = "";
$hiddenvar2 = "";
$k=-1;
	for($i=0; $i<count($form); $i++)
	{
		$k++;
		$index_select = -1;
		$index_checkbox = -1;
		$index_radio = -1;
		$index_option = 0;
		$field_options = array();		
	
		$form_id = $form[$i]["form_id"];
		$field_id = $form[$i]["field_id"];
				
		$field_type_id = $form[$i]["field_type_id"];
		$field_name = $form[$i]["field_name"];		
		$field_caption = html_entity_decode($form[$i]["field_caption"]);						
		$is_required = $form[$i]["is_required"];						
		$field_ishide = $form[$i]["field_ishide"];	
		$frm_hiddenfield_value = $form[$i]["field_mapping_id"];						

		$field_iscondition = $form[$i]["field_iscondition"];						

		$frm_field_name = "frmfld_".$form_id."_".$field_id;
		$frm_hiddenfield_name = "frmhdn_".$form_id."_".$field_id;
		$frm_showfield_name = "frmshw_".$field_id;
		$frm_already_name = "frmalready_".$form_id."_".$field_id;
		
		$attributeValues = '';
		$attrVal = '';
		
		$objField->field_type_id = $field_type_id;
		$totAttr = $objField->getField_Type_Attributes();
		
		for($m=0;$m<count($totAttr);$m++)
		{
			$conditionAtt = " AND field_id='".$field_id."' AND field_type_attribute_id='".$totAttr[$m]['field_type_attribute_id']."' AND field_type_id='".$field_type_id."'";
			$attrVal = $objfield_attribute->fieldvalue("attribute_value","",$conditionAtt);
			if($attrVal!="" || $attrVal!=" ")
			{
				$attributeValues.= $totAttr[$m]['field_type_attribute_name']."=".$attrVal." ";
			}
		}
		
?>
		<?php if ($frm_hiddenfield_value == 1) { ?>		
			<tr id="row_<?php print $field_id; ?>">
				<td align="left" valign="middle"><h2><?php print $field_caption; ?></h2></td>
			</tr>
		<?php } 
		
		$condSub = " AND field_mapping_id <> '1' AND field_header_field = '".$field_id."' ";
		$fieldListSub = $objField->fetchAllFieldFront($client_id, $condSub);
		
		$formsub = array();
		$insub = -1;
		
		for($is=0;$is<count($fieldListSub);$is++)
		{
		 
			$insub = $insub + 1;
			
			$field["field_id"] = $fieldListSub[$is]["field_id"];
			$field["form_id"] = $fieldListSub[$is]["form_id"];
			$field["field_type_id"] = $fieldListSub[$is]["field_type_id"];
			$field["field_name"] = $fieldListSub[$is]["field_name"];
			$field["field_caption"] = html_entity_decode($fieldListSub[$is]["field_caption"]);
			$field["is_required"] = $fieldListSub[$is]["is_required"];
			$field["field_ishide"] = $fieldListSub[$is]["field_ishide"];
			$field["field_iscondition"] = $fieldListSub[$is]["field_iscondition"];
			$field["field_order"] = $fieldListSub[$is]["field_order"];
			$field["field_mapping_id"] = $fieldListSub[$is]["field_mapping_id"];
			$field["pdf_field_name"] = $fieldListSub[$is]["pdf_field_name"];
			
			$formsub[$insub] = $field;		
			
			$arrOption_List = $objfield_option->fetchAllAsArrayFront(NULL, NULL, " and field_id = ".$fieldListSub[$is]["field_id"], "field_option_order");
					
			if(count($arrOption_List)>0)
			{		
				for($js=0;$js<count($arrOption_List);$js++)
				{
				
					$options["field_option_id"] = $arrOption_List[$js]['field_option_id'];
					$options["field_id"] = $arrOption_List[$js]['field_id'];
					$options["field_option"] = $arrOption_List[$js]['field_option'];
				
					$arrOption_Detail = $objfield_condition->fetchallasarray(NULL, NULL, " and field_option_id = ".$arrOption_List[$js]['field_option_id'], "field_condition_id");
					if(count($arrOption_Detail)>0)
					{
						$hide_field_idsv = "";
						$show_field_idsv = "";
						if($arrOption_Detail[0]['hide_field_ids']!="")
						{	$arrOption_Detail[0]['hide_field_ids'];
							$hide_field_idsv = substr($arrOption_Detail[0]['hide_field_ids'],1);
							$hide_field_idsv = str_replace(",","|",$hide_field_idsv);
						}
						
						if($arrOption_Detail[0]['show_field_ids']!="")
						{	$arrOption_Detail[0]['show_field_ids'];
							$show_field_idsv = substr($arrOption_Detail[0]['show_field_ids'],1);
							$show_field_idsv = str_replace(",","|",$show_field_idsv);
						}
						$options["show_field_ids"] = $show_field_idsv;
						$options["hide_field_ids"] = $hide_field_idsv; //"8|9";			
					}
					else
					{
						$options["show_field_ids"] = "";
						$options["hide_field_ids"] = ""; //"8|9";
					}
					
					$field_options[$index_option++] = $options;
				}
			}
		}
	
		if(count($formsub) > 0)		
		{ ?>
		<tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php		
	
		for($is=0; $is<count($formsub); $is++)
		{
	
			$form_id = $formsub[$is]["form_id"];
			$field_id = $formsub[$is]["field_id"];
					
			$field_type_id = $formsub[$is]["field_type_id"];
			$field_name = $formsub[$is]["field_name"];		
			$field_caption = html_entity_decode($formsub[$is]["field_caption"]);					
			$is_required = $formsub[$is]["is_required"];						
			$field_ishide = $formsub[$is]["field_ishide"];	
			$frm_hiddenfield_value = $formsub[$is]["field_mapping_id"];						

			$field_iscondition = $formsub[$is]["field_iscondition"];						
			
			$frm_field_name = "frmfld_".$form_id."_".$field_id;
			$frm_hiddenfield_name = "frmhdn_".$form_id."_".$field_id;
			$frm_showfield_name = "frmshw_".$field_id;
			$frm_already_name = "frmalready_".$form_id."_".$field_id;
			$pdf_field_name=$formsub[$is]['pdf_field_name'];
			$attributeValues = '';
			$attrVal = '';
			
			$objField->field_type_id = $field_type_id;
			$totAttr = $objField->getField_Type_Attributes();
			
			$_POST[$frm_field_name] = $cmn->readValue($_POST[$frm_field_name]);
			if(isset($_POST[$frm_field_name]) && $_POST[$frm_field_name] != "")
			{
			if($frm_hiddenfield_value == 10) { 				
				$id_field_name = "idfld_".$form_id."_".$field_id;
				$hiddenvar.= '<input type="hidden" name="'.$id_field_name.'" id="'.$id_field_name.'" value="'.$_POST[$id_field_name].'" />';	
				
				$hiddenvar2.= '<input type="hidden" name="'.$frm_field_name.'" id="'.$frm_field_name.'" value="'.$_POST[$frm_field_name]." ".$_POST[$id_field_name].'" />';		
			}
			else
			{	
				$hiddenvar2.= '<input type="hidden" name="'.$frm_field_name.'" id="'.$frm_field_name.'" value="'.$_POST[$frm_field_name].'" />';	
			}
			
			$hiddenvar.= '<input type="hidden" name="'.$frm_field_name.'" id="'.$frm_field_name.'" value="'.$_POST[$frm_field_name].'" />';	
			
			if(strlen($pdf_field_name) >1)
			{			
			if ($is>0) { 		
					$k++;
			}
			$hiddenvar1.= '<input type="hidden" name="ForPDF['.$k.'][field_id]" id="'.$field_id.'" value="'.$field_id.'" />';
			$hiddenvar1.= '<input type="hidden" name="ForPDF['.$k.'][field_mapping_id]" id="'.$field_id.'" value="'.$frm_hiddenfield_value.'" />';
$hiddenvar1.= '<input type="hidden" name="ForPDF['.$k.'][pdffieldname]" id="'.$field_id.'" value="'.$pdf_field_name.'" />';
$value[2]=0;
$val=$_POST[$frm_field_name];
$value=explode("_",$val);

$finalvalue=nl2br($cmn->readValue($_POST[$frm_field_name]));

if($frm_hiddenfield_value == 10) { 
	$id_field_name = "idfld_".$form_id."_".$field_id;
	$finalvalue=$finalvalue." ".$_POST[$id_field_name]; 
}

$hiddenvar1.= '<input type="hidden" name="ForPDF['.$k.'][value]" id="'.$field_id.'" value="'.$finalvalue.'" />';		
}
			?>	
			
		<tr class="white-bro" id="row_<?php print $field_id; ?>">
		  <td valign="middle" bgcolor="#EFEDED" align="left" width="20%"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?></td>
		  <td valign="middle" bgcolor="#EFEDED" align="left"><?php 
			if($frm_hiddenfield_value == 3) { 
				if(isset($_POST[$frm_field_name]))				
					echo "Yes";
			}
			else if($frm_hiddenfield_value == 2) { 
				$sValue = explode("|^|",$_POST[$frm_field_name]);
				
				$fieldval = array();
				foreach($sValue as $key_arr => $value_arr)
				{
					$value_arrv = explode("_",$value_arr);
					$objEntry->field_option_id = $value_arrv[0];
					$objEntry->field_id = $field_id;
					$objEntry->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
					$fieldval[] = $objEntry->fieldValueFront("field_option",$objEntry->field_option_id);					
				}
				echo implode(", ",$fieldval);
			}
			else if($frm_hiddenfield_value == 4) { 
				$sValue = explode("|^|",$_POST[$frm_field_name]);
				
				$fieldval = array();
				foreach($sValue as $key_arr => $value_arr)
				{
					$value_arrv = explode("_",$value_arr);
					$objEntry->field_option_id = $value_arrv[0];
					$objEntry->field_id = $field_id;
					$objEntry->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
					$fieldval[] = $objEntry->fieldValueFront("field_option",$objEntry->field_option_id);					
				}
				echo implode(", ",$fieldval);
			}
			else if($frm_hiddenfield_value == 7) { 
				$sValue = explode("|^|",$_POST[$frm_field_name]);
				
				$fieldval = array();
				foreach($sValue as $key_arr => $value_arr)
				{
					$value_arrv = explode("_",$value_arr);
					$fieldval[] = $objEC->fieldValue("eligibility_criteria", $value_arrv[0]);
				}	
				echo implode("<br> ",$fieldval);		
			}
			else if($frm_hiddenfield_value == 10) { 
				$id_field_name = "idfld_".$form_id."_".$field_id;
				$sValue = explode("_",$_POST[$frm_field_name]);
				if(isset($sValue[3]) && $sValue[3]!="")
				{	 echo nl2br($sValue[3])." ".str_repeat("*", strlen($_POST[$id_field_name])); 
				} else
				{	echo nl2br($cmn->readValueSubmission($_POST[$frm_field_name]))." ".str_repeat("*", strlen($_POST[$id_field_name])); 
				}
			}			
			else
			{				
				$sValue = explode("_",$_POST[$frm_field_name]);
			
				
				if(isset($sValue[3]) && $sValue[3]!="")
				{	 
					$sValue[3] = $cmn->readValue($sValue[3]);
					echo nl2br($sValue[3]); 
				} else
				{	
					echo nl2br($cmn->readValue($_POST[$frm_field_name]));
				}
			}	
		  ?></td>
		</tr>
		<?php
		}} ?>
		</table></td></tr>
		<?php } ?>		
<?php } ?>
	<tr class="white-bro">	  
	  <td align="center" valign="middle" bgcolor="#EFEDED">
	  <div class="step2edit">
	  <form id="frm" name="frm" method="post" action="registrationform1.php" style="padding:0; margin:0;">
	  <?php echo $hiddenvar; ?>	  
	  <input type="image" src="../images/<?php echo BTN_EDIT;?>" value="Edit" name="btnsubmitEdit" id="btnsubmitEdit" />	  
	  </form>
	  </div>
	  <div class="step2editdownload">&nbsp;</div>
	  <div class="step2download">
	  <form id="frm1" name="frm1" method="post" action="registrationform_download.php" style="padding:0; margin:0;">
	  <input type="hidden" value="<?php echo $client_id;?>" name="client_id" class="edit-button" >
	  <?php echo $hiddenvar2; ?>
	   <?php echo $hiddenvar1; ?>
	   <span class="step2downloadbtn">
	   <?php if ((isset($this->scope["mobile_device"]) ? $this->scope["mobile_device"] : null)) {
?>
	  <input type="image" src="../images/<?php echo BTN_SAVE_MY_FORM;?>" value="Submit" name="btnsubmit1" id="btnsubmit1" class="download-button" />
	  <?php 
}
else {
?>
	  <input type="image" src="../images/<?php echo BTN_DOWNLOAD_AND_PRINT_MY_FORM;?>" value="Submit" name="btnsubmit1" id="btnsubmit1" class="download-button" />
	  <?php 
}?>

	  </span>
	  </form>
	  </div>	  
	  </td>
	</tr>
  </table>    
<?PHP } ;
 /* end template body */
return $this->buffer . ob_get_clean();
?>