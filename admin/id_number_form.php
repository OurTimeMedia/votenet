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
					  $arrLanguages = $objid_number->fetchIdNumberLanguage();			  
					  $arrIdNumberLanguages = $objid_number->fetchIdNumberLanguageDetail();
					  
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
								$lableField = 'ID Number Name:'.COMPULSORY_FIELD;								
								$id_number_name_value = $cmn->readValueDetail($objid_number->id_number_name);
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$id_number_name_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["id_number_name_".$language[$i]['language_id']]))
									{
										$id_number_name_value = $cmn->readValueDetail($_POST["id_number_name_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrIdNumberLanguages[$language[$i]['language_id']]['id_number_name']))
											$id_number_name_value = $cmn->readValueDetail($arrIdNumberLanguages[$language[$i]['language_id']]['id_number_name']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["id_number_name_".$language[$i]['language_id']]))
									{
										$id_number_name_value = $cmn->readValueDetail($_POST["id_number_name_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrIdNumberLanguages[$language[$i]['language_id']]['id_number_name']))
											$id_number_name_value = $cmn->readValueDetail($arrIdNumberLanguages[$language[$i]['language_id']]['id_number_name']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="id_numbername_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="id_number_name_<?php echo $language[$i]['language_id']?>" value="<?php echo $id_number_name_value?>" id="id_number_name_<?php echo $language[$i]['language_id']?>" maxlength="50" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php } 
					if($objid_number->id_number_length == 0)
						$objid_number->id_number_length = "";					
					?>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">Max Length:</td>			
						<td align="left" valign="top"><input  class="input_text" type="text" name="id_number_length" value="<?php echo $objid_number->id_number_length?>" id="id_number_length" maxlength="3" /></td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Active:						</td>
			
						<td align="left" valign="top">							
							<label><input  type="radio" name="id_number_active" class="radio" value="1" <?php ($objid_number->id_number_active==1) ? print 'checked="checked"' : '' ?> />Yes</label>
							<label><input  type="radio" name="id_number_active" class="radio" value="0" <?php ($objid_number->id_number_active==0) ? print 'checked="checked"' : '' ?> />No</label>							
													</td>
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
							<input  class="input_text" type="hidden" name="id_number_id" id="id_number_id" value="<?php echo $objid_number->id_number_id;?>" />							
							<input  type="hidden" name="hdndefaultlanguage_id" id="hdndefaultlanguage_id" value="<?php echo $objid_number->defaultlanguage_id; ?>"/>
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>