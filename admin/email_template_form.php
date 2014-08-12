<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();" enctype="multipart/form-data">
	
	<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

		<tr class="row01" >
			<td align="left" valign="top" class="txtbo" width="20%">
				Name of Email Template:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text_title" type="text" name="txtemail_templates_name" id="txtemail_templates_name" value="<?php echo htmlspecialchars($objEmaiTemplates->email_templates_name); ?>" maxlength="200" />
			</td>

		</tr>
		<tr class="row01" >
			<td align="left" valign="top" class="txtbo" width="20%">
				Subject:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text_title" type="text" name="txtemail_subject" id="txtemail_subject" value="<?php echo htmlspecialchars($objEmaiTemplates->email_subject); ?>" maxlength="200" />
			</td>

		</tr>
		<?PHP 
			$helpContent = "You can merge special fields like<br>
							<strong>%%Username%%</strong><br>
							<strong>%%Password%%</strong><br>
							<strong>%%FullName%%</strong><br>
							<strong>%%Email%%</strong><br>
							<strong>%%Phone%%</strong><br>
						    with the email content later while administrating contest.";
		?>
     
        <tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Content:&nbsp;<?php print COMPULSORY_FIELD; ?><span class="tooltip" title="<?PHP echo $helpContent; ?>" style="cursor:help;"><img src="images/help.png" alt="Help" /></span>
			</td>

			<td align="left" valign="top">
            	<textarea name="txtemail_body" id="txtemail_body" class="mceEditor" rows="18" cols="91">
                <?php echo $objEmaiTemplates->email_body; ?>
                </textarea>
			</td>

		</tr>

	
		<tr class="row01">
			<td align="left" valign="top"  class="txtbo">&nbsp;
			</td>
			<td align="left" valign="top" >
				<input  type="submit" class="btn" title="Save" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnemail_templates_id" id="hdnemail_templates_id" value="<?php echo $objEmaiTemplates->email_templates_id; ?>"/>
                <input type="hidden" name="hdnemail_type" id="hdnemail_type" value="<?PHP echo $objEmaiTemplates->email_type; ?>" />
                <input type="hidden" name="hdnclient_id" id="hdnclient_id" value="0"/>
			</td>
		</tr>
	</table>
</form>