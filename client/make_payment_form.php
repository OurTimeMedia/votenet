<form id="frm" name="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validate();">
	<table cellpadding="0" cellspacing="0" border="0" class="listtab12" width="100%">
	  <tr>
		<td width="20%">First Name :&nbsp;<span class="red">*</span></td>
		<td><input type="text" name="firstName" id="firstName" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->firstName)); ?>" maxlength="50"/></td>
	  </tr>
	  <tr>
		<td width="20%">Last Name :&nbsp;<span class="red">*</span></td>
		<td><input type="text" name="lastName" id="lastName" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->lastName)); ?>" maxlength="50"/></td>
	  </tr>
	  <tr>
		<td width="20%">Card Type :&nbsp;<span class="red">*</span></td>
		<td>
		<select onchange="javascript:generateCC(); return false;" name="creditCardType">
				<option <?php if ($objClientAdmin->creditCardType == 'Visa') echo 'selected="selected"'; ?> value="Visa">Visa</option>
				<option <?php if ($objClientAdmin->creditCardType == 'MasterCard') echo 'selected="selected"'; ?> value="MasterCard">MasterCard</option>
				<option <?php if ($objClientAdmin->creditCardType == 'Discover') echo 'selected="selected"'; ?> value="Discover">Discover</option>
				<option <?php if ($objClientAdmin->creditCardType == 'Amex') echo 'selected="selected"'; ?> value="Amex">American Express</option>
			</select></td>
	  </tr>
	  <tr>
		<td width="20%">Card Number :&nbsp;<span class="red">*</span></td>
		<td><input type="text" name="creditCardNumber" id="creditCardNumber" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->creditCardNumber)); ?>" maxlength="19"/></td>
	  </tr>
	  <tr>
		<td width="20%">Expiration Date :&nbsp;<span class="red">*</span></td>
		<td>
		<select name="expDateMonth" id="expDateMonth">
		<?php for($i=1;$i<13;$i++) {
			echo "<option value='$i' ";
			if ($objClientAdmin->expDateMonth == $i) echo 'selected="selected"';
			echo ">" . sprintf("%02d",$i) . "</option>";
		}?>
		</select>
		<select name="expDateYear" id="expDateYear">
		<?php for($i=date('Y');$i<date('Y')+50;$i++) {
			echo "<option value='$i' ";
			if ($objClientAdmin->expDateYear == $i) echo 'selected="selected"';
			echo ">$i</option>";
		}?>
		</select>
		</td>
	  </tr>
	  <tr>
		<td width="20%">Card Verification Number :&nbsp;<span class="red">*</span></td>
		<td><input type="text" name="cvv2Number" id="cvv2Number" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->cvv2Number)); ?>" maxlength="50"/></td>
	  </tr>
	  <tr>
		<td colspan="2"><strong>Billing Address</strong></td>
	  </tr>
	  <tr>
		<td width="20%">Address 1 :&nbsp;<span class="red">*</span></td>
		<td><input type="text" name="address1" id="address1" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->address1)); ?>" maxlength="50"/></td>
	  </tr>
	  <tr>
		<td width="20%">Address 2 :&nbsp;</td>
		<td><input type="text" name="address2" id="address2" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->address2)); ?>" maxlength="50"/></td>
	  </tr>
	  <tr>
		<td width="20%">City :&nbsp;<span class="red">*</span></td>
		<td><input type="text" name="city" id="city" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->city)); ?>" maxlength="50"/></td>
	  </tr>
	 <tr>
		<td width="20%">State :&nbsp;<span class="red">*</span></td>
		<td>
		<select name="state" id="state">
		<?php $aryState = $objState->fetchAllAsArray();
		for($i=0;$i<count($aryState);$i++) {
			echo "<option value='".$aryState[$i]['state_code']."' ";
			if ($objClientAdmin->state == $aryState[$i]['state_code']) echo 'selected="selected"';
			echo ">".$aryState[$i]['state_name']."</option>";
		}
		?>
		</select>
		</td>
	  </tr>
	  <tr>
		<td width="20%">ZIP Code :&nbsp;<span class="red">*</span></td>
		<td><input type="text" name="zip" id="zip" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->zip)); ?>" maxlength="50"/></td>
	  </tr>
	  <tr>
		<td width="20%">Country :&nbsp;<span class="red">*</span></td>
		<td>United States</td>
	  </tr>
	  <tr>
		<td width="20%">Amount :&nbsp;<span class="red">*</span></td>
		<td><input type="text" name="amount" id="amount" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->amount)); ?>" maxlength="50"/></td>
	  </tr>
	  <tr class="row01">
		<td>&nbsp;</td>
		<td><input type="submit" class="btn" value="Submit" name="btnsave" id="btnsave" title="Submit" alt="Submit"/>
		<input  type="button" title="Cancel" name="btncanel" id="btncanel" value="Cancel" class="btn" onclick="<?PHP echo $cancel_button; ?>" alt="Cancel" />
		<input  type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>"/>
		
		</td>
	  </tr>
	</table>
  </form>