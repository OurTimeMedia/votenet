<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();">
	<input  class="input_text" type="hidden" name="seluser_type_id" id="seluser_type_id" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_type_id)); ?>" />
	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="listtab">

		<tr class="row01">
			<td align="left" valign="top" width="15%" class="txtbo">
				Username:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" autocomplete="off" name="txtuser_username" id="txtuser_username" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_username)); ?>" maxlength="50" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Password:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="password" name="user_password" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_password)); ?>" id="user_password" maxlength="50" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Confirm Password:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="password" name="user_confirmpassword" id="user_confirmpassword"  maxlength="50" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_password)); ?>" />
			</td>

		</tr>
		
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				First Name:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser_firstname" id="txtuser_firstname" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_firstname)); ?>" maxlength="50" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Last Name:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser_lastname" id="txtuser_lastname" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_lastname)); ?>" maxlength="50" />
			</td>

		</tr>
		
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Designation:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser_designation" id="txtuser_designation" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_designation)); ?>" maxlength="50" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Email:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser_email" id="txtuser_email" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_email)); ?>" maxlength="100" />
			</td>

		</tr>

		

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Phone:
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser_phone" id="txtuser_phone" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_phone)); ?>" maxlength="25" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Address1:
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser_address1" id="txtuser_address1" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_address1)); ?>" maxlength="200" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Address2:
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser_address2" id="txtuser_address2" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_address2)); ?>" maxlength="200" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				City:
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser_city" id="txtuser_city" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_city)); ?>" maxlength="50" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				State:
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser_state" id="txtuser_state" value="<?php echo htmlspecialchars($cmn->readValue($objSystemAdmin->user_state)); ?>" maxlength="50" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Country:
			</td>

			<td align="left" valign="top">
				<?php echo $cmn->getContryArray($objSystemAdmin->user_country) ?>
			</td>

		</tr>

		
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Active:
			</td>

			<td align="left" valign="top">
			<?php if($objSystemAdmin->user_id!=USER_TYPE_SUPER_SYSTEM_ADMIN) { ?>
				<label><input  type="radio" name="rdouser_isactive" id="rdouser_isactive" class="radio" value="1" <?php ($objSystemAdmin->user_isactive==1) ? print 'checked="checked"' : '' ?> />Yes</label>
		<label><input  type="radio" name="rdouser_isactive" id="rdouser_isactive" class="radio" value="0" <?php ($objSystemAdmin->user_isactive==0) ? print 'checked="checked"' : '' ?> />No</label>
			<?php } else { ?>
				<strong>Yes</strong> <input type="hidden" name="rdouser_isactive" value="1" id="rdouser_isactive">
			<?php } ?>				
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" >&nbsp;
			</td>
			<td align="left" valign="top" >
				<input  type="submit" title="Save" class="btn" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" name="btncanel" title="Cancel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
				<input  type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>"/>
				<input  type="hidden" name="hdnuser_id" id="hdnuser_id" value="<?php echo $objSystemAdmin->user_id; ?>"/>
				
			</td>

		</tr>

	</table>
</form>