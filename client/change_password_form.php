<form id="frm" name="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validatePassword();">
	<table cellpadding="0" cellspacing="0" width="100%" class="listtab">
		<tr class="row4">
 			<td class="left-none" width="25%"><strong>Username:</strong></td>
            <td class="listtab-rt-bro-user"><?php echo $cmn->readValueDetail($sUserName); ?>
            </td>
        </tr>
		<tr class="row4">
 			<td class="left-none"><strong>Old Password:</strong></td>
            <td class="listtab-rt-bro-user"><input type="password" name="user_oldpassword" id="user_oldpassword" size="40" value="" maxlength="50" class="listtab-input" /> <span class="red">*</span></td>
        </tr>
		<tr class="row4">
        	<td class="left-none"><strong>New Password:</strong></td>
            <td class="listtab-rt-bro-user"><input type="password" name="user_password" id="user_password" size="40" value="" maxlength="50" class="listtab-input" /> <span class="red">*</span></td>
        </tr>
		<tr class="row4">
        	<td class="left-none"><strong>Confirm Password:</strong></td>
            <td class="listtab-rt-bro-user"><input type="password" name="user_confirmpassword" id="user_confirmpassword" size="40" value="" maxlength="50" class="listtab-input" /> <span class="red">*</span></td>
        </tr>
        <tr class="row4">
        	<td class="left-none">&nbsp;</td>
            <td class="listtab-rt-bro-user">
            <input  type="hidden" name="hdnuser_id" id="hdnuser_id" value="<?php echo $user_id; ?>"/>
            <input type="submit" class="btn_img" value="Save" name="btnsave" id="btnsave" title="Save" alt="Save"/></td>
        </tr>
	</table>
</form>