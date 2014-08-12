<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();" enctype="multipart/form-data">
	
	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="listtab">

		<tr class="row01" >
			<td align="left" valign="top" width="20%"  class="txtbo">
				Client:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">&nbsp;
              <select name="selclient_id" id="selclient_id"  class="input_text" <?PHP echo $disbalevar; ?>>
              	<option value="">Select Client</option>
				  <?PHP for($i=0;$i<count($aClients);$i++) { ?>
                    <option value="<?PHP echo $aClients[$i]["client_id"] ?>" <?PHP if($aClients[$i]["client_id"]==$objFinanceMakePayment->client_id) { echo "selected"; } ?>><?PHP echo $aClients[$i]["user_username"]; ?></option>
                  <?PHP } ?>
              </select>
              <span id="loadingimg" style="display:none"><img src="images/loading.gif"/></span>
             
			</td>

	  </tr>
        <tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo">
				Amount:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				$<input class="input_small" type="text" name="txtamount" id="txtamount" value="<?php echo htmlspecialchars($objFinanceMakePayment->amount); ?>" maxlength="6" />
			</td>

		</tr>        
        <tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo">
				Payment Type:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				&nbsp;<!--<input class="input_text" type="text" name="txtpayment_type" id="txtpayment_type" value="<?php echo htmlspecialchars($objFinanceMakePayment->payment_type); ?>" maxlength="255" />&nbsp;(Credit Card / Cheque / Wire Transfer)-->
                <select name="selpayment_type_id" id="selpayment_type_id" class="input_text">
              	<option value="">Select Payment Type</option>
                <?PHP
				for($k=0;$k<count($aPayments);$k++)
				{?>
                <option value="<?PHP echo $aPayments[$k]['payment_type_id']; ?>"><?PHP echo $aPayments[$k]['payment_type']; ?></option>
                <?PHP } ?>
                </select>
                <input type="hidden" name="txtdefinePayments" id="txtdefinePayments" value="<?PHP echo $sPayments; ?>" />
			</td>

		</tr>
        
        <tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo">
				Payment Description:&nbsp;
			</td>

			<td align="left" valign="top">
				&nbsp;<textarea  class="input_desc_more" name="txtpayment_description" id="txtpayment_description"><?php echo htmlspecialchars($objFinanceMakePayment->payment_description); ?></textarea>
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" >&nbsp;
						</td>
			<td align="left" valign="top" colspan="2">
				<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save" title="Save" alt="Save"/>
                <input  type="button" name="btncanel" title="Cancel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnclient_payment_id" id="hdnclient_payment_id" value="<?php echo $objFinanceMakePayment->client_payment_id; ?>"/>
				
			</td>
		</tr>
	</table>
</form>