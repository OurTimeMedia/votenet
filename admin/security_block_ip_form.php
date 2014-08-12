<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validateIP();" enctype="multipart/form-data">
	
	<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

		<tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo">
				IP Address:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtipaddress" id="txtipaddress" value="<?php echo htmlspecialchars($objSecurityBlockIP->ipaddress); ?>" maxlength="15" />
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top"  class="txtbo">&nbsp;
			</td>
			<td align="left" valign="top" >
				<input  type="submit" title="Save" class="btn" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" name="btncanel" title="Cancel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnblock_ipaddress_id" id="hdnblock_ipaddress_id" value="<?php echo $objSecurityBlockIP->block_ipaddress_id; ?>"/>
				
				<input type="hidden" name="hdnclient_id" id="hdnclient_id" value="0"/>
			</td>
		</tr>
	</table>
</form>