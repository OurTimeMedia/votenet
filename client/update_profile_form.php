<form id="frm" name="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validate();">
                <table cellpadding="0" cellspacing="0" width="100%" class="listtab">
                  <tr class="row4">
                    <td class="left-none" width="15%"><strong>Username:</strong>&nbsp;</td>
                    <td class="listtab-rt-bro-user"><?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_username)); ?><input type="hidden" name="txtuser_username" id="txtuser_username" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_username)); ?>" maxlength="50" class="listtab-input" /><input type="hidden" name="user_password" id="user_password" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_password); ?>" maxlength="50" /></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>First Name:</strong>&nbsp;</td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_firstname" id="txtuser_firstname" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_firstname); ?>" maxlength="50" class="listtab-input" /> <span class="red">*</span></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>Last Name:</strong>&nbsp;</td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_lastname" id="txtuser_lastname" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_lastname); ?>" maxlength="50" class="listtab-input" /> <span class="red">*</span></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>Company:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_company" id="txtuser_company" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_company); ?>" maxlength="50" class="listtab-input" /> <span class="red">*</span></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>Email:</strong>&nbsp;</td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_email" id="txtuser_email" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_email); ?>" maxlength="100" class="listtab-input" /> <span class="red">*</span></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>Phone:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_phone" id="txtuser_phone" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_phone); ?>" maxlength="25" class="listtab-input" /></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>Address1:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_address1" id="txtuser_address1" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_address1); ?>" maxlength="200" class="listtab-input" /></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>Address2:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_address2" id="txtuser_address2" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_address2); ?>" maxlength="200" class="listtab-input" /></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>City:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_city" id="txtuser_city" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_city); ?>" maxlength="50" class="listtab-input" /></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>State:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_state" id="txtuser_state" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_state); ?>" size="40" maxlength="50" class="listtab-input" /></td>
                  </tr>
                   <tr class="row4">
                    <td class="left-none"><strong>Zip Code:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtuser_zipcode" id="txtuser_zipcode" value="<?php echo $cmn->readValueDetail($objClientAdmin->user_zipcode); ?>" size="40" class="listtab-input" /></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>Country:</strong></td>
                    <td class="listtab-rt-bro-user"><?php echo $cmn->getContryArray($objClientAdmin->user_country) ?></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none">&nbsp;</td>
                    <td class="listtab-rt-bro-user"><input type="submit" class="btn_img" value="Save" name="btnsave" id="btnsave" title="Save" alt="Save"/>
                    
                    <input  type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>"/>
					<input  type="hidden" name="hdnclient_id" id="hdnclient_id" value="<?php echo $objClientAdmin->client_id; ?>"/>
					<input  type="hidden" name="hdnuser_id" id="hdnuser_id" value="<?php echo $objClientAdmin->user_id; ?>"/>
                    <input  class="input_text" type="hidden" name="seluser_type_id" id="seluser_type_id" value="<?php echo $objClientAdmin->user_type_id; ?>" />
                    </td>
                  </tr>
                </table>
              </form>