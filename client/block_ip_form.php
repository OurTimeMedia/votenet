<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validateIP();" enctype="multipart/form-data">
	
	<table cellpadding="0" cellspacing="0" border="0" class="listtab12" width="100%">

		<tr>
			<td align="left"width="12%">
				<strong>IP Address:</strong>&nbsp;
			</td>

			<td align="left">
				<input class="listtab-input" type="text" name="txtipaddress" id="txtipaddress" value="<?php echo $cmn->readValueDetail($objSecurityBlockIP->ipaddress); ?>"  /> <span class="red">*</span>
			</td>

		</tr>
        
		<tr class="row01">
			<td align="left" valign="top" class="listtab-td-last">&nbsp;
			</td>
			<td align="left" valign="top" >
				<input  type="submit" title="Save" class="btn_img" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" name="btncanel" title="Cancel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn_img" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnblock_ipaddress_id" id="hdnblock_ipaddress_id" value="<?php echo $objEncDec->encrypt($objSecurityBlockIP->block_ipaddress_id); ?>"/>
				
				<input type="hidden" name="hdnclient_id" id="hdnclient_id" value="<?PHP echo $objSecurityBlockIP->client_id ?>"/>
			</td>
		</tr>
	</table>
</form>