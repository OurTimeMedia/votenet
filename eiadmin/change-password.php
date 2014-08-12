<?php 
	require_once 'include/general-includes.php';
	require_once 'class/clsuser.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));
	$objuser = new user();
	//include db file here...
	require_once 'change-password-db.php';
	$strold_password = $cmn->getval(trim($cmn->read_value($_POST["txtold_password"],"")));
	$strnew_password = $cmn->getval(trim($cmn->read_value($_POST["txtnew_password"],"")));
	$strconfirm_password = $cmn->getval(trim($cmn->read_value($_POST["txtconfirm_password"],"")));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ADMIN_PANEL_PAGE_TITLE; ?></title>
<?php require_once 'include/theme.php'; ?>
<script type="text/javascript" language="javascript" src="js/validation.js"></script>
<script language="javascript" type="text/javascript">
	function validate(){
		var index = 0;
		var arValidate = new Array;
		arValidate[index++] = new Array("R", "document.frm.txtold_password", "old password");
		arValidate[index++] = new Array("R", "document.frm.txtnew_password", "new password");
		arValidate[index++] = new Array("R", "document.frm.txtconfirm_password", "confirm password");
		arValidate[index++] = new Array("P", "document.frm.txtnew_password|document.frm.txtconfirm_password", "Password and confirm password must match.");
		if (!Isvalid(arValidate)){
			return false;
		}
		
		return true;	
	}
</script>
</head>
<body>
<table height="100%" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td height="72" valign="middle" class="header-main"><?php require_once 'include/header.php'; ?></td>
  </tr>
  <tr>
    <td height="100%" valign="top" class="content-background"><div class="content">
        <table cellpadding="0" cellspacing="0" width="100%">
          <tr valign="top">
            <!--<td width="218" class="menu"><?php //require_once 'include/menu.php'; ?></td>
            <td width="17">&nbsp;</td> -->
            <td class="main-content"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td align="left" valign="top" class="box-heading"><h2>Change Password</h2></td>
                </tr>
                <tr>
                  <td align="left" valign="top" height="15"></td>
                </tr>
				<?php 
					if ( isset($_SESSION['err']) ) {
				?>
                		<tr>
                          <td align="left" valign="top">
                          	<?php $msg->display_msg(); ?>
                          </td>
                        </tr>
                <?php	
					}
				?>
                <tr>
                  <td align="right" valign="top" class="required-sentence"><?php echo REQUIRED_SENTENCE; ?></td>
                </tr>
                <tr>
                  <td align="left" valign="top" height="10"></td>
                </tr>
                
                <tr>
                  <td align="left" valign="top"><form name="frm" id="frm" method="post" action="<?php echo trim($_SERVER['REQUEST_URI']); ?>" onsubmit="javascript: return validate();">
                      <table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn" width="550">
                        <tr>
                          <td align="left" valign="top" width="150"><label>Old Password: <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="password" name="txtold_password" class="textbox" id="txtold_password" maxlength="50" value="<?php echo htmlspecialchars($strold_password); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>New Password: <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="password" name="txtnew_password" class="textbox" id="txtnew_password" maxlength="50" value="<?php echo htmlspecialchars($strnew_password); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>Confirm Password: <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="password" name="txtconfirm_password" class="textbox" id="txtconfirm_password" maxlength="50" value="<?php echo htmlspecialchars($strconfirm_password); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top"><input type="submit" value="Save" class="button" name="btnsubmit" id="btnsubmit" />
                            <input type="button" class="button" value="Cancel" name="btncancel" id="btncancel" onclick="javascript:window.location.href='dashboard.php';" /></td>
                        </tr>
                      </table>
                    </form></td>
                </tr>
                <tr>
                  <td align="left" valign="top" height="25"></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td valign="middle" height="40" class="footer-main"><?php require_once 'include/footer.php'; ?></td>
  </tr>
</table>
</body>
<script type="text/javascript" language="javascript">
	document.getElementById('txtold_password').focus();
</script>
</html>