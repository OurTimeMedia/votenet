<?php
	set_time_limit(0);
	require_once (COMMON_CLASS_DIR ."clscommon.php");
	$cmn = new common();

	$language_id = $cmn->getSession(VOTER_LANGUAGE_ID);

	$domain = $_REQUEST['domain'];
	$stateid=$cmn->getSession('Home_State_ID');
	$languageid=$cmn->getSession('voter_language_id');

	require_once (COMMON_CLASS_DIR ."clsregistration_deadline.php");
	$condition=" and state_id=".$stateid;
	$objregistration_deadline= new registration_deadline();
	$registration_deadline=$objregistration_deadline->fetchAllAsArray($stateid,$condition);
	require_once (COMMON_CLASS_DIR ."clseligibility_state.php");

	$objeligibility_state= new eligibility_state();
	$eligibility_criteria=$objeligibility_state->fetchstatewiseAsArray($stateid,$languageid);

	$objWebsite = new website();
	$condition = " AND domain='".$domain."' ";
	$client_id = $objWebsite->fieldValue("client_id","",$condition);

	require_once (COMMON_CLASS_DIR ."clselection_date.php");
	$objElectionDate = new election_date();

	$objState=new state();

	$condFirstElection = " AND election_date >= '".currentScriptDateOnly()."' AND state_id = '".$stateid."' ";
	$firstElectionDate = $objElectionDate->getFirstElectionDate($condFirstElection);

	require_once (COMMON_CLASS_DIR ."clsform.php");
	$objForm = new form();
	$conditionForm = " AND client_id = '".$client_id."' ";
	$objForm->setallvalues("", $conditionForm);

	if($objForm->form_background == "" )
	{
		$objForm = new form();
		$conditionForm = " AND client_id = '0' ";
		$objForm->setallvalues("", $conditionForm);
	}

	$formcss = "";
	if($objForm->form_background != "" )
	{
		$formcss.= "#tblform h2 { background:"."#".str_replace("#","",$objForm->form_background).";}\n";
	}
	if($objForm->form_header_text != "" )
	{
		$formcss.= "#tblform h2 { color:"."#".str_replace("#","",$objForm->form_header_text).";}\n";
	}
	if($objForm->form_normal_text_bg != "" )
	{
		$formcss.= "#tblform td { background:"."#".str_replace("#","",$objForm->form_normal_text_bg).";}\n#tblform td  .normal_text{ background:"."#".str_replace("#","",$objForm->form_normal_text_bg)."; font: 13px helvetica,arial,sans;}\n";
	}
	if($objForm->form_normal_text != "" )
	{
		$formcss.= "#tblform td { color:"."#".str_replace("#","",$objForm->form_normal_text).";}\n#tblform td  .normal_text{ color:"."#".str_replace("#","",$objForm->form_normal_text)."; font: 13px helvetica,arial,sans;}\n";
	}

	$form = array();

	$field = array();

	$field_options = array();

	$options = array();

	$arr_select  = array();
	$arr_checkbox = array();
	$arr_radio = array();
	$extra_js_rules = "";
	$extra_js_phone = "";
	$extra_js_messages = "";
	$extra_js_idnumber = "";
	$minimum_age_require = 18;

	$objState->setAllValues($cmn->getSession('Home_State_ID'));

	$minimum_age_note = "";
	if(isset($objState->state_minimum_age_text) && $objState->state_minimum_age_text != "")
		$minimum_age_note = $objState->state_minimum_age_text;

	$stateLangInfoArr = $objState->fetchStateLanguageDetail($cmn->getSession('Home_State_ID'));

	if(isset($stateLangInfoArr[$language_id]['state_minimum_age_text']) && $stateLangInfoArr[$language_id]['state_minimum_age_text'] != "")
		$minimum_age_note = $stateLangInfoArr[$language_id]['state_minimum_age_text'];

	$electionCriteriaDateArr = array();
	$electionCriteriaDateArr[] = date("Y-m-d");

	if($objState->state_minimum_age_criteria != "")
	{
		$firstElectionDateArr =  explode("-",$firstElectionDate);
		$minimumAgeCriteriaArr = explode(",", $objState->state_minimum_age_criteria);

		if(in_array(1, $minimumAgeCriteriaArr))
		{
			$electionCriteriaDateArr[] = date("Y-m-d", mktime(0,0,0, $firstElectionDateArr[1], $firstElectionDateArr[2], $firstElectionDateArr[0] - $minimum_age_require));
		}

		if(in_array(2, $minimumAgeCriteriaArr))
		{
			$electionCriteriaDateArr[] = date("Y-m-d", mktime(0,0,0, date("m"), date("d"), date("Y") - 17));
		}

		if(in_array(3, $minimumAgeCriteriaArr))
		{
			$electionCriteriaDateArr[] = date("Y-m-d", mktime(0,0,0, date("m")-6, date("d"), date("Y") - 17));
		}

		if(in_array(4, $minimumAgeCriteriaArr))
		{
			$electionCriteriaDateArr[] = date("Y-m-d", mktime(0,0,0, date("m"), date("d"), date("Y") - 16));
		}

		if(in_array(5, $minimumAgeCriteriaArr))
		{
			if($objState->state_minimum_age_criteria_election_type != "")
			{
				$condNextElection = " AND election_date >= '".currentScriptDateOnly()."' AND state_id = '".$stateid."' AND election_type_id in (".$objState->state_minimum_age_criteria_election_type.") ";
				$nextElectionDate = $objElectionDate->getFirstElectionDate($condNextElection);

				$nextElectionDateArr =  explode("-",$nextElectionDate);

				$electionCriteriaDateArr[] = date("Y-m-d", mktime(0,0,0, $nextElectionDateArr[1], $nextElectionDateArr[2], $nextElectionDateArr[0] - $minimum_age_require));
			}
		}

		if(in_array(6, $minimumAgeCriteriaArr))
		{
			$electionCriteriaDateArr[] = date("Y-m-d", mktime(0,0,0, date("m")-10, date("d"), date("Y") - 17));
		}

		if(in_array(7, $minimumAgeCriteriaArr))
		{
			$electionCriteriaDateArr[] = date("Y-m-d", mktime(0,0,0, 12, 31, date("Y") - 18));
		}

		if(in_array(8, $minimumAgeCriteriaArr))
		{
			$electionCriteriaDateArr[] = date("Y-m-d", mktime(0,0,0, date("m"), date("d") + 90, date("Y") - 18));
		}
	}

	$electionCriteriaDate = min($electionCriteriaDateArr);

	$index = -1;

	require_once (COMMON_CLASS_DIR ."clscommon.php");
	$cmn = new common();

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

	$id_field_name_source = "";
	$id_field_name = "";
	$eligibility_field_count = 0;
	$eligibility_field_name = "";

	if($isShow == 0)
	{
		require_once (COMMON_CLASS_DIR ."clsstate.php");
		$objState1=new state();
		$objState1->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
		$condState= " and state_active = 1 ";
		$statedata=$objState1->fetchAllAsArrayFront('',$condState,'state_name');

		require_once (COMMON_CLASS_DIR ."clsracegroup_state.php");
		$objRaceGroup=new racegroup_state();
		$objRaceGroup->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
		$condRaceGroup= " and race_group_active = 1 AND s.state_id = '".$cmn->getSession('Home_State_ID')."'";
		$raceGroupData=$objRaceGroup->fetchAllAsArrayFront($condRaceGroup);

		require_once (COMMON_CLASS_DIR ."clsidnumber_state.php");
		$objIdNumber=new idnumber_state();
		$objIdNumber->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
		$condIdNumber= " and id_number_active = 1 AND s.state_id = '".$cmn->getSession('Home_State_ID')."'";
		$IdNumberData=$objIdNumber->fetchAllAsArrayFront($condIdNumber);

		require_once (COMMON_CLASS_DIR ."clsparty_state.php");
		$objParty=new party_state();
		$objParty->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
		$condParty= " and party_active = 1 AND s.state_id = '".$cmn->getSession('Home_State_ID')."'";
		$partyData=$objParty->fetchAllAsArrayFront($condParty);
?>
<form id="frm" name="frm" method="post" action="">
<input type="hidden" name="chksubmit" id="chksubmit" value="0" />
<div id="containererreurtotal" style="display:none; text-align:center; color: red; font-size:13px; font-weight:bold; padding-bottom:10px;"><?php echo LANG_ERROR_IN_REGISTRATION_FORM_REVIEW_AND_FIX;?></div>
<div class="register1left">
<?php
if($formcss != "")
{
	echo '<style type="text/css">'."\n";
	echo $formcss."\n";;
	echo '</style>';
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tblform">
<?php
	for($i=0; $i<count($form); $i++)
	{
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
		<?php if ($field_ishide == 1)
			{ ?>
		<script type="text/javascript" language="Javascript">
		<!--
			hidedefaultrow('row_<?php print $field_id; ?>', 0);
		-->
		</script>
		<?php }}

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
			$field["field_note"] = $fieldListSub[$is]["field_note"];

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

			$field_note = $formsub[$is]["field_note"];

			if($field_note != "")
			{
				$field_note = " <br><span style='font-size:10px;'>(<span style='font-weight:bold;'>".LANG_NOTE.": </span>".$field_note.")</span>";
			}

			$frm_field_name = "frmfld_".$form_id."_".$field_id;
			$id_field_name = "idfld_".$form_id."_".$field_id;

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
			} ?>

		<input type="hidden" name="<?PHP print $frm_hiddenfield_name; ?>" id="<?PHP print $frm_hiddenfield_name; ?>" value="<?PHP  print $frm_hiddenfield_value; ?>" />
		<input type="hidden" name="<?PHP print $frm_showfield_name; ?>" id="<?PHP print $frm_showfield_name; ?>" value="<?PHP if(isset($_POST[$frm_showfield_name])){ print $_POST[$frm_showfield_name]; } else { if($field_ishide==1) { print "no"; } else { print "yes"; } } ?>" />

		<?php
		//////////radio btn//////
		if($frm_hiddenfield_value == 2) {
				//$showhide = "0_0_0";
				$index_radio = $index_radio + 1;
				$arr_radio[$index_radio] = $frm_field_name;
		?>
					<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <?php for($j=0; $j<count($field_options); $j++)
						{
							if ($field_id != $field_options[$j]["field_id"])
								continue;

							$field_option_id = $field_options[$j]["field_option_id"];
							$field_option = $field_options[$j]["field_option"];

							$show_field_ids = $field_options[$j]["show_field_ids"];
							$hide_field_ids = $field_options[$j]["hide_field_ids"];

							$checked = "";
							if (isset($_POST[$frm_field_name]))
							{
								$postvalarr = explode("|^|", $_POST[$frm_field_name]);
								if (in_array($field_option_id."_".$show_field_ids."_".$hide_field_ids, $postvalarr))
								{
									$checked = "checked='checked'";
									$jScript.= "change_radio('".$frm_field_name."');\n";
								}
							} ?>
					  <label class="normal_text" id="lbl_<?php print $field_option_id; ?>" for="<?php print $field_option_id; ?>" ><input type="radio" id="<?php print $field_option_id; ?>" name="<?php print $frm_field_name; ?>[]" class="<?php if($is_required == "1") print "required"; ?>" alt="<?PHP echo $field_caption; ?>" value="<?php print $field_option_id."_".$show_field_ids."_".$hide_field_ids; ?>" <?php print $checked; ?> onClick="change_radio(this.name);" <?PHP echo $attributeValues; ?> />&nbsp;<?php print $field_option; ?></label>&nbsp;&nbsp;
					  <?php } ?>
					  <?php echo $field_note;?>
					  </td>
                    </tr>
		<?php
			}
			///checkbox
			else if($frm_hiddenfield_value == 3) {
				$checked = "";

				for($j=0; $j<count($field_options); $j++)
				{
					if ($field_id != $field_options[$j]["field_id"])
						continue;

					$field_option_id = $field_options[$j]["field_option_id"];
					$field_option = $field_options[$j]["field_option"];

					$show_field_ids = $field_options[$j]["show_field_ids"];
					$hide_field_ids = $field_options[$j]["hide_field_ids"];

					$checked = "";
					if (isset($_POST[$frm_field_name]))
					{
						$checked = "checked='checked'";
						$jScript.= "change_checkbox('".$frm_field_name."');\n";
					}
			?>
					<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" colspan='2'>
					  <label class="normal_text" id="lbl_<?php print $field_id; ?>" for="<?php print $field_option_id; ?>" ><input type="checkbox" id="<?php print $field_option_id; ?>" name="<?php print $frm_field_name; ?>" class="<?php if($is_required == "1") print "required"; ?>" alt="<?PHP echo $field_caption; ?>" <?PHP echo $attributeValues; ?> value="<?php print $field_option_id."_".$show_field_ids."_".$hide_field_ids; ?>" <?php print $checked; ?> onClick="change_checkbox(this.name);" />&nbsp;<?php print $field_caption; ?></label><?php echo $field_note;?>
					  </td>
                    </tr>
			<?
				 }} else if($frm_hiddenfield_value == 4) {
			?>
					<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <?php for($j=0; $j<count($field_options); $j++)
					{
						if ($field_id != $field_options[$j]["field_id"])
							continue;

						$field_option_id = $field_options[$j]["field_option_id"];
						$field_option = $field_options[$j]["field_option"];

						$show_field_ids = $field_options[$j]["show_field_ids"];
						$hide_field_ids = $field_options[$j]["hide_field_ids"];

						$checked = "";
						if (isset($_POST[$frm_field_name]))
						{
							$postvalarr = explode("|^|", $_POST[$frm_field_name]);
							if (in_array($field_option_id."_".$show_field_ids."_".$hide_field_ids, $postvalarr))
							{
								$checked = "checked='checked'";
								$jScript.= "change_checkbox('".$frm_field_name."');\n";
							}
						} ?>
					  <label class="normal_text" id="lbl_<?php print $field_id; ?>" for="<?php print $field_option_id; ?>" ><input type="checkbox" id="<?php print $field_option_id; ?>" name="<?php print $frm_field_name; ?>[]" class="<?php if($is_required == "1") print "required"; ?>" alt="<?PHP echo $field_caption; ?>" <?PHP echo $attributeValues; ?> value="<?php print $field_option_id."_".$show_field_ids."_".$hide_field_ids; ?>" <?php print $checked; ?> onClick="change_checkbox(this.name);" />&nbsp;<?php print $field_option; ?>&nbsp;&nbsp;</label>
					  <?php } ?>
					  <?php echo $field_note;?></td>
                    </tr>
			<?php } /* GENERAL INPUT FIELD */ elseif ($frm_hiddenfield_value == 5) { ?>


                    <?php
                    // DETECT FIELD VALUE
                    $fieldValue = '';
                    if (isset($_POST[$frm_field_name])) {
                        $fieldValue = $cmn->readValue($_POST[$frm_field_name]);
                    } else {
                        switch ($frm_field_name) {
                            case 'frmfld_1_8': $fieldValue = $cmn->getSession('voter_lastname'); break;
                            case 'frmfld_1_6': $fieldValue = $cmn->getSession('voter_firstname'); break;
                        }
                    }
                    ?>

					<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <input type="text" id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" value="<?= $fieldValue ?>" class="<?php if($is_required == "1") print "input required"; else print "input"; ?>" alt="<?PHP echo $field_caption; ?>" <?PHP echo $attributeValues; ?> /><?php echo $field_note;?></td>
                    </tr>

				<?php }
					//dropdown
					else if($frm_hiddenfield_value == 6) { ?>
						<tr class="white-bro" id="row_<?php print $field_id; ?>">
						  <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
						  <br />
						  <select id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" <?PHP echo $attributeValues; ?>  onchange="change_select(this.name);" class="<?php if($is_required == "1") print "select required"; else print "select"; ?>" alt="<?PHP echo $field_caption; ?>">
					<option value=""><?php echo LANG_SELECT;?></option>
				<?php
				// $showhide = "0_0_0";
				$index_select = $index_select + 1;
				$arr_select[$index_select] = $frm_field_name;

				for($j=0; $j<count($field_options); $j++)
				{
					if ($field_id != $field_options[$j]["field_id"])
						continue;

					$field_option_id = $field_options[$j]["field_option_id"];
					$field_option = $field_options[$j]["field_option"];

					$show_field_ids = $field_options[$j]["show_field_ids"];
					$hide_field_ids = $field_options[$j]["hide_field_ids"];

					$selected = "";
					if (isset($_POST[$frm_field_name]))
					{
						if ($field_option_id."_".$show_field_ids."_".$hide_field_ids."_".$field_option == trim($_POST[$frm_field_name]))
						{
							$selected = "selected='selected'";
							$jScript.= "change_select('".$frm_field_name."');\n";
						}
					}
		?>
					<option  value="<?php print $field_option_id."_".$show_field_ids."_".$hide_field_ids."_".$field_option; ?>" <?php print $selected; ?>><?php print $field_option; ?></option>
		<?php
				}// END OF FOR LOOP OPTIONS
		?>
			</select><?php echo $field_note;?></td>
                    </tr>
		<?php

		} else if($frm_hiddenfield_value == 7) { /* ?>
		<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
			
		<?php
//				$showhide = "0_0_0";

			$index_select = $index_select + 1;
			$arr_select[$index_select] = $frm_field_name;	
			$checked = "";
			for($j=0; $j<count($eligibility_criteria); $j++)
			{		
		?>
		
		
<!--<label for="<?php print $eligibility_criteria[$j]['eligibility_criteria']; ?>" ><input type="checkbox" value="Yes" <?php print $checked; ?> name="<?php print $eligibility_criteria[$j]['eligibility_criteria_id']; ?>"><?php print $eligibility_criteria[$j]['eligibility_criteria']; ?></label><br>-->

					  <?php 
						
							
						$field_option_id = $eligibility_criteria[$j]["eligibility_criteria_id"];
						$field_option = $eligibility_criteria[$j]["eligibility_criteria"];
						
						$show_field_ids = "";
						$hide_field_ids = "";	
						
						$checked = "";
						if (isset($_POST[$frm_field_name]))
						{	
							$postvalarr = explode("|^|", $_POST[$frm_field_name]);
							if (in_array($field_option_id."_".$show_field_ids."_".$hide_field_ids, $postvalarr))
							{	
								$checked = "checked='checked'";
								$jScript.= "change_checkbox('".$frm_field_name."');\n";
							}
						} ?>
					  	 
						<table>
						<tr>
						<td style="vertical-align:top;">
						<input type="checkbox" id="<?php print $frm_field_name; ?>_<?php print $field_option_id; ?>" name="<?php print $frm_field_name; ?>" class="" alt="<?PHP echo $field_caption; ?>" <?PHP echo $attributeValues; ?> value="<?php print $field_option_id."_".$show_field_ids."_".$hide_field_ids; ?>" <?php print $checked; ?> />
						</td>
						<td>
						<label class="normal_text" id="lbl_<?php print $field_id; ?>" for="<?php print $field_option_id; ?>" ><?php print $field_option; ?><br></label>
						</td>
						</tr>
						</table>
						
		<?php			
				}// END OF FOR LOOP OPTIONS
				
				$eligibility_field_count = 0;
				if(count($eligibility_criteria) > 0)
				{ 
				$eligibility_field_name = $frm_field_name;
				$eligibility_field_count = count($eligibility_criteria);
				?>
				<label for="<?php print $frm_field_name; ?>" class="error" style="display:none;">You must select all the eligibility criteria.</label>
				<?php }
		?>			
			</td>
                    </tr>
		<?php */ } else if($frm_hiddenfield_value == 8 && count($partyData) > 0) { ?>
		<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <select id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" <?PHP echo $attributeValues; ?> class="<?php if($is_required == "1") print "select required"; else print "select"; ?>" alt="<?PHP echo $field_caption; ?>">
			<option value=""><?php echo LANG_SELECT;?></option>
			<?php
			$partyOption='';
			for($k=0;$k<count($partyData);$k++)
			{
				if (isset($_POST[$frm_field_name]))
				{
					if ($partyData[$k]['party_name'] == trim($_POST[$frm_field_name]))
						$partyOption .= "<option value='".$cmn->setValInput($partyData[$k]['party_name'])."' selected>".$partyData[$k]['party_name']."</option>";
					else
						$partyOption .= "<option value='".$cmn->setValInput($partyData[$k]['party_name'])."'>".$partyData[$k]['party_name']."</option>";
				}
				else
					$partyOption .= "<option value='".$cmn->setValInput($partyData[$k]['party_name'])."'>".$partyData[$k]['party_name']."</option>";
			}

			echo $partyOption; ?>
			</select></td>
                    </tr>
		<?php } else if($frm_hiddenfield_value == 9 && count($raceGroupData) > 0) { ?>
		<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <select id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" <?PHP echo $attributeValues; ?> class="<?php if($is_required == "1") print "select required"; else print "select"; ?>" alt="<?PHP echo $field_caption; ?>">
			<option value=""><?php echo LANG_SELECT;?></option>
			<?php
			$raceGroupOption='';
			for($k=0;$k<count($raceGroupData);$k++)
			{
				if (isset($_POST[$frm_field_name]))
				{
					if ($raceGroupData[$k]['race_group_name'] == trim($_POST[$frm_field_name]))
						$raceGroupOption .= "<option value='".$cmn->setValInput($raceGroupData[$k]['race_group_name'])."' selected>".$raceGroupData[$k]['race_group_name']."</option>";
					else
						$raceGroupOption .= "<option value='".$cmn->setValInput($raceGroupData[$k]['race_group_name'])."'>".$raceGroupData[$k]['race_group_name']."</option>";
				}
				else
					$raceGroupOption .= "<option value='".$cmn->setValInput($raceGroupData[$k]['race_group_name'])."'>".$raceGroupData[$k]['race_group_name']."</option>";
			}
			echo $raceGroupOption; ?>
			</select></td>
                    </tr>
		<?php } else if($frm_hiddenfield_value == 10) { ?>
		<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <select id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" <?PHP echo $attributeValues; ?>  class="<?php if($is_required == "1") print "select required"; else print "select"; ?>" alt="<?PHP echo $field_caption; ?>" onchange="displayIDfield('<?php print $frm_field_name; ?>', '<?php print "span_".$id_field_name; ?>');">
			<option value=""><?php echo LANG_SELECT;?></option>
			<?php
			$IdNumberOption='';
			for($k=0;$k<count($IdNumberData);$k++)
			{
				if (isset($_POST[$frm_field_name]))
				{
					if ($IdNumberData[$k]['id_number_name'] == trim($_POST[$frm_field_name]))
						$IdNumberOption .= "<option value='".$cmn->setValInput($IdNumberData[$k]['id_number_name'])."' selected>".$IdNumberData[$k]['id_number_name']."</option>";
					else
						$IdNumberOption .= "<option value='".$cmn->setValInput($IdNumberData[$k]['id_number_name'])."'>".$IdNumberData[$k]['id_number_name']."</option>";
				}
				else
					$IdNumberOption .= "<option value='".$cmn->setValInput($IdNumberData[$k]['id_number_name'])."'>".$IdNumberData[$k]['id_number_name']."</option>";

				if ($IdNumberData[$k]['id_number_length'] != "")
				{
					if ($IdNumberData[$k]['id_number_length'] == 0)
						$extra_js_idnumber.= "idnumberlength['".($k+1)."'] = '';";
					else
						$extra_js_idnumber.= "idnumberlength['".($k+1)."'] = '".$IdNumberData[$k]['id_number_length']."';";
				}
				else
					$extra_js_idnumber.= "idnumberlength['".($k+1)."'] = ''; ";

				$extra_js_idnumber.= "idnumbernote['".($k+1)."'] = '".$IdNumberData[$k]['id_number_id']."';";
			}

			$extra_js_rules.= $id_field_name.': {
									  required: true,
									  minlength: function(element) {
											var maxlenfld = document.getElementById(\''.$id_field_name.'\').maxLength;
											if(maxlenfld != 100)
												return maxlenfld;
											else 
												return 1;
									  },	
									},';

			$extra_js_messages.= $id_field_name.': "'.LANG_ENTER_VALID_ID_NUMBER.'",';

			$idnumber_field_note = "";

			$idnumber_field_note = "";
			$objIdNumber->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
			$objIdNumber->state_id = $cmn->getSession('Home_State_ID');
			$id_number_note=$objIdNumber->fetchIdNumberNotes($condIdNumber);

			if($id_number_note != "")
				$idnumber_field_note = " <br><span style='font-size:10px;'>(<span style='font-weight:bold;'>".LANG_NOTE.": </span>".$id_number_note.")</span>";

			$fixed_idnumaber_note = " <span style='font-size:10px; display:none;' id='fixedIdNote'><br>(<span style='font-weight:bold;'>".LANG_NOTE_SOCIAL_SECURITY.")</span>";
			echo $IdNumberOption; ?>
			</select> <span id="span_<?php print $id_field_name; ?>" <?php if(!isset($_POST[$id_field_name])) { ?> style="display:none;" <?php } ?>><input type="password" class="input required" name="<?php print $id_field_name; ?>" id="<?php print $id_field_name; ?>" value="<?php (isset($_POST[$id_field_name])) ? print $cmn->readValue($_POST[$id_field_name]) : print ""; ?>" style="width:160px;" ></span><?php echo $idnumber_field_note.$fixed_idnumaber_note;?></td>
                    </tr>

		<?php } /* DATE OF BIRTH FIELD */ elseif($frm_hiddenfield_value == 11) { ?>

            <?php
            // DETECT FIELD VALUE
            $fieldValue = 'MM/DD/YYYY';
            if (isset($_POST[$frm_field_name])) {
                $fieldValue = $cmn->readValue($_POST[$frm_field_name]);
            } else {
                $fieldValue = $cmn->getSession('voter_dateofbirth');
            }
            ?>

				<tr class="white-bro" id="row_<?php print $field_id; ?>">
				  <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
				  <br />
				  <input type="text" AUTOCOMPLETE="OFF" id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" value="<?= $fieldValue ?>" class="<?php if($is_required == "1") print "input required"; else print "input"; ?>" alt="<?PHP echo $field_caption; ?>" <?PHP echo $attributeValues; ?> onBlur="javascript:hideDefaultDate();" onFocus="javascript:showDefaultDate();" style="width: 100px;" /><?php echo $field_note;?>
				  <?php
				  $nextelectiondate = date("F d, Y", mktime(0,0,0, $firstElectionDateArr[1], $firstElectionDateArr[2], $firstElectionDateArr[0]));

				  $minimum_age_note = str_replace("##election_date##",$nextelectiondate,$minimum_age_note);

				  echo "<br><span style='font-size:10px;'>(<span style='font-weight:bold;'>".LANG_NOTE.": </span>".$minimum_age_note.")</span>";
				 ?>
				  </td>
                </tr>
				<script type="text/javascript">
				<!--
				<?php
				$electionCriteriaDateArr =  explode("-",$electionCriteriaDate);
				$startY = $electionCriteriaDateArr[0];
				$startM = $electionCriteriaDateArr[1];
				$startD = $electionCriteriaDateArr[2];

				if($is_required == "1")
					$extra_js_rules.= $frm_field_name.': {
									  required: true,
									  DateFormat: true,
									  maxAllowDate: true,
									},';
				else
					$extra_js_rules.= $frm_field_name.': {
									  required: function(element) {
											if(jQuery("#'.$frm_field_name.'").val() != "")
											{
												return true;
											}
											else {
												return false;
											}
									  },
									  DateFormat: true,
									  maxAllowDate: true,
									},';
				?>
				function hideDefaultDate()
				{
					if(document.getElementById('<?php print $frm_field_name; ?>').value == "")
					{
						document.getElementById('<?php print $frm_field_name; ?>').value = "MM/DD/YYYY";
					}
				}

				function showDefaultDate()
				{
					if(document.getElementById('<?php print $frm_field_name; ?>').value == "MM/DD/YYYY")
					{
						document.getElementById('<?php print $frm_field_name; ?>').value = "";
					}
				}

				var maxallowdate = new Date(<?php echo $startY;?>, <?php echo $startM;?>, <?php echo $startD;?>);
				-->
				</script>
		<?php } else if($frm_hiddenfield_value == 12) { ?>
					<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <textarea id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" class="<?php if($is_required == "1") print "input1  required"; else print "input1"; ?>" alt="<?PHP echo $field_caption; ?>" <?PHP echo $attributeValues; ?>  ><?php (isset($_POST[$frm_field_name])) ? print $_POST[$frm_field_name] : print ""; ?></textarea></td>
                    </tr>
		<?php } else if($frm_hiddenfield_value == 13) { ?>
		<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
			<?php if($cmn->getSession('Home_State_ID') != "") { echo "<label class='normal_text'>".$cmn->getSession('Home_State')."</label>"; ?>
			<input type="hidden" id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" value="<?php echo $cmn->getSession('Home_State'); ?>" />
			<?php } else { ?>
			<select id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" <?PHP echo $attributeValues; ?>  class="<?php if($is_required == "1") print "select required"; else print "select"; ?>" alt="<?PHP echo $field_caption; ?>">
			<option value=""><?php echo LANG_SELECT;?></option>
			<?php
			$stateoption='';
			for($k=0;$k<count($statedata);$k++)
			{
				if (isset($_POST[$frm_field_name]))
				{
					if (strtolower($statedata[$k]['state_name']) == strtolower(trim($_POST[$frm_field_name])))
						$stateoption .= "<option value='".$statedata[$k]['state_name']."' selected>".$statedata[$k]['state_name']."</option>";
					else
						$stateoption .= "<option value='".$statedata[$k]['state_name']."'>".$statedata[$k]['state_name']."</option>";
				}
				else
					$stateoption .= "<option value='".$statedata[$k]['state_name']."'>".$statedata[$k]['state_name']."</option>";
			}
			echo $stateoption;?>
			</select>
			<?php } ?>
					</td>
                    </tr>
		<?php } else if($frm_hiddenfield_value == 14) {
				if($is_required == "1")
					$extra_js_rules.= $frm_field_name.': {
									  required: true,
									  minlength: 5,	
									},';
				else
					$extra_js_rules.= $frm_field_name.': {
									  required: function(element) {
											if(jQuery("#'.$frm_field_name.'").val() != "")
											{	
												return true;
											}
											else {
												return false;
											}
									  },
									  minlength: 5,	
									},';

				$extra_js_messages.= $frm_field_name.': "'.LANG_ENTER_5DIGIT_ZIPCODE.'",';
		?>
					<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <?php if($cmn->getSession('Home_ZipCode') != "") { ?>
					  <input type="text" id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" value="<?php echo $cmn->getSession('Home_ZipCode'); ?>" class="input" alt="<?PHP echo $field_caption; ?>" readonly  maxlength="5" style="width:85px"  />
					  <?php } else { ?>
					  <input type="text" id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" value="<?php (isset($_POST[$frm_field_name])) ? print $cmn->readValue($_POST[$frm_field_name]) : print ""; ?>" class="<?php if($is_required == "1") print "input required"; else print "input"; ?>" alt="<?PHP echo $field_caption; ?>" <?PHP echo $attributeValues; ?> maxlength="5" style="width:85px" />
					  <?php } ?>
					  </td>
                    </tr>
		<?php } else if($frm_hiddenfield_value == 15) { ?>
		<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <select id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" <?PHP echo $attributeValues; ?> class="<?php if($is_required == "1") print "select required"; else print "select"; ?>" alt="<?PHP echo $field_caption; ?>">
			<option value=""><?php echo LANG_SELECT;?></option>
			<?php
			$stateoption='';
			for($k=0;$k<count($statedata);$k++)
			{
				if (isset($_POST[$frm_field_name]))
				{
					if (strtolower($statedata[$k]['state_name']) == strtolower(trim($_POST[$frm_field_name])))
						$stateoption .= "<option value='".$statedata[$k]['state_name']."' selected>".$statedata[$k]['state_name']."</option>";
					else
						$stateoption .= "<option value='".$statedata[$k]['state_name']."'>".$statedata[$k]['state_name']."</option>";
				}
				else
					$stateoption .= "<option value='".$statedata[$k]['state_name']."'>".$statedata[$k]['state_name']."</option>";
			}
			echo $stateoption;?>
			</select></td>
                    </tr>
		<?php } else if($frm_hiddenfield_value == 16) {
				if($is_required == "1")
					$extra_js_rules.= $frm_field_name.': {
									  required: true,
									  minlength: 5,	
									},';
				else
					$extra_js_rules.= $frm_field_name.': {
									  required: function(element) {
											if(jQuery("#'.$frm_field_name.'").val() != "")
											{	
												return true;
											}
											else {
												return false;
											}
									  },
									  minlength: 5,	
									},';

				$extra_js_messages.= $frm_field_name.': "'.LANG_ENTER_5DIGIT_ZIPCODE.'",';
		?>
					<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
						<br />
					  <input type="text" id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" value="<?php (isset($_POST[$frm_field_name])) ? print $cmn->readValue($_POST[$frm_field_name]) : print ""; ?>" class="<?php if($is_required == "1") print "input required"; else print "input"; ?>" alt="<?PHP echo $field_caption; ?>" <?PHP echo $attributeValues; ?> maxlength="5" style="width:85px"  />
					  </td>
                    </tr>

		<?php } /* PHONE FIELD */ elseif( $frm_hiddenfield_value == 17) { ?>

            <?php
                // DETECT FIELD VALUE
                $fieldValue = '';
                if (isset($_POST[$frm_field_name])) {
                    $fieldValue = $cmn->readValue($_POST[$frm_field_name]);
                } else {
                    $fieldValue = $cmn->getSession('voter_phone');
                }
            ?>
					<tr class="white-bro" id="row_<?php print $field_id; ?>">
                      <td valign="top" align="left" width="100%" colspan="2"><label id="lbl_<?php print $field_id; ?>" for="<?php print $frm_field_name; ?>"><?php print $field_caption; ?></label><?php if($is_required == "1") { ?><span class="red">*</span> <? } ?>
					  <br />
					  <input type="text" autocomplete="off" id="<?php print $frm_field_name; ?>" name="<?php print $frm_field_name; ?>" value="<?= $fieldValue ?>" class="<?php if($is_required == "1") print "input required"; else print "input"; ?>" alt="<?PHP echo $field_caption; ?>" <?PHP echo $attributeValues; ?>  onblur="formatPhone(this)" style="width:200px" maxlength="13" /> <br><span style="font-size:10px;">(<?php echo LANG_EG;?> XXX-XXX-XXXX)</span><?php echo $field_note;?></td>
                    </tr>
				<?php
					if($is_required == "1")
					$extra_js_rules.= $frm_field_name.': {
									  required: true,
									  phoneUS: 5,	
									},';
				else
					$extra_js_rules.= $frm_field_name.': {
									  required: function(element) {
											if(jQuery("#'.$frm_field_name.'").val() != "")
											{	
												return true;
											}
											else {
												return false;
											}
									  },
									  phoneUS: 5,	
									},';

				$extra_js_messages.= $frm_field_name.': "'.LANG_ERROR_ENTER_VALID_PHONE_NO.'",';
				}
		if ($field_ishide == 1) { ?>
		<script type="text/javascript" language="Javascript">
		<!--
			hidedefaultrow('row_<?php print $field_id; ?>', 0);
		-->
		</script>
		<?php }} ?>

		</table></td></tr>
		<?php } ?>
<?php } ?>



<?php /******************************************************************************/ ?>
<?php /*********************** SEND EMAIL *******************************************/ ?>
<?php /******************************************************************************/ ?>

<?php
// DETECT FIELD VALUE
$fieldValue = '';
$frm_field_name = 'user_email';
if (isset($_POST[$frm_field_name])) {
    $fieldValue = $cmn->readValue($_POST[$frm_field_name]);
} else {
    $fieldValue = $cmn->getSession('voter_email');
}
$isSendEmail = false;
if ($_POST['is_send_email']) {
    $isSendEmail = true;
}
?>


<tr>
    <td class="white-bro" id="row_is_send_email" style="height: 30px;">
        <label for="is_send_email" class="normal_text"><input id="is_send_email" type="checkbox" value="1" name="is_send_email" <?php if ($isSendEmail) : ?>checked="checked"<?php endif; ?>>&nbsp;Send application by email.</label>
    </td>
</tr>
<tr id="email_container" class="white-bro">
    <td width="100%" valign="top" align="left" colspan="2">
        <label for="user_email" id="lbl_user_email">Your email</label><br>
        <input id="user_email" type="email" name="user_email" class="input" value="<?= $fieldValue; ?>"/>
    </td>
</tr>
<script>
    $(document).ready(function(){
        function changeEmailCheckbox() {
            if ($('#is_send_email').attr('checked')) {
                $('#email_container').show();
            } else {
                $('#email_container').hide();
            }
        }

        changeEmailCheckbox();

        $('#is_send_email').change(changeEmailCheckbox);
    });
</script>
<?php /******************************************************************************/ ?>
<?php /************************ END SEND EMAIL **************************************/ ?>
<?php /******************************************************************************/ ?>

<?php if(isset($_SESSION['isPreview']) && $_SESSION['isPreview']!="")
{ ?>
<tr class="white-bro">
	  <td align="center" valign="middle">
          <img src="../images/<?php echo BTN_NEXT;?>" />
      </td>
	</tr>
<?php
}
else
{ ?>
	<tr class="white-bro">
	  <td align="center" valign="middle">
          <input class="btn btn_next" type="submit" name="btnsubmit"  id="btnsubmit" value="Next &gt;" />
      </td>
	</tr>
<?php } ?>
  </table>
</table>
</div>
<div class="register1center">&nbsp;</div>
<div class="register1right">
<?php $objElectionDate->setAllValues("", " AND s.state_id='".$cmn->getSession('Home_State_ID')."' ");

if($objElectionDate->reg_deadline_description != "") {
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblform">
<tr id="row_1">
	<td align="left" valign="middle"><h2><?php echo LANG_IMPORTANT_NOTE;?></h2></td>
</tr>
<tr class='white-bro'>
<td align='left' valign='middle'><label class='normal_text'><?php print $objElectionDate->reg_deadline_description; ?></label></td></tr>
</table>
<?php } ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblform">
<tr id="row_1">
	<td align="left" valign="middle"><h2><?php echo LANG_GENERAL_ELIGIBILITY_CRITERIA;?></h2></td>
</tr>
<tr id="row_1">
	<td align="left" valign="middle">
		<ul style="padding-bottom:25px;">
			<li><?php echo LANG_MUST_BE_CITIZEN_OF_AMERICA;?></li>
			<li><?php echo LANG_MUST_BE_18_YERAS_OLD;?></li>
		</ul>
	</td>
</tr>
</table>
<?php
if(count($eligibility_criteria) > 0) { ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblform">
<tr id="row_1">
	<td align="left" valign="middle"><h2><?php echo LANG_STATE_ELIGIBILITY_CRITERIA;?></h2></td>
</tr>
<tr id="row_1">
	<td align="left" valign="middle"><ul style="padding-bottom:25px;">
<?php for($j=0; $j<count($eligibility_criteria); $j++){
if($eligibility_criteria[$j]["eligibility_criteria"] != "") {
?>
<li><?php echo $eligibility_criteria[$j]["eligibility_criteria"];?></li>
<?php }} ?>
</ul>
</td>
</tr>
</table>
<?php }
$office_addess = "";

if($objState->state_address1 != "")
	$office_addess = $objState->state_address1;
if($objState->state_address2 != "")
	$office_addess = $office_addess."<br>".$objState->state_address2;
if($objState->state_city != "")
	$office_addess = $office_addess."<br>".$objState->state_city;
if($objState->state_code != "")
	$office_addess = $office_addess.", ".$objState->state_code;
if($objState->zipcode != "")
	$office_addess = $office_addess." ".$objState->zipcode;

$contact_info = array();
$contact_info[] = "<tr class='white-bro'><td align='left' valign='middle'>".LANG_MAILING_ADDRESS.":<br> <label class='normal_text'>".$office_addess."</a></label></td></tr>";
if($objState->hotlineno != "")
	$contact_info[] = "<tr class='white-bro'>
<td align='left' valign='middle'>".LANG_HOTLINE_NO.": <label class='normal_text'>".$objState->hotlineno."</label></td></tr>";
if($objState->tollfree != "")
	$contact_info[] = "<tr class='white-bro'>
<td align='left' valign='middle'>".LANG_TOLL_FREE.": <label class='normal_text'>".$objState->tollfree."</label></td></tr>";
if($objState->phoneno != "")
	$contact_info[] = "<tr class='white-bro'>
<td align='left' valign='middle'>".LANG_PHONE_NO.": <label class='normal_text'>".$objState->phoneno."</label></td></tr>";
if($objState->faxno != "")
	$contact_info[] = "<tr class='white-bro'>
<td align='left' valign='middle'>".LANG_FAX_NO.": <label class='normal_text'>".$objState->faxno."</label></td></tr>";
if($objState->email != "")
	$contact_info[] = "<tr class='white-bro'>
<td align='left' valign='middle'>".LANG_EMAIL.": <label class='normal_text'><a href='mailto:".$objState->email."'>".$objState->email."</a></label></td></tr>";

if(count($contact_info) > 0)
{
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblform">
<tr id="row_1">
	<td align="left" valign="middle"><h2 style="line-height:18px;"><?php echo LANG_CONTACT_INFO_PART_1." ".$cmn->getSession('Home_State').LANG_CONTACT_INFO_PART_2;?></h2></td>
</tr>
<?php echo implode("", $contact_info);?>
</table>
<?php } ?>
</div>
</form>
<?PHP } ?>
<script type="text/javascript" language="Javascript">
<!--
function validate()
{
}

var idnumberlength = Array();
var idnumbernote = Array();
<?php echo $extra_js_idnumber;?>

function displayIDfield(fldname, shohidfield)
{
	var iddatafield = fldname.replace("frmfld", "idfld");

	if(idnumberlength[document.getElementById(fldname).selectedIndex] != "")
		document.getElementById(iddatafield).maxLength = idnumberlength[document.getElementById(fldname).selectedIndex];
	else
		document.getElementById(iddatafield).maxLength = "100";

	document.getElementById(iddatafield).value = "";

	if(document.getElementById(fldname).value != "")
		document.getElementById(shohidfield).style.display = '';
	else
		document.getElementById(shohidfield).style.display = 'none';

	var idnumerid =	idnumbernote[document.getElementById(fldname).selectedIndex];

	if(idnumerid == 3 || idnumerid == 4)
		document.getElementById("fixedIdNote").style.display = '';
	else
		document.getElementById("fixedIdNote").style.display = 'none';
}
$(document).ready(function(){
	$.validator.addMethod("DateFormat", function(value,element) {
				return ValidateCustomDate(value);
            },
            "<?php echo LANG_ENTER_VALID_DATE;?>"
     );
	 $.validator.addMethod("maxAllowDate", function(value,element) {
				return validMaxDate(value);
            },
            "<?php echo LANG_YOUR_ARE_NOT_ELIGIBLE_TO_VOTE_AS_BELOW_NOTE;?>"
     );

	$("#frm").validate({
		rules: {
			<?php if($extra_js_rules != "") {
			echo $extra_js_rules;
			} ?>
		},
		messages: {
			<?php if($extra_js_messages != "") {
			echo $extra_js_messages;
			} ?>
		},
		invalidHandler: function(form, validator) {
			$("#containererreurtotal").show();
		},
		unhighlight: function(element, errorClass) {
			if (this.numberOfInvalids() == 0) {
				$("#containererreurtotal").hide();
			}
			$(element).removeClass(errorClass);
		}
	});

  });

$.extend($.validator.messages, {
    required: "<?php echo LANG_FIELD_IS_REQUIRED;?>",
});
<?php
if(isset($jScript) && $jScript!="")
echo $jScript;
?>
//-->
</script>