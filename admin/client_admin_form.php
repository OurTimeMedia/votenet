<table cellpadding="0" cellspacing="0" border="0" width="100%"> 
	<tr>
      <td>
      <div>
	  <?php if(count($arrPlan) > 0) { ?>
		<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();">
				<input  class="input_text" type="hidden" name="seluser_type_id" id="seluser_type_id" value="<?php echo $objClientAdmin->user_type_id; ?>" />
			      	<table class="listtab" cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;">
			
				
					<tr class="row01">
						<td align="left" valign="top" width="15%" class="txtbo">
							Username:&nbsp;<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" autocomplete="off" name="txtuser_username" id="txtuser_username" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_username)); ?>" maxlength="50" />
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Password:&nbsp;<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="password" name="user_password" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_password)); ?>" id="user_password" maxlength="50" />
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Confirm Password:&nbsp;<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="password" name="user_confirmpassword" id="user_confirmpassword"  maxlength="50" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_password)); ?>" />
						</td>
			
					</tr>
					
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							First Name:&nbsp;<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="txtuser_firstname" id="txtuser_firstname" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_firstname)); ?>" maxlength="50" />
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Last Name:&nbsp;<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="txtuser_lastname" id="txtuser_lastname" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_lastname)); ?>" maxlength="50" />
						</td>
			
					</tr>
					
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Company:&nbsp;<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="txtuser_company" id="txtuser_company" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_company)); ?>" maxlength="50" />
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Email:&nbsp;<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="txtuser_email" id="txtuser_email" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_email)); ?>" maxlength="100" />
						</td>
			
					</tr>
			
					
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Phone:
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="txtuser_phone" id="txtuser_phone" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_phone)); ?>" maxlength="25" />
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Address1:
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="txtuser_address1" id="txtuser_address1" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_address1)); ?>" maxlength="200" />
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Address2:
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="txtuser_address2" id="txtuser_address2" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_address2)); ?>" maxlength="200" />
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							City:
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="txtuser_city" id="txtuser_city" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_city)); ?>" maxlength="50" />
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							State:
						</td>
			
						<td align="left" valign="top">
							<input  class="input_text" type="text" name="txtuser_state" id="txtuser_state" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_state)); ?>" maxlength="50" />
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Country:
						</td>
			
						<td align="left" valign="top">
							<?php echo $cmn->getContryArray($objClientAdmin->user_country) ?>
						</td>
			
					</tr>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo" >
							Languages:&nbsp;<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">
							<label>
								<table cellpadding="0" cellspacing="0" border="0" width="80%" style="clear:both;">
							  <?php
								$clientLanguages = array();
								
								$clientLanguages = explode(",",$objClientAdmin->languages);
															  
								for($i=0;$i<count($language);$i++)
								{
									$checked='';
									$disabled ='';
									if($language[$i]['language_id']==1)
									{
											$checked = 'checked';
											$disabled = 'disabled="disabled"';
									}
									
									if(in_array($language[$i]['language_id'],$clientLanguages))
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
							  </table>
							</label>	
						</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo" >
							Plan:&nbsp;<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">
							<label>
								<select name="selPlan" id="selPlan">
								  <option value="">Select Plan</option>
								  <?php for ($i=0;$i<count($arrPlan);$i++){ ?>
								  <option value="<?php echo $arrPlan[$i]['plan_id'];?>" <?php if($arrPlan[$i]['plan_id'] == $objClientAdmin->plan_id) { echo "selected";} ?>><?php echo $arrPlan[$i]['plan_title'];?></option>
								  <?php } ?>
							    </select>
							</label>	
						</td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Expiry Date:<?php print COMPULSORY_FIELD; ?>
						</td>
			
						<td align="left" valign="top">			
							<?php if($objClientAdmin->expiry_date != "") { ?>	
							<input class="input_text" type="text" name="txtexpiry_date" id="txtexpiry_date" value="<?php echo $cmn->convertFormtDate($objClientAdmin->expiry_date,"m/d/Y");?>" maxlength="50" readonly="readonly"/>
							<?php } else { ?>
							<input class="input_text" type="text" name="txtexpiry_date" id="txtexpiry_date" value="" maxlength="50" readonly="readonly"/>
							<?php } ?>
							<img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtexpiry_date').focus();">
						</td>
			
					</tr>
					
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Allow Credit:
						</td>
			
						<td align="left" valign="top">
							<label><input  type="radio" name="rdoallow_credit" id="rdoallow_credit" class="radio" value="1" <?php ($objClientAdmin->allow_credit==1) ? print 'checked="checked"' : '' ?> />Yes</label>
					<label><input  type="radio" name="rdoallow_credit" id="rdoallow_credit" class="radio" value="0" <?php ($objClientAdmin->allow_credit==0) ? print 'checked="checked"' : '' ?> />No</label>	
						</td>
					</tr>
					
					<tr class="row01">
						<td align="left" valign="top" class="txtbo">
							Active:
						</td>
			
						<td align="left" valign="top">
							<label><input  type="radio" name="rdouser_isactive" id="rdouser_isactive" class="radio" value="1" <?php ($objClientAdmin->user_isactive==1) ? print 'checked="checked"' : '' ?> />Yes</label>
					<label><input  type="radio" name="rdouser_isactive" id="rdouser_isactive" class="radio" value="0" <?php ($objClientAdmin->user_isactive==0) ? print 'checked="checked"' : '' ?> />No</label>
							
						</td>
			
					</tr>
			
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;
						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
							<input  type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>"/>
							<input  type="hidden" name="hdnclient_id" id="hdnclient_id" value="<?php echo $objClientAdmin->client_id; ?>"/>
							<input  type="hidden" name="hdnuser_id" id="hdnuser_id" value="<?php echo $objClientAdmin->user_id; ?>"/>
                            <input  type="hidden" name="hdnuser_zipcode" id="hdnuser_zipcode" value="<?php echo $objClientAdmin->user_zipcode; ?>"/>
						</td>
					</tr>
				</table>
				<input type="hidden" value="<?php echo $objClientAdmin->plan_id; ?>" name="currentplan" id="currentplan">
				<?php if($objClientAdmin->expiry_date != "") { ?>
				<input type="hidden" value="<?php echo $cmn->convertFormtDate($objClientAdmin->expiry_date,"m/d/Y");?>" name="currentExpiry" id="currentExpiry">
				<?php } else { ?>
				<input type="hidden" value="" name="currentExpiry" id="currentExpiry">
				<?php } ?>
			</form>
		<?php } else { ?>	
		<table class="listtab" cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;">
			<tr class="row01">
				<td align="center" valign="top" width="100%" class="txtbo">There isn't any plan available. Please add plan details.</td>
			</tr>
		</table>			
		<?php } ?>
			</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('#txtexpiry_date').datepicker({minDate: new Date(<?php echo date("Y");?>, <?php echo date("m");?>, <?php echo date("d");?>)
    });	
});
</script>
