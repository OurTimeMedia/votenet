<form id="frm" name="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validateBillingInfo();">
	<table cellpadding="0" cellspacing="0" width="100%" class="listtab">                  
                  <tr class="row4">
                    <td class="left-none" width="15%"><strong>Billing Name:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtbill_name" id="txtbill_name" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->bill_name); ?>" maxlength="100" class="listtab-input"/> <span class="red">*</span></td>
                  </tr>                 
                  <tr class="row4">
                    <td class="left-none"><strong>Address1:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtbill_address1" id="txtbill_address1" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->bill_address1); ?>" maxlength="200" class="listtab-input"/></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>Address2:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtbill_address2" id="txtbill_address2" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->bill_address2); ?>" maxlength="200" class="listtab-input" /></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>City:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtbill_city" id="txtbill_city" size="40" value="<?php echo $cmn->readValueDetail($objClientAdmin->bill_city); ?>" maxlength="50" class="listtab-input" /></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>State:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtbill_state" id="txtbill_state" value="<?php echo $cmn->readValueDetail($objClientAdmin->bill_state); ?>" size="40" maxlength="50" class="listtab-input" /></td>
                  </tr>
                   <tr class="row4">
                    <td class="left-none"><strong>Zip Code:</strong></td>
                    <td class="listtab-rt-bro-user"><input type="text" name="txtbill_zipcode" id="txtbill_zipcode" value="<?php echo $cmn->readValueDetail($objClientAdmin->bill_zipcode); ?>" size="40" class="listtab-input" /></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none"><strong>Country:</strong></td>
                    <td class="listtab-rt-bro-user"><?php echo $cmn->getContryArray($objClientAdmin->bill_country_id) ?></td>
                  </tr>
                  <tr class="row4">
                    <td class="left-none">&nbsp;</td>
                    <td class="listtab-rt-bro-user"><input type="submit" class="btn" value="Save" name="btnsave" id="btnsave" title="Save" alt="Save"/>
                    <input  type="hidden" name="hdnclient_id" id="hdnclient_id" value="<?php echo $objClientAdmin->client_id; ?>"/>
                    <input  type="hidden" name="hdnallow_credit" id="hdnallow_credit" value="<?php echo $objClientAdmin->allow_credit; ?>"/>
					
                    </td>
                  </tr>
                </table>
</form>