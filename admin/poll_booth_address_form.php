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
					  $arrLanguages = $objPollBooth->fetchPollBoothLanguage();			  
					  $arrPBLanguages = $objPollBooth->fetchPollBoothLanguageDetail();
					  
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
					  <td align="left" valign="top" class="txtbo">State: <span class="compulsory">*</span></td>
					  <td width="82%" align="left" valign="top">
					  <select name="selState" id="selState">
					  <option value="">Select State</option>
					  <?php for ($i=0;$i<count($arrState);$i++){ ?>
					  <option value="<?php echo $arrState[$i]['state_id'];?>" <?php if($arrState[$i]['state_id'] == $objPollBooth->state_id) { echo "selected";} ?>><?php echo $arrState[$i]['state_code'];?> - <?php echo $arrState[$i]['state_name'];?></option>
					  <?php } ?>
					  </select>
					  </td>
					</tr>
					<!-- <tr class="row01">
						<td align="left" valign="top" class="txtbo">Poll Booth For:</td>
						<td align="left" valign="top">			
							<label><input  type="radio" name="poll_booth_for" class="radio" value="1" <?php ($objPollBooth->poll_booth_for==1) ? print 'checked="checked"' : '' ?> />Voter Reg</label>
							<label><input  type="radio" name="poll_booth_for" class="radio" value="2" <?php ($objPollBooth->poll_booth_for==2) ? print 'checked="checked"' : '' ?> />Absentee</label></td>
					</tr>-->
					<input  type="hidden" name="poll_booth_for" value="1" />
					<input  type="hidden" name="poll_booth_country" value="" />
					<!-- <tr class="row01">
						<td align="left" valign="top" width="18%" class="txtbo">County:&nbsp;</td>
						<td align="left" valign="top">
							<input class="input_text" type="text" name="poll_booth_country" id="poll_booth_country" value="<?php echo $objPollBooth->poll_booth_country;?>" maxlength="50"/>
						</td>
					</tr>-->
					<?php for($i=0;$i<count($language);$i++) {
								$styleDetail = '';
								$lableField = 'Official Title:';								
								$official_title_value = $objPollBooth->official_title;
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$official_title_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["official_title_".$language[$i]['language_id']]))
									{
										$official_title_value = $cmn->readValueDetail($_POST["official_title_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrPBLanguages[$language[$i]['language_id']]['official_title']))
											$official_title_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['official_title']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["official_title_".$language[$i]['language_id']]))
									{
										$official_title_value = $cmn->readValueDetail($_POST["official_title_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrPBLanguages[$language[$i]['language_id']]['official_title']))
											$official_title_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['official_title']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="officialtitle_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="official_title_<?php echo $language[$i]['language_id']?>" value="<?php echo $official_title_value;?>" id="official_title_<?php echo $language[$i]['language_id']?>" maxlength="50" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php } 
					for($i=0;$i<count($language);$i++) {
								$styleDetail = '';
								$lableField = 'Building Name:';								
								$building_name_value = $objPollBooth->building_name;
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$building_name_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["building_name_".$language[$i]['language_id']]))
									{
										$building_name_value = $cmn->readValueDetail($_POST["building_name_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrPBLanguages[$language[$i]['language_id']]['building_name']))
											$building_name_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['building_name']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["building_name_".$language[$i]['language_id']]))
									{
										$building_name_value = $cmn->readValueDetail($_POST["building_name_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrPBLanguages[$language[$i]['language_id']]['building_name']))
											$building_name_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['building_name']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="buildingname_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="building_name_<?php echo $language[$i]['language_id']?>" value="<?php echo $building_name_value;?>" id="building_name_<?php echo $language[$i]['language_id']?>" maxlength="50" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php } for($i=0;$i<count($language);$i++) {
								$styleDetail = '';
								$lableField = 'Address1:'.COMPULSORY_FIELD;								
								$poll_booth_address1_value = $objPollBooth->poll_booth_address1;
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$poll_booth_address1_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["poll_booth_address1_".$language[$i]['language_id']]))
									{
										$poll_booth_address1_value = $cmn->readValueDetail($_POST["poll_booth_address1_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address1']))
											$poll_booth_address1_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address1']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["poll_booth_address1_".$language[$i]['language_id']]))
									{
										$poll_booth_address1_value = $cmn->readValueDetail($_POST["poll_booth_address1_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address1']))
											$poll_booth_address1_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address1']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="pollboothaddress1_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="poll_booth_address1_<?php echo $language[$i]['language_id']?>" value="<?php echo $poll_booth_address1_value;?>" id="poll_booth_address1_<?php echo $language[$i]['language_id']?>" maxlength="50" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php } ?>
					<?php for($i=0;$i<count($language);$i++) {
								$styleDetail = '';
								$lableField = 'Address2:';								
								$poll_booth_address2_value = $objPollBooth->poll_booth_address2;
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$poll_booth_address2_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["poll_booth_address2_".$language[$i]['language_id']]))
									{
										$poll_booth_address2_value = $cmn->readValueDetail($_POST["poll_booth_address2_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address2']))
											$poll_booth_address2_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address2']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["poll_booth_address2_".$language[$i]['language_id']]))
									{
										$poll_booth_address2_value = $cmn->readValueDetail($_POST["poll_booth_address2_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address2']))
											$poll_booth_address2_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address2']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="pollboothaddress2_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="poll_booth_address2_<?php echo $language[$i]['language_id']?>" value="<?php echo $poll_booth_address2_value;?>" id="poll_booth_address2_<?php echo $language[$i]['language_id']?>" maxlength="50" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php } ?>
					<?php for($i=0;$i<count($language);$i++) {
								$styleDetail = '';
								$lableField = 'City:'.COMPULSORY_FIELD;								
								$poll_booth_city_value = $objPollBooth->poll_booth_city;
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$poll_booth_city_value = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["poll_booth_city_".$language[$i]['language_id']]))
									{
										$poll_booth_city_value = $cmn->readValueDetail($_POST["poll_booth_city_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrPBLanguages[$language[$i]['language_id']]['poll_booth_city']))
											$poll_booth_city_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['poll_booth_city']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["poll_booth_city_".$language[$i]['language_id']]))
									{
										$poll_booth_city_value = $cmn->readValueDetail($_POST["poll_booth_city_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrPBLanguages[$language[$i]['language_id']]['poll_booth_city']))
											$poll_booth_city_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['poll_booth_city']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="pollboothcity_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="poll_booth_city_<?php echo $language[$i]['language_id']?>" value="<?php echo $poll_booth_city_value;?>" id="poll_booth_city_<?php echo $language[$i]['language_id']?>" maxlength="50" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php } ?>
					<tr class="row01">
						<td align="left" valign="top" width="18%" class="txtbo">Zip Code:&nbsp;</td>
						<td align="left" valign="top">
							<input class="input_text" type="text" name="poll_booth_zipcode" id="poll_booth_zipcode" value="<?php echo $objPollBooth->poll_booth_zipcode;?>" maxlength="50"/>
						</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" width="18%" class="txtbo">Phone No.:&nbsp;</td>
						<td align="left" valign="top">
							<input class="input_text" type="text" name="poll_booth_phone" id="poll_booth_phone" value="<?php echo $objPollBooth->poll_booth_phone;?>" maxlength="50"/>
						</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" width="18%" class="txtbo">Fax No.:&nbsp;</td>
						<td align="left" valign="top">
							<input class="input_text" type="text" name="poll_booth_fax" id="poll_booth_fax" value="<?php echo $objPollBooth->poll_booth_fax;?>" maxlength="50"/>
						</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" width="18%" class="txtbo">URL:&nbsp;</td>
						<td align="left" valign="top">
							<input class="input_text" type="text" name="url" id="url" value="<?php echo $objPollBooth->url;?>" maxlength="50"/>
						</td>
					</tr>					
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">Active:</td>
						<td align="left" valign="top">			
							<label><input  type="radio" name="poll_booth_active" class="radio" value="1" <?php ($objPollBooth->poll_booth_active==1) ? print 'checked="checked"' : '' ?> />Yes</label>
							<label><input  type="radio" name="poll_booth_active" class="radio" value="0" <?php ($objPollBooth->poll_booth_active==0) ? print 'checked="checked"' : '' ?> />No</label></td>
					</tr>  
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
							<input  class="input_text" type="hidden" name="poll_booth_id" id="poll_booth_id" value="<?php echo $objPollBooth->poll_booth_id;?>" />	
							<input  type="hidden" name="hdndefaultlanguage_id" id="hdndefaultlanguage_id" value="<?php echo $objPollBooth->defaultlanguage_id; ?>"/>	
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>