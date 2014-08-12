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
					  $arrLanguages = $objstate->fetchStateLanguage();			  
					  $arrStateLanguages = $objstate->fetchStateLanguageDetail();
					  
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
						<td align="left" valign="top" width="18%" class="txtbo">State Code:</td>
						<td align="left" valign="top"><strong><?php echo $objstate->state_code;?></strong>
							<input class="input_text" type="hidden" name="state_code" id="state_code" value="<?php echo $objstate->state_code;?>" maxlength="50"/>
						</td>
					  </tr>
					<?php for($i=0;$i<count($language);$i++) {
								$styleDetail = '';
								$lableField = 'State Name:'.COMPULSORY_FIELD;								
								$state_name_value = $cmn->readValueDetail($objstate->state_name);
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$state_name_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["state_name_".$language[$i]['language_id']]))
									{
										$state_name_value = $cmn->readValueDetail($_POST["state_name_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrStateLanguages[$language[$i]['language_id']]['state_name']))
											$state_name_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_name']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["state_name_".$language[$i]['language_id']]))
									{
										$state_name_value = $cmn->readValueDetail($_POST["state_name_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrStateLanguages[$language[$i]['language_id']]['state_name']))
											$state_name_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_name']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="statename_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="state_name_<?php echo $language[$i]['language_id']?>" value="<?php echo $state_name_value?>" id="state_name_<?php echo $language[$i]['language_id']?>" maxlength="50" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php }?>
					<?php for($i=0;$i<count($language);$i++){
						$styleDetail = '';
						$lableField = 'Secretary First Name:';								
						$sfn_value = $cmn->readValueDetail($objstate->state_secretary_fname);
						
						if($language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
							$lableField = '&nbsp;';
							$sfn_value = "";
						}

						if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_secretary_fname_".$language[$i]['language_id']]))
							{
								$sfn_value = $cmn->readValueDetail($_POST["state_secretary_fname_".$language[$i]['language_id']]);
							}
							else
							{	
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_secretary_fname']))
									$sfn_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_secretary_fname']);
							}		
						}
						else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
						}
						else if(in_array($language[$i]['language_id'],$arrLanguages))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_secretary_fname_".$language[$i]['language_id']]))
							{
								$sfn_value = $cmn->readValueDetail($_POST["state_secretary_fname_".$language[$i]['language_id']]);
							}
							else
							{										
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_secretary_fname']))
									$sfn_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_secretary_fname']);
							}		
						}	
					  ?>
					<tr class="row01"<?php echo $styleDetail?> id="fname_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="state_secretary_fname_<?php echo $language[$i]['language_id']?>" id="state_secretary_fname"  maxlength="50" value="<?php echo $sfn_value?>" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php } 
					for($i=0;$i<count($language);$i++){
						$styleDetail = '';
						$lableField = 'Secretary Middle Name:';								
						$sln_value = $cmn->readValueDetail($objstate->state_secretary_mname);
						
						if($language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
							$lableField = '&nbsp;';
							$sln_value = "";
						}

						if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_secretary_mname_".$language[$i]['language_id']]))
							{
								$sln_value = $cmn->readValueDetail($_POST["state_secretary_mname_".$language[$i]['language_id']]);
							}
							else
							{	
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_secretary_mname']))
									$sln_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_secretary_mname']);
							}		
						}
						else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
						}
						else if(in_array($language[$i]['language_id'],$arrLanguages))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_secretary_mname_".$language[$i]['language_id']]))
							{
								$sln_value = $cmn->readValueDetail($_POST["state_secretary_mname_".$language[$i]['language_id']]);
							}
							else
							{										
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_secretary_mname']))
									$sln_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_secretary_mname']);
							}		
						}	
					  ?>
					<tr class="row01"<?php echo $styleDetail?> id="mname_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="state_secretary_mname_<?php echo $language[$i]['language_id']?>" id="state_secretary_mname"  maxlength="50" value="<?php echo $sln_value?>" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php }
					for($i=0;$i<count($language);$i++){
						$styleDetail = '';
						$lableField = 'Secretary Last  Name:';								
						$smn_value = $cmn->readValueDetail($objstate->state_secretary_lname);
						
						if($language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
							$lableField = '&nbsp;';
							$smn_value = "";
						}

						if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_secretary_lname_".$language[$i]['language_id']]))
							{
								$smn_value = $cmn->readValueDetail($_POST["state_secretary_lname_".$language[$i]['language_id']]);
							}
							else
							{	
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_secretary_lname']))
									$smn_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_secretary_lname']);
							}		
						}
						else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
						}
						else if(in_array($language[$i]['language_id'],$arrLanguages))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_secretary_lname_".$language[$i]['language_id']]))
							{
								$smn_value = $cmn->readValueDetail($_POST["state_secretary_lname_".$language[$i]['language_id']]);
							}
							else
							{										
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_secretary_lname']))
									$smn_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_secretary_lname']);
							}		
						}	
					  ?>
					<tr class="row01"<?php echo $styleDetail?> id="lname_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="state_secretary_lname_<?php echo $language[$i]['language_id']?>" id="state_secretary_lname"  maxlength="50" value="<?php echo $smn_value?>" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php }
					for($i=0;$i<count($language);$i++){
						$styleDetail = '';
						$lableField = 'Secretary Address:';								
						$address1_value = $cmn->readValueDetail($objstate->state_address1);
						
						if($language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
							$lableField = '&nbsp;';
							$address1_value = "";
						}

						if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_secretary_fname_".$language[$i]['language_id']]))
							{
								$address1_value = $cmn->readValueDetail($_POST["state_secretary_fname_".$language[$i]['language_id']]);
							}
							else
							{	
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_address1']))
									$address1_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_address1']);
							}		
						}
						else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
						}
						else if(in_array($language[$i]['language_id'],$arrLanguages))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_address1_".$language[$i]['language_id']]))
							{
								$address1_value = $cmn->readValueDetail($_POST["state_address1_".$language[$i]['language_id']]);
							}
							else
							{										
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_address1']))
									$address1_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_address1']);
							}		
						}	
					  ?>
					<tr class="row01"<?php echo $styleDetail?> id="address1_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="state_address1_<?php echo $language[$i]['language_id']?>" id="state_address1"  maxlength="50" value="<?php echo $address1_value?>" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php }
					for($i=0;$i<count($language);$i++){
						$styleDetail = '';
						$lableField = 'Secretary Address2:';								
						$address2_value = $cmn->readValueDetail($objstate->state_address2);
						
						if($language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
							$lableField = '&nbsp;';
							$address2_value = "";
						}

						if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_address2_".$language[$i]['language_id']]))
							{
								$address2_value = $cmn->readValueDetail($_POST["state_address2_".$language[$i]['language_id']]);
							}
							else
							{	
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_address2']))
									$address2_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_address2']);
							}		
						}
						else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
						}
						else if(in_array($language[$i]['language_id'],$arrLanguages))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_address2_".$language[$i]['language_id']]))
							{
								$address2_value = $cmn->readValueDetail($_POST["state_address2_".$language[$i]['language_id']]);
							}
							else
							{										
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_address2']))
									$address2_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_address2']);
							}		
						}	
					  ?>
					<tr class="row01"<?php echo $styleDetail?> id="address2_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="state_address2_<?php echo $language[$i]['language_id']?>" id="state_address2"  maxlength="50" value="<?php echo $address2_value?>" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php }
					for($i=0;$i<count($language);$i++){
						$styleDetail = '';
						$lableField = 'State City:';								
						$city_value = $cmn->readValueDetail($objstate->state_city);
						
						if($language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
							$lableField = '&nbsp;';
							$city_value = "";
						}

						if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_city_".$language[$i]['language_id']]))
							{
								$city_value = $cmn->readValueDetail($_POST["state_city_".$language[$i]['language_id']]);
							}
							else
							{	
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_city']))
									$city_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_city']);
							}		
						}
						else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
						{
							$styleDetail = 'style="display:none;"';
						}
						else if(in_array($language[$i]['language_id'],$arrLanguages))
						{
							$styleDetail = '';
							
							if(isset($_POST["state_city_".$language[$i]['language_id']]))
							{
								$city_value = $cmn->readValueDetail($_POST["state_city_".$language[$i]['language_id']]);
							}
							else
							{										
								if(isset($arrStateLanguages[$language[$i]['language_id']]['state_city']))
									$city_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_city']);
							}		
						}	
					  ?>
					<tr class="row01"<?php echo $styleDetail?> id="city_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="state_city_<?php echo $language[$i]['language_id']?>" id="state_city"  maxlength="50" value="<?php echo $city_value?>" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php } ?>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Zip Code: 			</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="zipcode" id="zipcode" value="<?php echo $objstate->zipcode;?>" maxlength="50" />
							</td>
					</tr>
					
					
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Hotline No.:						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="hotlineno" id="hotlineno" value="<?php echo $objstate->hotlineno;?>" maxlength="50" />
							</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Toll Free:						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="tollfree" id="tollfree" value="<?php echo $objstate->tollfree;?>" maxlength="50" />
							</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Phone No.:						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="phoneno" id="phoneno" value="<?php echo $objstate->phoneno;?>" maxlength="50" />
							</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">Fax No.:						</td>			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="faxno" id="faxno" value="<?php echo $objstate->faxno;?>" maxlength="50" />
						</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Email:</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="email" id="email" value="<?php echo $objstate->email;?>" maxlength="50" />
							
													</td>
					</tr>
			
					
					
					
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Active:						</td>
			
						<td align="left" valign="top">							
							<label><input  type="radio" name="state_active" class="radio" value="1" <?php ($objstate->state_active==1) ? print 'checked="checked"' : '' ?> />Yes</label>
							<label><input  type="radio" name="state_active" class="radio" value="0" <?php ($objstate->state_active==0) ? print 'checked="checked"' : '' ?> />No</label>							
													</td>
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
							<input  class="input_text" type="hidden" name="state_id" id="state_id" value="<?php echo $objstate->state_id;?>" />							
							<input  type="hidden" name="hdndefaultlanguage_id" id="hdndefaultlanguage_id" value="<?php echo $objstate->defaultlanguage_id; ?>"/>
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>