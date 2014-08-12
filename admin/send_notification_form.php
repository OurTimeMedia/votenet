<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();" enctype="multipart/form-data">
	
	<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

		<tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo">
				Title/Subject Line:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text_title" type="text" name="txtnotification_title" id="txtnotification_title" value="<?php echo htmlspecialchars($objSendNotification->notification_title); ?>" maxlength="200" />
			</td>

		</tr>
        
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Message:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				
                <textarea name="txtnotification_body" id="txtnotification_body" class="mceEditor" rows="18" cols="91">
                <?php print $objSendNotification->notification_body; ?>
                </textarea>
			</td>

		</tr>
        
        <!-- <tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Message Type:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<select name="selnotification_type" id="selnotification_type" class="input_text">
                <option value="">Select Message Type</option>
                <option value="0">Email</option>
                <option value="1">Dashboard-header</option>
                <option value="2">Both</option>
                </select>
			</td>

		</tr>-->
		<input type="hidden" name="selnotification_type" id="selnotification_type" value="0">
        
         <tr class="row01">
			<td align="left" valign="top" class="txtbo">
				User Type:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<select name="selnotification_user_type[]" id="selnotification_user_type" multiple="multiple" onchange="return selectAllCmbVal(this);" class="input_text">
                <option value="2">System Admin</option>
				<option value="3">Super Client Admin</option>
                <option value="4">Client Admin</option>                
                </select>
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				User Names:&nbsp;
			</td>

			<td align="left" valign="top">
				<textarea class="input_desc" name="txtnotification_usernames" id="txtnotification_usernames"><?php echo htmlspecialchars($objSendNotification->notification_usernames); ?></textarea><br />
                &nbsp;Enter Comma Separated Usernames
                <textarea class="input_desc" name="definedUsers" id="definedUsers" style="display:none;"><?php echo htmlspecialchars($userNames); ?></textarea>
                
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Send Date:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text_small" type="text" name="txtnotification_send_date" id="txtnotification_send_date" value="<?php echo htmlspecialchars($objSendNotification->notification_send_date); ?>" maxlength="50" readonly="readonly"/>
                <img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtnotification_send_date').focus();" alt="Calender" title="Calender">                
			</td>

		</tr>
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Active:
			</td>

			<td align="left" valign="top">
				<label><input  type="radio" name="rdonotification_isactive" id="rdonotification_isactive" class="radio" value="1" <?php ($objSendNotification->notification_isactive==1) ? print 'checked="checked"' : '' ?> />Yes</label>
				<label><input  type="radio" name="rdonotification_isactive" id="rdonotification_isactive" class="radio" value="0" <?php ($objSendNotification->notification_isactive==0) ? print 'checked="checked"' : '' ?> />No</label>
			</td>

		</tr>
	
		<tr class="row01">
			<td align="left" valign="top"  class="txtbo">&nbsp;
			</td>
			<td align="left" valign="top" >
				<input  type="submit" class="btn" title="Save" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnnotification_id" id="hdnnotification_id" value="<?php echo $objSendNotification->notification_id; ?>"/>
			</td>
		</tr>
	</table>
</form>