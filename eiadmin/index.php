<?php 
	require_once 'include/general-includes.php';
	
	//include db file here...
	require_once 'index-db.php';
$cmn->check_admin_login();
	$struser_name = $cmn->getval(trim($cmn->read_value($_POST["txtuser_name"],"")));
	$strpassword = $cmn->getval(trim($cmn->read_value($_POST["txtpassword"],"")));
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
		arValidate[index++] = new Array("R", "document.frm.txtuser_name", "user name");
		arValidate[index++] = new Array("R", "document.frm.txtpassword", "password");
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
    <td height="100%" valign="middle" class="content-background">
    <?php 
		if ( isset($_SESSION['err']) ) {
	?>
		<div align="center" style="width:418px;margin:0 auto;"><?php $msg->display_msg(); ?></div>
  <?php	
		}
	?>
    <div class="loginbox">
      <div class="loginbox2">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
          <tr>
            <td align="right" valign="top"><?php echo REQUIRED_SENTENCE; ?></td>
          </tr>
          <tr>
            <td align="left" valign="top" height="5"></td>
          </tr>
          <tr>
            <td align="left" valign="top" height="25">Please enter your user name and password.</td>
          </tr>
          <tr>
            <td align="left" valign="top" height="5"></td>
          </tr>
          <tr>
            <td align="left" valign="top"><form name="frm" id="frm" action="<?php echo trim($_SERVER['REQUEST_URI']); ?>" method="post" onsubmit="javascript:return validate();">
                <table cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td align="right" valign="middle"><strong>User name:&nbsp;<?php echo REQUIRED;?>&nbsp;</strong></td>
                    <td align="left" valign="top" width="5"></td>
                    <td align="left" valign="top"><input type="text" name="txtuser_name" class="textbox" id="txtuser_name" maxlength="100" style="width:190px;" value="<?php echo htmlspecialchars($struser_name); ?>" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" height="10"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle"><strong>Password:&nbsp;<?php echo REQUIRED;?>&nbsp;</strong></td>
                    <td align="left" valign="top" width="5"></td>
                    <td align="left" valign="top"><input type="password" name="txtpassword" class="textbox" id="txtpassword" maxlength="50" style="width:190px;" value="<?php echo htmlspecialchars($strpassword); ?>" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" height="10"></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" colspan="2">&nbsp;</td>
                    <td align="left" valign="top"><input type="submit" name="btnsubmit" class="button" id="btnsubmit" value="Submit" /></td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table>
      </div>
    </div>
    </td>
  </tr>
  <tr>
    <td valign="middle" height="40" class="footer-main"><?php require_once 'include/footer.php'; ?></td>
  </tr>
</table>
<script type="text/javascript" language="javascript">
	document.getElementById('txtuser_name').focus();
</script>
</body>
</html>