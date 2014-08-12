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
					  $arrLanguages = $objparty->fetchPartyLanguage();			  
					  $arrPartyLanguages = $objparty->fetchPartyLanguageDetail();
					  
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
								$lableField = 'Party Name:'.COMPULSORY_FIELD;								
								$party_name_value = $cmn->readValueDetail($objparty->party_name);
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$party_name_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["party_name_".$language[$i]['language_id']]))
									{
										$party_name_value = $cmn->readValueDetail($_POST["party_name_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrPartyLanguages[$language[$i]['language_id']]['party_name']))
											$party_name_value = $cmn->readValueDetail($arrPartyLanguages[$language[$i]['language_id']]['party_name']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["party_name_".$language[$i]['language_id']]))
									{
										$party_name_value = $cmn->readValueDetail($_POST["party_name_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrPartyLanguages[$language[$i]['language_id']]['party_name']))
											$party_name_value = $cmn->readValueDetail($arrPartyLanguages[$language[$i]['language_id']]['party_name']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="partyname_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="party_name_<?php echo $language[$i]['language_id']?>" value="<?php echo $party_name_value?>" id="party_name_<?php echo $language[$i]['language_id']?>" maxlength="50" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php }?>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Active:						</td>
			
						<td align="left" valign="top">							
							<label><input  type="radio" name="party_active" class="radio" value="1" <?php ($objparty->party_active==1) ? print 'checked="checked"' : '' ?> />Yes</label>
							<label><input  type="radio" name="party_active" class="radio" value="0" <?php ($objparty->party_active==0) ? print 'checked="checked"' : '' ?> />No</label>							
													</td>
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
							<input  class="input_text" type="hidden" name="party_id" id="party_id" value="<?php echo $objparty->party_id;?>" />							
							<input  type="hidden" name="hdndefaultlanguage_id" id="hdndefaultlanguage_id" value="<?php echo $objparty->defaultlanguage_id; ?>"/>
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>