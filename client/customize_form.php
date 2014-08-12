<?php
require_once 'include/general_includes.php';

// check if user has logged in
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$objPlan = new plan();
$client_id = $objClient->fieldValue("client_id",$userID);
$plan_id = $objClient->fieldValue("plan_id",$userID);
$languages = $objClient->fieldValue("languages",$userID);

$objPlan->setAllValues($plan_id);
$condition = "";

$objFieldMap = new field_mapping();
$allFields = $objFieldMap->get_all_mapping_field($client_id);

$objLanguage = new language();
$condi=" and language_isactive=1 and language_ispublish=1 and language_id in (".$languages.")";
$language=$objLanguage->fetchRecordSet("",$condi);

$objField = new field();
$objForm = new form();
$objFormAdmin = new form();

include "customize_form_db.php";

// extra css and js
$extraCss = array("sorting.css");
$extraJs = array("customize_form.js","jscolor.js");

$arrField = array();
if(isset($_REQUEST['field_id']) && $_REQUEST['field_id'] != "")
{
	$field_id = $_REQUEST['field_id'];

	$objField->field_id = $_REQUEST['field_id'];
	$arrField = $objField->getField_Dtl_For_Edit();
}

$conditionForm = " AND client_id = '".$client_id."' ";
$objForm->setallvalues("", $conditionForm);

$conditionForm = " AND client_id = '0' ";
$objFormAdmin->setallvalues("", $conditionForm);

if($objForm->form_background == "")
	$objForm->form_background = $objFormAdmin->form_background;
	
if($objForm->form_header_text == "")
	$objForm->form_header_text = $objFormAdmin->form_header_text;

if($objForm->form_normal_text_bg == "")
	$objForm->form_normal_text_bg = $objFormAdmin->form_normal_text_bg;

if($objForm->form_normal_text == "")
	$objForm->form_normal_text = $objFormAdmin->form_normal_text;
	
	
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
?>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
         <div class="user_tab_mn">
           <?php $msg->displayMsg(); ?>
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">Customize Form</div>
                  <div class="fright">&nbsp;</div>
                </div>
              </div>
            </div>
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
				<form id="frm" name="frm" method="post">
				<table cellpadding="0" cellspacing="0" border="0" width="100%"  class="table-bg"style="clear:both;" align="center" >
                                    <tr>
                                      <td colspan="10" valign="middle" class="table-raw-title" style="text-align:left; height:30px;">
                                      	<div class="section-title">Configure Layout Colors</div>
                                      </td>
                                    </tr>
									<?php if($objPlan->custom_color == 1) { ?>
                                    <tr>
                                      <td align="left" valign="top" style="padding-top:20px;"><table width="95%" align="center" cellpadding="0" cellspacing="0">
									  <tr>
                                      <td align="left" valign="top" style="padding-top:20px;" width="60%">
									  <table width="100%" align="center" cellpadding="0" cellspacing="0" class="listtab">
					<tr class="row4">
					  <td align="left" class="left-none" width="30%"><strong>Header Background:</strong></td>
					  <td class="listtab-rt-bro-user"><input type="text" id="txtHeaderBackground" name="txtHeaderBackground" class="color" value="<?php echo $objForm->form_background;?>"></td>
					</tr>
					<tr class="row4">
					  <td align="left" class="left-none"><strong>Header Text:</strong></td>
					  <td class="listtab-rt-bro-user"><input type="text" id="txtHeaderText" name="txtHeaderText" class="color" value="<?php echo $objForm->form_header_text;?>"></td>
					</tr>
					<tr class="row4">
					  <td align="left" class="left-none"><strong>Normal Text Background:</strong></td>
					  <td class="listtab-rt-bro-user"><input type="text" id="txtNormalBackground" name="txtNormalBackground" class="color" value="<?php echo $objForm->form_normal_text_bg;?>"></td>
					</tr>
					<tr class="row4">
					  <td align="left" class="left-none"><strong>Normal Text:</strong></td>
					  <td class="listtab-rt-bro-user"><input type="text" id="txtNormalText" name="txtNormalText" class="color" value="<?php echo $objForm->form_normal_text;?>"></td>
					</tr>
					<tr class="row4">
					  <td align="left" class="left-none">&nbsp;</td>
					  <td class="listtab-rt-bro-user"><input type="submit" name="btnLayout" value="Save" class="btn_img"></td>
					</tr>
				</table></td>
				<td align="left" width="40%">
				<img src="<?php echo SERVER_CLIENT_HOST?>images/admin_settings.jpg" /></td>
                </tr></table></td></tr>
				<?php } else { ?>
					<tr>
						<td align="center" valign="top" style="text-align:left; padding-top:20px;">
							<table width="95%" align="center" cellpadding="0" cellspacing="0" class="listtab">
								<tr class="row4" id="trPdfFieldName">
									<td valign="top" align="left" class="listtab-rt-bro-user">You haven't this feature available.</td>
								</tr>
							</table>
						</td>
					</tr>
					<?php } ?>
                </table>
				</form>

				<br /><br />
				<form id="frm1" name="frm1" method="post">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bg" style="clear:both;" >
				  <tr>
					<td valign="middle" class="table-raw-title" style="text-align:left; height:30px;"><div class="section-title">Customize Form Fields</div></td>
				  </tr>
				  <?php if($objPlan->custom_field == 1) { 
				  
					$condition = " AND fi.field_mapping_id = '1' ";
					$arrField1 = $objField->fetchAll_Field($client_id, $condition);
					?>
				  <tr>
					<td align="left" valign="top" style="text-align:left; padding-top:20px;"><table width="95%" align="center" cellpadding="0" cellspacing="0" class="listtab">
					<tr class="row4">
					  <td align="left" class="left-none" width="20%"><strong>Select Field Type:</strong> </td>
					  <td class="listtab-rt-bro-user">
					  <?php
					  $field_type = "";
					  if(count($arrField) > 0) {
						foreach($allFields as $afkey=>$afval) {
							if($afval['field_mapping_id'] == $arrField[0]['field_mapping_id']) { echo $afval['field_mapping_name'];
							echo '<input type="hidden" name="selFieldType" id="selFieldType" value="'.$arrField[0]['field_mapping_id'].'"/>';
							}
						}
					  } else { ?>
					  <select name="selFieldType" id="selFieldType" onchange="showHideFieldOptions(this.value);">
						<option value="">Select</option>
						<?php foreach($allFields as $afkey=>$afval) {
						?>
						<option value="<?php echo $afval['field_mapping_id']; ?>"><?php echo $afval['field_mapping_name']; ?></option>
						<?php }?>
					  </select> <span class="red">*</span>
					  <?php } if(count($arrField1) == 0){ ?> &nbsp;&nbsp;(<strong>Note:</strong> You must add header field before adding other fields.)<?php } ?>
					  </td>
					</tr>
					</table>
				  <div id="trFieldSelection" <?php if(!(count($arrField) > 0)) { ?>style="display:none;" <?php } ?>>
				  <br /><br />
				  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td align="left" valign="top"><div class="blue-bg">Field Section</div></td>
					</tr>
					<tr class="row02">
					  <td height="5" align="left" valign="top"></td>
					</tr>					
					<tr>
					  <td align="left" valign="top" bgcolor="#fff"><table width="100%" align="center" cellpadding="10" cellspacing="0" class="listtab1">
					<tr class="row4" id="trHeaderField">
					  <td valign="top" align="left" class="left-none"><strong>Select Header Field:</select></td>
					  <td width="80%" valign="top" align="left">
					  <?php if(isset($arrField[0]['field_header_field']) && $arrField[0]['field_header_field'] > 0){
					  foreach($arrField1 as $afkey=>$afval) {
						if(count($arrField) > 0) {
							if($afval['field_id'] == $arrField[0]['field_header_field']) {
								echo $afval['field_caption'];
								echo '<input type="hidden" name="selHeaderField" id="selHeaderField" value="'.$arrField[0]['field_header_field'].'"/>';
							}
						}
					  }	}
					  else { ?>
					  <select name="selHeaderField" id="selHeaderField">
						<option value="">Select</option>
						<?php foreach($arrField1 as $afkey=>$afval) {
						if(count($arrField) > 0) {
						?>
						<option value="<?php echo $afval['field_id']; ?>" <?php if($afval['field_id'] == $arrField[0]['field_header_field']) { echo "selected";}?>><?php echo $afval['field_caption']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $afval['field_id']; ?>"><?php echo $afval['field_caption']; ?></option>
						<?php }} ?>
					  </select> <span class="red">*</span>
					  <?php } ?>
					  </tr>
					<!-- <tr class="row4">
					  <td valign="top" align="left" class="left-none"><strong>Registration Type:</strong> <span class="compulsory">*</span></td>
					  <td width="80%" valign="top" align="left">
					  <?php if(count($arrField) > 0) { ?>
					  <select name="selRegType" id="selRegType">
					  <option value="">Select</option>
					  <option value="General" <?php if($arrField[0]['reg_type'] == "General"){ echo "selected";}?>>General</option>
					  <option value="Absentee" <?php if($arrField[0]['reg_type'] == "Absentee"){ echo "selected";}?>>Absentee</option>
					  </select>
					  <?php } else { ?>
					  <select name="selRegType" id="selRegType">
					  <option value="">Select</option>
					  <option value="General">General</option>
					  <option value="Absentee">Absentee</option>
					  </select>
					  <?php } ?>
					  </td>
					</tr>
					<input type="hidden" name="selRegType" value="General">
					<tr class="row4" id="trPdfFieldName">
					  <td valign="top" align="left" class="left-none"><strong>PDF Field Name:</strong> </td>
					  <td width="80%" valign="top" align="left">
					  <?php if(count($arrField) > 0) { ?>
					  <input type="text" id="txtPdfFieldName" name="txtPdfFieldName" value="<?php echo $arrField[0]['pdf_field_name'];?>" />
					  <?php } else { ?>
					  <input type="text" id="txtPdfFieldName" name="txtPdfFieldName" />
					  <?php } ?>
					  </td>
					</tr>-->
					<input type="hidden" name="selRegType" value="General">
					<tr class="row4" id="trFieldName">
					  <td valign="top" align="left" class="left-none"><strong>Field Name: </strong></td>
					  <td width="80%" valign="top" align="left">
					  <?php if(count($arrField) > 0) { ?>
					  <input type="text" id="txtFieldName" name="txtFieldName" class="listtab-input" value="<?php echo $arrField[0]['field_name'];?>" /> <span class="red">*</span>
					  <?php } else { ?>
					  <input type="text" id="txtFieldName" name="txtFieldName" class="listtab-input" /> <span class="red">*</span>
					  <?php } ?>
					  </td>
					</tr>
					<?php
					$varCont_Lang1 = "";
					for($i=0;$i<count($language);$i++) {

					$arrCaption_Language = array();

					if(count($arrField) > 0)
					{
						$objField->language_id = $language[$i]['language_id'];
						$arrCaption_Language = $objField->getField_Language_Text_For_Edit();
					}

					if($i == 0)
					{
						$lablename = "<strong>Label:</strong>";
						$varCont_Lang1 = $language[$i]['language_id'];
					}
					else
					{
						$lablename = "&nbsp;";
						$varCont_Lang1 = $varCont_Lang1.",".$language[$i]['language_id'];
					}
					?>
					<tr class="row4" id="trLabel_<?php echo $language[$i]['language_id']?>">
					  <td valign="top" align="left" class="left-none"><?php echo $lablename;?></td>
					  <td width="80%" valign="top" align="left">
					  <?php if(count($arrCaption_Language) > 0) { ?>
					  <input type="text" id="txtFieldLabel_<?php echo $language[$i]['language_id']?>" name="txtFieldLabel_<?php echo $language[$i]['language_id']?>" value="<?php echo $arrCaption_Language[0]['field_caption'];?>" class="listtab-input" /><img alt="<?php echo $language[$i]['language_name']?>" title="<?php echo $language[$i]['language_name']?>" src="<?php echo SERVER_CLIENT_HOST?>images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" /> <?php if($i==0) { ?><span class="red">*</span> <?php } ?>
					  <?php } else { ?>
					  <input type="text" id="txtFieldLabel_<?php echo $language[$i]['language_id']?>" name="txtFieldLabel_<?php echo $language[$i]['language_id']?>" value="" class="listtab-input" /><img alt="<?php echo $language[$i]['language_name']?>" title="<?php echo $language[$i]['language_name']?>" src="<?php echo SERVER_CLIENT_HOST?>images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" /> <?php if($i==0) { ?><span class="red">*</span> <?php } ?>
					  <? } ?>
					  </td>
					</tr>
					<?php } ?>
					<tr class="row4" id="trRequired">
					  <td valign="top" align="left" class="left-none"><strong>Required:</strong></td>
					  <td width="80%" valign="top" align="left">
					  <?php if(count($arrField) > 0) { ?>
					  <input type="checkbox" id="chkRequired" name="chkRequired" value="1" <?php if($arrField[0]['is_required'] == 1) { echo "checked";} ?> />
					  <?php } else { ?>
					  <input type="checkbox" id="chkRequired" name="chkRequired" value="1" />
					  <?php } ?>
					  </td>
					</tr>
					<?php
					$varCont_Lang1 = "";
					for($i=0;$i<count($language);$i++) {

					$arrCaption_Language = array();

					if(count($arrField) > 0)
					{
						$objField->language_id = $language[$i]['language_id'];
						$arrCaption_Language = $objField->getField_Language_Text_For_Edit();
					}

					if($i == 0)
					{
						$lablename = "<strong>Note:</strong>";
						$varCont_Lang1 = $language[$i]['language_id'];
					}
					else
					{
						$lablename = "&nbsp;";
						$varCont_Lang1 = $varCont_Lang1.",".$language[$i]['language_id'];
					}
					?>
					<tr class="row4" id="trFieldNote_<?php echo $language[$i]['language_id']?>">
					  <td valign="top" align="left" class="left-none"><?php echo $lablename;?></td>
					  <td width="80%" valign="top" align="left">
					  <?php if(count($arrCaption_Language) > 0) { ?>
					  <input type="text" id="txtFieldNote_<?php echo $language[$i]['language_id']?>" name="txtFieldNote_<?php echo $language[$i]['language_id']?>" value="<?php echo $arrCaption_Language[0]['field_note'];?>" style="width:250px;" /><img alt="<?php echo $language[$i]['language_name']?>" title="<?php echo $language[$i]['language_name']?>" src="<?php echo SERVER_CLIENT_HOST?>images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />
					  <?php } else { ?>
					  <input type="text" id="txtFieldNote_<?php echo $language[$i]['language_id']?>" name="txtFieldNote_<?php echo $language[$i]['language_id']?>" value="" style="width:250px;" /><img alt="<?php echo $language[$i]['language_name']?>" title="<?php echo $language[$i]['language_name']?>" src="<?php echo SERVER_CLIENT_HOST?>images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />
					  <? } ?>
					  </td>
					</tr>
					<?php } ?>
					<tr class="row4" id="trHideByDefault">
					  <td valign="top" align="left" class="left-none" style="padding-bottom: 20px;"><strong>Hide by default:</strong></td>
					  <td width="80%" valign="top" align="left">
					  <?php if(count($arrField) > 0) { ?>
					  <input type="checkbox" id="chkHideDefault" name="chkHideDefault" value="1" <?php if($arrField[0]['field_ishide'] == 1) { echo "checked";} ?> />
					  <?php } else { ?>
					  <input type="checkbox" id="chkHideDefault" name="chkHideDefault" value="1" />
					  <?php } ?>
					  </td>
					</tr>
					<tr class="row4" id="trChoiceHeader">
					  <td valign="top" align="left" class="left-none" colspan="2" style="border-top: 1px dashed #5899C5; font-size:14px; padding-top: 10px;"><div class="blue14">Add Choice</div></td>
					</tr>
					<?php for($i=0;$i<count($language);$i++) {
					if($i == 0)
						$lablename = "<strong>Choice:</strong>";
					else
						$lablename = "&nbsp;";
					?>
					<tr class="row4" id="trChoice_<?php echo $language[$i]['language_id']?>">
					  <td valign="top" align="left" class="left-none"><?php echo $lablename;?></td>
					  <td width="80%" valign="top" align="left"><input type="text" id="txtChoice_<?php echo $language[$i]['language_id']?>" name="txtChoice_<?php echo $language[$i]['language_id']?>"  <?php if($i==0){ ?>rel="req_opt" <?php } ?> class="listtab-input" /><img alt="<?php echo $language[$i]['language_name']?>" title="<?php echo $language[$i]['language_name']?>" src="<?php echo SERVER_CLIENT_HOST?>images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />
					  <?php if($i == 0) { ?>
					  <span class="red">*</span>
					  <?php } if($i == (count($language) - 1)) { ?>
					  &nbsp;&nbsp;
					  <input type="button" name="btnChoice" value="Add Choice" class="make_paymet" onClick="javascript:addOption();" style="float:none;">
					  <?php } ?>
					  </td>
					</tr>
					<?php }
						$arrField_Option = array();
						$objfield_option = new field_option();
						$All_Options = "";
						$All_Options_Id = "";

						if(isset($field_id) && $field_id!="")
						{
							if($arrField[0]['field_mapping_id'] == "2" || $arrField[0]['field_mapping_id'] == "4" || $arrField[0]['field_mapping_id']=="6")
							{
								$arrField_Option = $objfield_option->fetchallasarray(NULL, NULL, " and field_id = $field_id");
								$All_Options = $objfield_option->getAllOption_For_Fields_For_Edit($field_id);
								$All_Options_Id = $objfield_option->getAllOption_For_Fields_Id_For_Edit($field_id);
							}
						}
					?>
					<tr class="row4" id="trOptions" <?php if(!(count($arrField_Option) > 0)){ ?>style="display:none;" <?php } ?>>
						<td>&nbsp;</td>
						<td>
						   <table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" id="tblOptions">
								<tr>
								  <td width="35%" align="left"><strong>Options</strong></td>
								  <td width="65%" align="left"><strong>Delete</strong></td>
								</tr>
								<?php
								if(count($arrField_Option) > 0)
								{
									$cntr_field_option = 0;
									while($cntr_field_option < count($arrField_Option))
									{?>
									  <tr>
                                          <td align="left"><?php echo $arrField_Option[$cntr_field_option]["field_option"]; ?></td>
										  <td align="left"><img src='<?php echo SERVER_CLIENT_HOST?>images/delete2.gif' onclick='return deleteOptipon(this)' /></td>
                                        </tr>
									<?php
										$cntr_field_option++;
									}
								}
								?>
						   </table>
						</td>
					</tr>
					</table></td>
					</tr>
					<tr>
					<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" >
					<?php
					$objfield_option = new field_option();

					if(isset($_REQUEST['field_id']) && $_REQUEST['field_id'] != "")
						$arrAll_Option = $objfield_option->getAllOption_With_Fields($client_id, $_REQUEST['field_id']);
					else
						$arrAll_Option = $objfield_option->getAllOption_With_Fields($client_id);
					?>
					<tr class="row4" id="trConditionalLogicOption" <?php if(!(count($arrAll_Option) > 0)) { ?> style="display:none;" <?php } ?>>
					  <td valign="top" align="left" colspan="2">
					  <?php
							$objfield_condition = new field_condition();
							$isConditional = 0;

							if(isset($_REQUEST['field_id']) && $_REQUEST['field_id'] != "")
								$arrselected_option = $objfield_condition->fetchallasarray(NULL, NULL, "and ((show_field_ids like ('%,$field_id%')) or (hide_field_ids like ('%,$field_id%')))");
							else
								$arrselected_option = array();

							$select_show_field_option = "0";
							$select_hide_field_option = "0";
							if(count($arrselected_option) > 0)
							{
								$pos_show = strpos($arrselected_option[0]["show_field_ids"], ",$field_id");
								if(!($pos_show === false))
								{
									$select_show_field_option = $arrselected_option[0]["field_option_id"];
									$isConditional = 1;	
								}	
								
								$pos_hide = strpos($arrselected_option[0]["hide_field_ids"], ",$field_id");
								if(!($pos_hide === false))
								{
									$select_hide_field_option = $arrselected_option[0]["field_option_id"];
									$isConditional = 1;		
								}	
							}
					  ?>
					  <div class="blue14">Conditional Logic: <input type="checkbox" value="1" id="chkShow" name="chkShow" <?php if($isConditional == 1) { echo "checked";} ?> onClick="showHideConditionalLogic();"></div>
					  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblconditional" <?php if($isConditional != 1) { echo "style='display:none;'";} ?>>
                        	<?php
							$option_cntr = 0;
							while($option_cntr < count($arrAll_Option))
			  				{
								$checked_show_condition = "";

								//echo $select_show_field_option;
							 	if($select_show_field_option == $arrAll_Option[$option_cntr]["field_option_id"])
									$checked_show_condition = " checked='checked' ";
							?>
                            <tr>
                              <td align="left" valign="middle" height="25"><input type="radio" name="condition" id="condition_show_<?php echo $arrAll_Option[$option_cntr]["field_option_id"]; ?>" value="show-<?php echo $arrAll_Option[$option_cntr]["field_option_id"]; ?>" <?php echo $checked_show_condition; ?>>
                                Show <strong>this field</strong> if value of <strong><?php echo $arrAll_Option[$option_cntr]["field_caption"]; ?></strong> field is <strong>"<?php echo $arrAll_Option[$option_cntr]["field_option"]; ?>"</strong></td>
                            </tr>
							<?php
							$option_cntr++;
							}
							?>



                            <?php
							 $option_cntr = 0;
							 while($option_cntr < count($arrAll_Option))
			  				{
								$checked_hide_condition = "";

								//echo $select_hide_field_option;
							 	if($select_hide_field_option == $arrAll_Option[$option_cntr]["field_option_id"])
									$checked_hide_condition = " checked='checked' ";
							?>
                            <tr>
                              <td align="left" valign="middle" height="25"><input type="radio" name="condition" id="condition_hide_<?php echo $arrAll_Option[$option_cntr]["field_option_id"]; ?>" value="hide-<?php echo $arrAll_Option[$option_cntr]["field_option_id"]; ?>"  <?php echo $checked_hide_condition; ?>>
                                Hide <strong>this field</strong> if value of <strong><?php echo $arrAll_Option[$option_cntr]["field_caption"]; ?></strong> field is <strong>"<?php echo $arrAll_Option[$option_cntr]["field_option"]; ?>"</strong>
								<?php if($option_cntr == (count($arrAll_Option) - 1)) { ?>
								  &nbsp;&nbsp;
								  <input type="button" id="btnremovecondition" name="btnremovecondition" value="Remove Condition" class="btn_img_long" onClick="javascript:remove_field_properties();" style="float:none;" />
								  <?php } ?>
								</td>
                            </tr>
							<?php
							$option_cntr++;
							}
							?>
                          </table></td>
					</tr>
					<tr class="row4">
					  <td valign="top" align="left" class="left-none" colspan="2">&nbsp;</td>
					</tr>
					<tr class="row4">
					  <td valign="top" align="left" class="left-none">&nbsp;</td>
					  <td width="80%" valign="top" align="left"><input type="submit" id="btnFormSubmit" name="btnFormSubmit" value="Save" onclick="return formValidate();" class="btn_img"> <input type="button" id="btnCancel" name="btnCancel" value="Cancel" onclick="javascript: window.location.href='customize_form.php';" class="btn_img"></td>
					</tr>
                </table></td>
					</tr>
                </table>
				</div>

				<?php
					$max_order = $objField->getLast_Order($client_id);
				?>
                <input type="hidden" id="hidMax_Field_Order" name="hidMax_Field_Order" value="<?php echo $max_order; ?>" />
				<input  type="hidden" name="hdndefaultlanguage_id" id="hdndefaultlanguage_id" value="<?php echo ENGLISH_LANGUAGE_ID; ?>"/>
				<input  type="hidden" name="hdnfield_type" id="hdnfield_type" value=""/>

				<?php if(count($arrField) >0) { ?>
				<input  type="hidden" name="hdnfield_id" id="hdnfield_id" value="<?php echo $_REQUEST['field_id'];?>"/>
				<input  type="hidden" name="hdnmode" id="hdnmode" value="edit"/>
				<?php } else { ?>
				<input  type="hidden" name="hdnmode" id="hdnmode" value="add"/>
				<?php } ?>

				<input type="hidden" id="hidAll_Options" name="hidAll_Options" value="<?php echo $All_Options; ?>"/>
                <input type="hidden" id="hidAll_Options_Id" name="hidAll_Options_Id" value="<?php echo $All_Options_Id; ?>"/>
				<input type="hidden" name="hidlanguage_ids" id="hidlanguage_ids" value="<?php echo $varCont_Lang1; ?>">
				<?php if(count($arrField) > 0){ ?>
				<script type="text/javascript">
				showHideFieldOptions(<?php echo $arrField[0]['field_mapping_id'];?>);
				</script>
				<input type="hidden" name="hidfield_id" id="hidfield_id" value="<?php echo $field_id; ?>">
				<?php } ?>
				</form>
				<?php
				$query_string = "";
				$field_header_cntr = 0;
				$field_cntr = 0;
				$preview_condition = " AND fi.field_mapping_id = '1'";
				$arrField1 = $objField->fetchAll_Field($client_id, $preview_condition);

				if(count($arrField1) >0) { ?>
				<br /><br />
				<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="blue-bg" style="padding:0px;">
					<tr>
					  <td align="left" valign="top"><div >&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/preview.png" />&nbsp;Preview</div></td>
					</tr>
					<tr class="row02">
					  <td height="5" align="left" valign="top">
					  </td>
					</tr>
					<tr>
					  <td align="left" valign="top" bgcolor="#FFFFFF" ><table width="95%" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tblPreview">
					<tr>
						<td  align="left" style="text-align:left !important;">
							<div id="divSoringContainer">
								<ul style="padding-left:0px; margin:0px;">
								<?php
								while($field_header_cntr < count($arrField1))
								{
								$preview_condition = " AND fi.field_header_field = '".$arrField1[$field_header_cntr]["field_id"]."'";
								$arrField = $objField->fetchAll_Field($client_id, $preview_condition);
								?>
								<li id="recordsArray_<?PHP echo $arrField1[$field_header_cntr]['field_id']; ?>" style="background-color:#FFFFFF; border: 1px solid #CCCCCC;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
								  <td valign="middle" align="left" style="text-align:left !important; padding-top:10px;" class="blue14">
								  	<?php
									if($arrField1[$field_header_cntr]["field_mapping_id"] == "1")
									{  echo "<font size='3'>".$arrField1[$field_header_cntr]["field_caption"]."</font>"; ?>
									   &nbsp;<a href="customize_form.php?field_id=<?php echo $arrField1[$field_header_cntr]["field_id"]; ?><?php echo $query_string; ?>" title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;
									   <?php if(!(count($arrField) > 0)) { ?>
									   <img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16" onclick="javascript:deleteField(this, <?php echo $arrField1[$field_header_cntr]["field_id"] ?>)" style="cursor:pointer;">
                                    <?PHP }} ?>
									</td>
								</tr>
								</table>
								<div class="divSoringContainer1">
								<ol style="padding-left:5px;">
								<?php

								if(count($arrField) >0) {
								$field_cntr = 0;
								while($field_cntr < count($arrField))
								{
								?>
								<li id="recordsArray_<?PHP echo $arrField[$field_cntr]['field_id']; ?>"  style="border: 1px solid #7AD2FF;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr class="movetr">
								  <td valign="middle" align="left" style="text-align:left !important;" width="15%">
								  	<?php
									if($arrField[$field_cntr]["field_mapping_id"] == "1")
									{  echo "<font size='3'><u>".$arrField[$field_cntr]["field_caption"]."</u></font>"; ?>
									   &nbsp;<a href="customize_form.php?field_id=<?php echo $arrField[$field_cntr]["field_id"]; ?><?php echo $query_string; ?>" title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16" onclick="javascript:deleteField(this, <?php echo $arrField[$field_cntr]["field_id"] ?>)" style="cursor:pointer;">
                                    <?PHP }
									else if($arrField[$field_cntr]["field_mapping_id"] == "3")
									{

								?>
								<input type="checkbox" name="<?php echo $arrField[$field_cntr]["field_name"]; ?>" id="<?php echo $arrField[$field_cntr]["field_name"]."_".$option_cntr ; ?>" />
									&nbsp;<?php echo $arrField[$field_cntr]['field_caption']; ?> &nbsp;<a href="customize_form.php?field_id=<?php echo $arrField[$field_cntr]["field_id"]; ?><?php echo $query_string; ?>" title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16" onclick="javascript:deleteField(this, <?php echo $arrField[$field_cntr]["field_id"] ?>)" style="cursor:pointer;">
									<?php

									}
									else
									{
										echo $arrField[$field_cntr]['field_caption'];
									}
									?>
								  <?php if($arrField[$field_cntr]["field_mapping_id"] != "3") { ?>
								  <br />
									<?php if($arrField[$field_cntr]["field_mapping_id"] == "2")
									{
										$objfield_option = new field_option();
										$arrOption_List = $objfield_option->fetchallasarray(NULL, NULL, " and field_id = ".$arrField[$field_cntr]["field_id"], "field_option_order");
										$option_cntr = 0;
										while($option_cntr < count($arrOption_List))
										{
								?>
                    <input type="radio" name="<?php echo $arrField[$field_cntr]["field_name"]; ?>" id="<?php echo $arrField[$field_cntr]["field_name"]."_".$option_cntr ; ?>" />
                    &nbsp;<?php echo $arrOption_List[$option_cntr]["field_option"]; ?>
					                    <?php
											$option_cntr++;
										}
										?>
									&nbsp; <a href="customize_form.php?field_id=<?php echo $arrField[$field_cntr]["field_id"]; ?><?php echo $query_string; ?>" title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16" onclick="javascript:deleteField(this, <?php echo $arrField[$field_cntr]["field_id"] ?>)" style="cursor:pointer;">
									<?php
									}

									if($arrField[$field_cntr]["field_mapping_id"] == "6")
									{
										$objfield_option = new field_option();
									$arrOption_List = $objfield_option->fetchallasarray(NULL, NULL, " and field_id = ".$arrField[$field_cntr]["field_id"], "field_option_order");

								?>
                    <select style="width:232px;" id="<?php echo $arrField[$field_cntr]["field_name"]; ?>" name="<?php echo $arrField[$field_cntr]["field_name"]; ?>">
                      <?php

									$option_cntr = 0;

									while($option_cntr < count($arrOption_List))
									{
								?>
                      <option value="<?php echo $arrOption_List[$option_cntr]["field_option"]; ?>"><?php echo $arrOption_List[$option_cntr]["field_option"]; ?></option>
                      <?php
										$option_cntr++;
									}
									?>
                    </select>
                    &nbsp; <a href="customize_form.php?field_id=<?php echo $arrField[$field_cntr]["field_id"]; ?><?php echo $query_string; ?>" class=title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16"  onclick="javascript:deleteField(this, <?php echo $arrField[$field_cntr]["field_id"] ?>)" style="cursor:pointer;"></a>
                    <?php
									}
									if($arrField[$field_cntr]["field_mapping_id"] == "5" || $arrField[$field_cntr]["field_mapping_id"] == "14" || $arrField[$field_cntr]["field_mapping_id"] == "16")
									{

										?>
                    <input type="text" id="<?php echo $arrField[$field_cntr]["field_name"]; ?>" name="<?php echo $arrField[$field_cntr]["field_name"]; ?>" size="40" />
                    &nbsp; <a href="customize_form.php?field_id=<?php echo $arrField[$field_cntr]["field_id"]; ?><?php echo $query_string; ?>" class=title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16" onclick="javascript:deleteField(this, <?php echo $arrField[$field_cntr]["field_id"] ?>)" style="cursor:pointer;">
                    <?php

									}
									if($arrField[$field_cntr]["field_mapping_id"] == "4")
									{
										if($arrField[$field_cntr]["field_type_id"] != "6")
										{
											$objfield_option = new field_option();
											$arrOption_List = $objfield_option->fetchallasarray(NULL, NULL, " and field_id = ".$arrField[$field_cntr]["field_id"], "field_option_order");
											$option_cntr = 0;
											while($option_cntr < count($arrOption_List))
											{

								?>
                    <input type="checkbox" name="<?php echo $arrField[$field_cntr]["field_name"]; ?>" id="<?php echo $arrField[$field_cntr]["field_name"]."_".$option_cntr ; ?>" /><?php echo $arrOption_List[$option_cntr]["field_option"]; ?>&nbsp;
                    <?php
												$option_cntr++;
											}
											?>
											 <a href="customize_form.php?field_id=<?php echo $arrField[$field_cntr]["field_id"]; ?><?php echo $query_string; ?>" title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16" onclick="javascript:deleteField(this, <?php echo $arrField[$field_cntr]["field_id"] ?>)" style="cursor:pointer;">
										<?php
										}
									}

									if(($arrField[$field_cntr]["field_mapping_id"] > 6 && $arrField[$field_cntr]["field_mapping_id"] <= 10) || $arrField[$field_cntr]["field_mapping_id"] == 13 || $arrField[$field_cntr]["field_mapping_id"] == 15)
									{ ?>
									<select style="width:232px;" id="<?php echo $arrField[$field_cntr]["field_name"]; ?>" name="<?php echo $arrField[$field_cntr]["field_name"]; ?>">
									</select> <a href="customize_form.php?field_id=<?php echo $arrField[$field_cntr]["field_id"]; ?><?php echo $query_string; ?>" title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16" onclick="javascript:deleteField(this, <?php echo $arrField[$field_cntr]["field_id"] ?>)" style="cursor:pointer;">
									<? }
									if($arrField[$field_cntr]["field_mapping_id"] == "11")
									{ ?>
									<input type="text" id="<?php echo $arrField[$field_cntr]["field_name"]; ?>" name="<?php echo $arrField[$field_cntr]["field_name"]; ?>" size="40" /> <img src="<?php echo SERVER_CLIENT_HOST?>images/Calender.png" border="0">
									&nbsp; <a href="customize_form.php?field_id=<?php echo $arrField[$field_cntr]["field_id"]; ?><?php echo $query_string; ?>" title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16" onclick="javascript:deleteField(this, <?php echo $arrField[$field_cntr]["field_id"] ?>)" style="cursor:pointer;">
									<?php }

									if($arrField[$field_cntr]["field_mapping_id"] == "12")
									{ ?>
									<textarea id="<?php echo $arrField[$field_cntr]["field_name"]; ?>" rows="5" cols="45" name="<?php echo $arrField[$field_cntr]["field_name"]; ?>"></textarea>
									&nbsp; <a href="customize_form.php?field_id=<?php echo $arrField[$field_cntr]["field_id"]; ?><?php echo $query_string; ?>" title="Edit Field"><img src="<?php echo SERVER_CLIENT_HOST?>images/edit.png" width="16" height="17"></a>&nbsp;&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/delete2.gif" width="16" height="16" onclick="javascript:deleteField(this, <?php echo $arrField[$field_cntr]["field_id"] ?>)" style="cursor:pointer;">
									<?php } ?>
								  <?php } ?>
								  </td>
								</tr>
								</table>
								</li>
								<?php $field_cntr++; }} ?>
								</ol></div></li>
								<?php $field_header_cntr++; } ?>
								</ul>
							</div>
						</td>
					</tr>
					<tr><td style="padding:10px 10px 10px 10px;"><a href="preview_form.php" target="_blank"><input name="button" type="button" class="btn_img_long" id="button" value="Preview The Complete Form" /></a></td></tr>
					</table></td>
					</tr>
                </table>
				<?php } ?>		</td>
					</tr>
					<?php } else { ?>
					<tr>
						<td align="center" valign="top" style="text-align:left; padding-top:20px;">
							<table width="95%" align="center" cellpadding="0" cellspacing="0" class="listtab">
								<tr class="row4" id="trPdfFieldName">
									<td valign="top" align="left" class="listtab-rt-bro-user">You haven't this feature available.</td>
								</tr>
							</table>
						</td>
					</tr>
					<?php } ?>
				</table>
            </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery(function() {
		jQuery("#divSoringContainer ul").sortable({update: function() {
			var order = jQuery(this).sortable("serialize") + '&action=updateRecordsListings';
			jQuery.post("form_builder_order_db.php", order, function(theResponse){
			});
		},
		cancel: ".divSoringContainer1"
		});

		jQuery(".divSoringContainer1 ol").sortable({update: function() {
			var order = jQuery(this).sortable("serialize") + '&action=updateRecordsListings';
			jQuery.post("form_builder_order_db.php", order, function(theResponse){
			});
		}
		});
	});
});



function showHideConditionalLogic()
{
	if(document.getElementById("chkShow").checked == true)
	{
		jQuery("#tblconditional").css("display", "");
	}
	else
	{
		jQuery("#tblconditional").css("display", "none");
		remove_field_properties();
	}
}
</script>
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>