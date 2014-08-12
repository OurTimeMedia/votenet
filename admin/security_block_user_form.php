<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validateUser();" enctype="multuserart/form-data">
	
	<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

		<tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo">
				User Name:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>
		
			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtuser" id="txtuser" value="" maxlength="100" />
                <input type="hidden" name="definedUsers" id="definedUsers" value="<?PHP echo htmlspecialchars($userNames);?>" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top"  class="txtbo">&nbsp;
			</td>
			<td align="left" valign="top" >
				<input  type="submit" class="btn" title="Save" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="javascript:window.location.href='security_block_user.php'" value="Cancel" class="btn" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnblockuser_id" id="hdnblockuser_id" value="<?php echo $objSecurityBlockUser->blockuser_id; ?>"/>
				
				<input type="hidden" name="hdnclient_id" id="hdnclient_id" value="0"/>
                <input type="hidden" name="hdnvoter_id" id="hdnvoter_id" value="0"/>
                
			</td>
		</tr>
	</table>
</form>