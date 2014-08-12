<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validate();">
	<input  class="input_text" type="hidden" name="seluser_type_id" id="seluser_type_id" value="2" />
	<table cellpadding="0" cellspacing="0" width="100%" class="listtab">

		<tr class="row4">
			<td align="left" width="20%" class="listtab-td">
				<strong>Username:&nbsp;</strong>
			</td>

			<td class="listtab-td-rt">
				<input type="text" name="txtuser_username" autocomplete="off" id="txtuser_username" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_username); ?>" class="listtab-input" /> <span class="red">*</span>
			</td>

		</tr>

		<tr class="row4">
			<td align="left" width="20%" class="listtab-td">
				<strong>Password:&nbsp;</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="password" name="user_password" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_password); ?>" id="user_password" /> <span class="red">*</span>
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Confirm Password:&nbsp;</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="password" name="user_confirmpassword" id="user_confirmpassword" value="<?php echo $cmn->readValueDetail($confirmPassword); ?>" /> <span class="red">*</span>
			</td>

		</tr>
		
		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>First Name:&nbsp;</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_firstname" id="txtuser_firstname" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_firstname); ?>" /> <span class="red">*</span>
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Last Name:&nbsp;</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_lastname" id="txtuser_lastname" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_lastname); ?>" /> <span class="red">*</span>
			</td>

		</tr>
		
		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Designation:&nbsp;</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_designation" id="txtuser_designation" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_designation); ?>" /> <span class="red">*</span>
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Email:&nbsp;</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_email" id="txtuser_email" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_email); ?>" /> <span class="red">*</span>
			</td>

		</tr>

		

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Phone:</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_phone" id="txtuser_phone" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_phone); ?>" />
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Address1:</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_address1" id="txtuser_address1" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_address1); ?>" />
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Address2:</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_address2" id="txtuser_address2" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_address2); ?>" />
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>City:</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_city" id="txtuser_city" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_city); ?>" />
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>State:</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_state" id="txtuser_state" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_state); ?>" />
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Zip Code:</strong>
			</td>

			<td class="listtab-td-rt">
				<input  class="listtab-input" type="text" name="txtuser_zipcode" id="txtuser_zipcode" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_zipcode); ?>" />
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Country:</strong>
			</td>

			<td class="listtab-td-rt">
				<?php echo $cmn->getContryArray($objClientAdmin->user_country) ?>
			</td>

		</tr>

		
		<tr class="row4">
			<td align="left" class="listtab-td" width="20%">
				<strong>Active:</strong>
			</td>

			<td class="listtab-td-rt">
				<?php if(isset($currentuserID) && $currentuserID == $objClientAdmin->user_id) { ?>
				<label>Yes <input  type="hidden" name="rdouser_isactive" id="rdouser_isactive" class="radio" value="1" /></label>
				<?php } else { ?>
				<label><input  type="radio" name="rdouser_isactive" id="rdouser_isactive" class="radio" value="1" <?php ($objClientAdmin->user_isactive==1) ? print 'checked="checked"' : '' ?> />Yes</label>
		<label><input  type="radio" name="rdouser_isactive" id="rdouser_isactive" class="radio" value="0" <?php ($objClientAdmin->user_isactive==0) ? print 'checked="checked"' : '' ?> />No</label>
				<?php } ?>
			</td>

		</tr>

		<tr class="row4">
			<td align="left" class="listtab-td-last">&nbsp;
			</td>
			<td align="left" class="listtab-td-rt">
				<input  type="submit" title="Save" class="btn" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" name="btncanel" title="Cancel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
				<input  type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>"/>
				<input  type="hidden" name="hdnuser_id" id="hdnuser_id" value="<?php echo $objEncDec->encrypt($objClientAdmin->user_id); ?>"/>
                <input  type="hidden" name="hdnclient_id" id="hdnclient_id" value="<?php echo $objClientAdmin->client_id; ?>"/>
				<input  type="hidden" name="seluser_type_id" id="seluser_type_id" value="<?php echo $objClientAdmin->user_type_id; ?>"/>
			</td>

		</tr>

	</table>
</form>