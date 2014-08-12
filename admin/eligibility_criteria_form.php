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
					  $arrLanguages = $objEligCrit->fetchEligibilityCriteriaLanguage();			  
					  $arrECLanguages = $objEligCrit->fetchEligibilityCriteriaLanguageDetail();
					  
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
					<?php for($i=0;$i<count($language);$i++) {
								$styleDetail = '';
								$lableField = 'Eligibility Criteria:'.COMPULSORY_FIELD;								
								$eligibility_criteria_value = $cmn->readValueDetail($objEligCrit->eligibility_criteria);
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$eligibility_criteria_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["eligibility_criteria_".$language[$i]['language_id']]))
									{
										$eligibility_criteria_value = $cmn->readValueDetail($_POST["eligibility_criteria_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrECLanguages[$language[$i]['language_id']]['eligibility_criteria']))
											$eligibility_criteria_value = $cmn->readValueDetail($arrECLanguages[$language[$i]['language_id']]['eligibility_criteria']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["eligibility_criteria_".$language[$i]['language_id']]))
									{
										$eligibility_criteria_value = $cmn->readValueDetail($_POST["eligibility_criteria_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrECLanguages[$language[$i]['language_id']]['eligibility_criteria']))
											$eligibility_criteria_value = $cmn->readValueDetail($arrECLanguages[$language[$i]['language_id']]['eligibility_criteria']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="eligibilitycriteria_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<!--<input  class="input_text" type="text" name="eligibility_criteria_<?php echo $language[$i]['language_id']?>" value="<?php echo ($eligibility_criteria_value)?>" id="eligibility_criteria_<?php echo $language[$i]['language_id']?>"  />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />	-->
<textarea rows="5" cols="50"  name="eligibility_criteria_<?php echo $language[$i]['language_id']?>" id="eligibility_criteria_<?php echo $language[$i]['language_id']?>" ><?php echo ($eligibility_criteria_value)?></textarea>&nbsp;<img alt="<?php echo $language[$i]['language_name']?>" title="<?php echo $language[$i]['language_name']?>" src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px; vertical-align:top;" />
							
							
							
							</td>
					</tr>
					<?php }?>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Default for all states:						</td>
			
						<td align="left" valign="top">							
							<label><input  type="radio" name="for_all_state" class="radio" value="1" <?php ($objEligCrit->for_all_state==1) ? print 'checked="checked"' : '' ?> />Yes</label>
							<label><input  type="radio" name="for_all_state" class="radio" value="0" <?php ($objEligCrit->for_all_state==0) ? print 'checked="checked"' : '' ?> />No</label>							
													</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Active:						</td>
			
						<td align="left" valign="top">							
							<label><input  type="radio" name="eligibility_active" class="radio" value="1" <?php ($objEligCrit->eligibility_active==1) ? print 'checked="checked"' : '' ?> />Yes</label>
							<label><input  type="radio" name="eligibility_active" class="radio" value="0" <?php ($objEligCrit->eligibility_active==0) ? print 'checked="checked"' : '' ?> />No</label>							
													</td>
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
							<input  class="input_text" type="hidden" name="eligibility_criteria_id" id="eligibility_criteria_id" value="<?php echo $objEligCrit->eligibility_criteria_id;?>" />							
							<input  type="hidden" name="hdndefaultlanguage_id" id="hdndefaultlanguage_id" value="<?php echo $objEligCrit->defaultlanguage_id; ?>"/>
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>