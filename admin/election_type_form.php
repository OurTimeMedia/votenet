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
					  $arrLanguages = $objelection_type->fetchElectionTypeLanguage();			  
					  $arrElectionTypeLanguages = $objelection_type->fetchElectionTypeLanguageDetail();
					  
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
								$lableField = 'Election Type Name:'.COMPULSORY_FIELD;								
								$election_type_name_value = $cmn->readValueDetail($objelection_type->election_type_name);
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$election_type_name_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["election_type_name_".$language[$i]['language_id']]))
									{
										$election_type_name_value = $cmn->readValueDetail($_POST["election_type_name_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrElectionTypeLanguages[$language[$i]['language_id']]['election_type_name']))
											$election_type_name_value = $cmn->readValueDetail($arrElectionTypeLanguages[$language[$i]['language_id']]['election_type_name']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["election_type_name_".$language[$i]['language_id']]))
									{
										$election_type_name_value = $cmn->readValueDetail($_POST["election_type_name_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrElectionTypeLanguages[$language[$i]['language_id']]['election_type_name']))
											$election_type_name_value = $cmn->readValueDetail($arrElectionTypeLanguages[$language[$i]['language_id']]['election_type_name']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="election_typename_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="election_type_name_<?php echo $language[$i]['language_id']?>" value="<?php echo $election_type_name_value?>" id="election_type_name_<?php echo $language[$i]['language_id']?>" maxlength="50" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php }?>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Active:						</td>
			
						<td align="left" valign="top">							
							<label><input  type="radio" name="election_type_active" class="radio" value="1" <?php ($objelection_type->election_type_active==1) ? print 'checked="checked"' : '' ?> />Yes</label>
							<label><input  type="radio" name="election_type_active" class="radio" value="0" <?php ($objelection_type->election_type_active==0) ? print 'checked="checked"' : '' ?> />No</label>							
													</td>
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
							<input  class="input_text" type="hidden" name="election_type_id" id="election_type_id" value="<?php echo $objelection_type->election_type_id;?>" />							
							<input  type="hidden" name="hdndefaultlanguage_id" id="hdndefaultlanguage_id" value="<?php echo $objelection_type->defaultlanguage_id; ?>"/>
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>