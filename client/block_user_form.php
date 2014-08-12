<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validateUser();" enctype="multuserart/form-data">
	<table cellpadding="0" cellspacing="0" width="100%" class="listtab12">
		<tr class="row01" >
			<td width="12%"><strong>Username :</strong></td>
			<td align="left" valign="top" width="78%">
				<input  class="listtab-input" type="text" name="txtuser" id="txtuser" value="<?php echo $cmn->readValueDetail($objSecurityBlockUser->user); ?>" maxlength="100" /> <span class="red">*</span>
			</td>
		</tr>
        <tr class="row01">
			<td align="left" valign="top">&nbsp;
			</td>
			<td align="left" valign="top" >
				<input  type="submit" class="btn_img" title="Save" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="javascript:window.location.href='block_user_list.php'" value="Cancel" class="btn_img" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnblockuser_id" id="hdnblockuser_id" value="<?php echo $objEncDec->encrypt($objSecurityBlockUser->blockuser_id); ?>"/>
				
				<input type="hidden" name="hdnclient_id" id="hdnclient_id" value="<?PHP echo $objSecurityBlockUser->client_id ?>"/>                
			</td>
		</tr>
	</table>
</form>