<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validate();" enctype="multipart/form-data">	
	<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">
		<tr class="row4">
			<td align="left" valign="top" width="20%">
				<strong>Name of Email Template:</strong>
			</td>
			<td align="left" valign="top" colspan="2">
				<input  class="listtab-input13" type="text" name="txtemail_templates_name" id="txtemail_templates_name" value="<?php echo $cmn->readValueDetail($objEmaiTemplates->email_templates_name); ?>" maxlength="200" /> <span class="red">*</span>
			</td>
		</tr>
		<tr class="row4">
			<td align="left" valign="top" width="20%">
				<strong>Subject:</strong>
			</td>
			<td align="left" valign="top" colspan="2">
				<input class="listtab-input13" type="text" name="txtemail_subject" id="txtemail_subject" value="<?php echo $cmn->readValueDetail($objEmaiTemplates->email_subject); ?>" maxlength="200" /> <span class="red">*</span>
			</td>
		</tr>
        <tr class="row4">
			<td align="left" valign="top">
				<strong>Content:</strong>&nbsp;
			</td>

			<td align="left" valign="top" width="45%">
            	<textarea name="txtemail_body" id="txtemail_body" class="mceEditor" rows="18" cols="91"><?php print $objEmaiTemplates->email_body; ?></textarea>
			</td>
			<td align="left" valign="top"><span class="red">*</span></td>

		</tr>
		<tr class="row4">
			<td align="left" valign="top">&nbsp;
			</td>
			<td align="left" valign="top" colspan="2" >
				<input  type="submit" class="btn_img" title="Save" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn_img" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnemail_templates_id" id="hdnemail_templates_id" value="<?php echo $objEncDec->encrypt($objEmaiTemplates->email_templates_id); ?>"/>
                <input type="hidden" name="hdnemail_type" id="hdnemail_type" value="<?PHP echo $objEmaiTemplates->email_type; ?>" />
                <input type="hidden" name="hdnclient_id" id="hdnclient_id" value="<?php echo $objEmaiTemplates->client_id; ?>"/>
			</td>
		</tr>
	</table>
</form>