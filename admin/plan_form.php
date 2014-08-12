<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();" enctype="multipart/form-data">
	
	<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

		<tr class="row01">
			<td align="left" valign="top" class="txtbo" width="20%">
				Title:&nbsp;<?php print COMPULSORY_FIELD; ?>			</td>

			<td align="left" valign="top">
				<input  class="input_text_title" type="text" name="plan_title" id="plan_title" value="<?php echo htmlspecialchars($objPlan->plan_title); ?>" maxlength="100" />			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Description:			</td>
			<td align="left" valign="top">
				<textarea  class="input_desc_more" name="plan_description" id="plan_description"><?php echo htmlspecialchars($objPlan->plan_description); ?></textarea>			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Amount:&nbsp;<?php print COMPULSORY_FIELD; ?>			</td>
			<td align="left" valign="top">
				$<input class="input_small" type="text" name="plan_amount" id="plan_amount" value="<?php echo htmlspecialchars($objPlan->plan_amount); ?>" maxlength="5" />			</td>
		</tr>		
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Custom Domain:			</td>
			<td align="left" valign="top">
				<label><input  type="radio" name="custom_domain" id="custom_domain" class="radio" value="1" <?php ($objPlan->custom_domain==1) ? print 'checked="checked"' : '' ?> />Yes</label>
					<label><input  type="radio" name="custom_domain" id="custom_domain" class="radio" value="0" <?php ($objPlan->custom_domain==0) ? print 'checked="checked"' : '' ?> />No</label>			</td>
		</tr>
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Custom Field:			</td>
			<td align="left" valign="top">
				<label><input  type="radio" name="custom_field" id="custom_field" class="radio" value="1" <?php ($objPlan->custom_field==1) ? print 'checked="checked"' : '' ?> />Yes</label>
					<label><input  type="radio" name="custom_field" id="custom_field" class="radio" value="0" <?php ($objPlan->custom_field==0) ? print 'checked="checked"' : '' ?> />No</label>			</td>
		</tr>
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Custom Color:			</td>
			<td align="left" valign="top">
				<label><input  type="radio" name="custom_color" id="custom_color" class="radio" value="1" <?php ($objPlan->custom_color==1) ? print 'checked="checked"' : '' ?> />Yes</label>
				<label><input  type="radio" name="custom_color" id="custom_color" class="radio" value="0" <?php ($objPlan->custom_color==0) ? print 'checked="checked"' : '' ?> />No</label>			</td>
		</tr>
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">Download Data:			</td>
			<td align="left" valign="top">
				<label><input  type="radio" name="download_data" id="download_data" class="radio" value="1" <?php ($objPlan->download_data==1) ? print 'checked="checked"' : '' ?> />Yes</label>
				<label><input  type="radio" name="download_data" id="download_data" class="radio" value="0" <?php ($objPlan->download_data==0) ? print 'checked="checked"' : '' ?> />No</label>			</td>
		</tr>
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				FB Application:			</td>
			<td align="left" valign="top">
				<label><input  type="radio" name="FB_application" id="FB_application" class="radio" value="1" <?php ($objPlan->FB_application==1) ? print 'checked="checked"' : '' ?> />Yes</label>
				<label><input  type="radio" name="FB_application" id="FB_application" class="radio" value="0" <?php ($objPlan->FB_application==0) ? print 'checked="checked"' : '' ?> />No</label>			</td>
		</tr>
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				API Access:			</td>
			<td align="left" valign="top">
				<label><input type="radio" name="API_access" id="API_access" class="radio" value="1" <?php ($objPlan->API_access==1) ? print 'checked="checked"' : '' ?> />Yes</label>
				<label><input type="radio" name="API_access" id="API_access" class="radio" value="0" <?php ($objPlan->API_access==0) ? print 'checked="checked"' : '' ?> />No</label>			</td>
		</tr>		
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Publish:			</td>
			<td align="left" valign="top">
				<label><input  type="radio" name="plan_ispublish" id="plan_ispublish" class="radio" value="1" <?php ($objPlan->plan_ispublish==1) ? print 'checked="checked"' : '' ?> />Yes</label>
					<label><input  type="radio" name="plan_ispublish" id="plan_ispublish" class="radio" value="0" <?php ($objPlan->plan_ispublish==0) ? print 'checked="checked"' : '' ?> />No</label>			</td>
		</tr>
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Active:			</td>

			<td align="left" valign="top">
				<label><input  type="radio" name="plan_isactive" id="plan_isactive" class="radio" value="1" <?php ($objPlan->plan_isactive==1) ? print 'checked="checked"' : '' ?> />Yes</label>
				<label><input  type="radio" name="plan_isactive" id="plan_isactive" class="radio" value="0" <?php ($objPlan->plan_isactive==0) ? print 'checked="checked"' : '' ?> />No</label>			</td>
		</tr>
<tr class="row01">
			<td align="left" valign="top"  class="txtbo">&nbsp;			</td>
			<td align="left" valign="top" >
				<input  type="submit" class="btn" name="btnsave" title="Save" id="btnsave" value="Save"/>
				<input  type="button" name="btncanel" title="Cancel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnplan_id" id="hdnplan_id" value="<?php echo $objPlan->plan_id; ?>"/>			</td>
	  </tr>
	</table>
</form>