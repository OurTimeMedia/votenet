<form id="frm" name="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validate();">
                <table cellpadding="0" cellspacing="0" border="0" class="listtab12" width="100%">
                  <tr>
                    <td width="20%">Username :&nbsp;<span class="red">*</span></td>
                    <td><input type="text" name="txtuser_username" id="txtuser_username" size="40" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->txtuser_username)); ?>" maxlength="50"/></td>
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