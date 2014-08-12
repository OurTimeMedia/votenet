<table cellpadding="0" cellspacing="0" border="0" width="100%"> 
	<tr>
      <td>
      <div>
		<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();">				
			      	<table class="listtab" cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;">
			
				
					<tr class="row01">
					  <td align="left" valign="top" class="txtbo">Language</td>
					  <td width="82%" align="left" valign="top">
					  <table cellpadding="0" cellspacing="0" border="0" width="80%" style="clear:both;">
					  <?php
					  $arrLanguages = $objElectionDate->fetchElectionDateLanguage();			  
					  $arrElectionDateLanguages = $objElectionDate->fetchElectionDateLanguageDetail();
					  
					for($i=0;$i<count($language);$i++)
					{
						$checked='';
						$disabled ='';
						if($language[$i]['language_id']==1)
						{
								$checked = 'checked';
								$disabled = 'disabled="disabled"';
						}
						
						if(in_array($language[$i]['language_id'],$arrLanguages))
						{
							$checked = 'checked';
						}									
						
						if($i%3==0){
						echo "<tr>";$j=0;}
					  ?>
					      <td><input type="checkbox" name="language[]" value="<?php echo $language[$i]['language_id']?>" id="<?php echo $language[$i]['language_name']?>" <?php echo $checked?> <?php echo $disabled?> onclick="display_lanrows('<?php echo $language[$i]['language_name']?>')"   />	
				          <?php echo $language[$i]['language_name']?></td>
					      <?php if($j==3){
						echo "</tr>";
						} }?>
						
					  </table></td>
					  </tr>					  
					  <tr class="row01">
						<td align="left" valign="top" width="18%" class="txtbo">Election Type:&nbsp;<span class="compulsory">*</span>&nbsp;</td>
						<td align="left" valign="top">
							<select name="selElectionType" id="selElectionType">
								<option value="">Select Election Type</option>
							<?php for ($i=0;$i<count($arrElectionType);$i++){ ?>
							  <option value="<?php echo $arrElectionType[$i]['election_type_id'];?>" <?php if($arrElectionType[$i]['election_type_id'] == $objElectionDate->election_type_id) { echo "selected";} ?>><?php echo $arrElectionType[$i]['election_type_name'];?></option>
							<?php } ?>
							</select>
						</td>
					  </tr>
					  <tr class="row01">
						<td align="left" valign="top" width="18%" class="txtbo">State:&nbsp;<span class="compulsory">*</span>&nbsp;</td>
						<td align="left" valign="top">
							<select name="selState" id="selState">
								<option value="">Select State</option>
							<?php for ($i=0;$i<count($arrState);$i++){ ?>
							  <option value="<?php echo $arrState[$i]['state_id'];?>" <?php if($arrState[$i]['state_id'] == $objElectionDate->state_id) { echo "selected";} ?>><?php echo $arrState[$i]['state_code'];?> - <?php echo $arrState[$i]['state_name'];?></option>
							<?php } ?>							
							</select>
						</td>
					  </tr>
					  <tr class="row01">
						<td align="left" valign="top" width="18%" class="txtbo">Election Date:&nbsp;<span class="compulsory">*</span>&nbsp;</td>
						<td align="left" valign="top">
							<?php if($objElectionDate->election_date !="" ) { ?>
							<input class="input_text" type="text" name="election_date" id="election_date" value="<?php echo $cmn->convertFormtDate($objElectionDate->election_date,"m/d/Y");?>" maxlength="50" readonly="readonly"/>
							<?php } else { ?>
							<input class="input_text" type="text" name="election_date" id="election_date" value="" maxlength="50" readonly="readonly"/>
							<?php } ?>
                        <img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('election_date').focus();">
						</td>
					  </tr>					  
					<?php for($i=0;$i<count($language);$i++) {
								$styleDetail = '';
								$lableField = 'Description:'.COMPULSORY_FIELD;								
								$Description_value = $cmn->readValueDetail($objElectionDate->election_description);
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$Description_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["Description_".$language[$i]['language_id']]))
									{
										$Description_value = $cmn->readValueDetail($_POST["Description_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrElectionDateLanguages[$language[$i]['language_id']]['election_description']))
											$Description_value = $cmn->readValueDetail($arrElectionDateLanguages[$language[$i]['language_id']]['election_description']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["Description_".$language[$i]['language_id']]))
									{
										$Description_value = $cmn->readValueDetail($_POST["Description_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrElectionDateLanguages[$language[$i]['language_id']]['election_description']))
											$Description_value = $cmn->readValueDetail($arrElectionDateLanguages[$language[$i]['language_id']]['election_description']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="electiondescription_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>			
						<td align="left" valign="top" >
							<textarea name="election_description_<?PHP echo $language[$i]['language_id']; ?>" id="election_description_<?PHP echo $language[$i]['language_id']; ?>" rows="3" cols="37"><?PHP echo $Description_value; ?></textarea>	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px; vertical-align:top;" align="abs-top" />					</td>
					</tr>
					<?php }?>
					<tr class="row01">
						<td align="left" valign="top" width="18%" class="txtbo">Registration Deadline Date:&nbsp;<span class="compulsory">*</span>&nbsp;</td>
						<td align="left" valign="top">
							<?php if($objElectionDate->reg_deadline_date !="" ) { ?>
							<input class="input_text" type="text" name="reg_deadline_date" id="reg_deadline_date" value="<?php echo $cmn->convertFormtDate($objElectionDate->reg_deadline_date,"m/d/Y");?>" maxlength="50" readonly="readonly"/>
							<?php } else { ?>
							<input class="input_text" type="text" name="reg_deadline_date" id="reg_deadline_date" value="" maxlength="50" readonly="readonly"/>
							<?php } ?>
                        <img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('reg_deadline_date').focus();">
						</td>
					</tr>
					<?php for($i=0;$i<count($language);$i++){
						$styleDetail = '';
						$lableField = 'Registration Deadline Description:';								
						$sfn_value = $cmn->readValueDetail($objElectionDate->reg_deadline_description);
						
						if($language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
							$lableField = '&nbsp;';
							$sfn_value = "";
						}

						if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
						{
							$styleDetail = '';
							
							if(isset($_POST["reg_deadline_description_".$language[$i]['language_id']]))
							{
								$sfn_value = $cmn->readValueDetail($_POST["reg_deadline_description_".$language[$i]['language_id']]);
							}
							else
							{	
								if(isset($arrElectionDateLanguages[$language[$i]['language_id']]['reg_deadline_description']))
									$sfn_value = $cmn->readValueDetail($arrElectionDateLanguages[$language[$i]['language_id']]['reg_deadline_description']);
							}		
						}
						else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
						}
						else if(in_array($language[$i]['language_id'],$arrLanguages))
						{
							$styleDetail = '';
							
							if(isset($_POST["reg_deadline_description_".$language[$i]['language_id']]))
							{
								$sfn_value = $cmn->readValueDetail($_POST["reg_deadline_description_".$language[$i]['language_id']]);
							}
							else
							{										
								if(isset($arrElectionDateLanguages[$language[$i]['language_id']]['reg_deadline_description']))
									$sfn_value = $cmn->readValueDetail($arrElectionDateLanguages[$language[$i]['language_id']]['reg_deadline_description']);
							}		
						}	
					  ?>
					<tr class="row01"<?php echo $styleDetail?> id="regdeadlinedescription_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>&nbsp;</td>
						<td align="left" valign="top">
							<textarea name="reg_deadline_description_<?PHP echo $language[$i]['language_id']; ?>" id="reg_deadline_description_<?PHP echo $language[$i]['language_id']; ?>" rows="3" cols="37"><?PHP echo $sfn_value; ?></textarea>	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px; vertical-align:top;" align="abs-top" /></td>
					</tr>
					<?php } ?>					
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
							<input  class="input_text" type="hidden" name="election_date_id" id="election_date_id" value="<?php echo $objElectionDate->election_date_id;?>" />							
							<input  type="hidden" name="hdndefaultlanguage_id" id="hdndefaultlanguage_id" value="<?php echo $objElectionDate->defaultlanguage_id; ?>"/>
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('#election_date').datepicker({
    });
	jQuery('#reg_deadline_date').datepicker({
    });
});
</script>
