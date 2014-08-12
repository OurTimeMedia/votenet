<?php 
	require_once 'include/general-includes.php';
	require_once 'class/clsuser.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));
		
	$user_id = 0;
	if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id'])!="")
		$user_id = $_REQUEST['user_id'];

	//set mode...
	$strmode="add";
	if(isset($_REQUEST["mode"]))
		$strmode = trim($_REQUEST["mode"]);

	//code to check record existance in case of edit...
	$record_condition = "";
	if ($mode=="edit" && !($cmn->is_record_exists("user", "user_id", $user_id, $record_condition)))
		$msg->send_msg("user-list.php","",46);

	//create object of main entity...
	$objuser = new user();	
	$objuser->user_active = 'y';

	//include db file here...
	require_once 'user-db.php';

	if(isset($_SESSION["err"]))
	{
			$objuser->user_role_id = $cmn->getval(trim($cmn->read_value($_POST["seluser_role"],"")));
			$objuser->first_name = $cmn->getval(trim($cmn->read_value($_POST["txtfirst_name"],"")));
			$objuser->last_name = $cmn->getval(trim($cmn->read_value($_POST["txtlast_name"],"")));
			$objuser->email = $cmn->getval(trim($cmn->read_value($_POST["txtemail"],"")));
			$objuser->user_name = $cmn->getval(trim($cmn->read_value($_POST["txtuser_name"],"")));
			$objuser->password = $cmn->getval(trim($cmn->read_value($_POST["txtpassword"],"")));
			$objuser->user_active = $cmn->getval(trim($cmn->read_value($_POST["rdouser_active"],"")));
	}
	else
	{
		if($strmode=="edit")
			$objuser->setallvalues($user_id);
	}
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
		arValidate[index++] = new Array("R", "document.frm.txtfirst_name", "first name");
		arValidate[index++] = new Array("R", "document.frm.txtlast_name", "last name");
		arValidate[index++] = new Array("R", "document.frm.txtemail", "email");
		arValidate[index++] = new Array("E", "document.frm.txtemail", "email");
		arValidate[index++] = new Array("S", "document.frm.seluser_role", "user role");
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
    <td height="100%" valign="top" class="content-background"><div class="content">
        <table cellpadding="0" cellspacing="0" width="100%">
          <tr valign="top">
            <!--<td width="218" class="menu"><?php //require_once 'include/menu.php'; ?></td>
            <td width="17">&nbsp;</td> -->
            <td class="main-content"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td align="left" valign="top" class="box-heading"><h2>User</h2></td>
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
                  <td align="left" valign="top">
                  	<?php 
						if ( ( $user_rights_array['add'] && $strmode == 'add' )  || ( $user_rights_array['edit'] && $strmode == 'edit' ) ) {
					?>
                  	<form name="frm" id="frm" method="post" action="<?php echo trim($_SERVER['REQUEST_URI']); ?>" onsubmit="javascript: return validate();">
                      <table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn" width="100%">
                         <tr>
                          <td align="right" valign="top" class="required-sentence" colspan="2"><?php echo REQUIRED_SENTENCE; ?></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>First Name <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" class="textbox" class="textbox" name="txtfirst_name" id="txtfirst_name" maxlength="100" value="<?php echo htmlspecialchars($objuser->first_name); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>Last Name <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtlast_name" class="textbox" id="txtlast_name" maxlength="100" value="<?php echo htmlspecialchars($objuser->last_name); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>Email <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtemail" class="textbox" id="txtemail" maxlength="255" value="<?php echo htmlspecialchars($objuser->email); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>User Role <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top">
							<select name="seluser_role" id="seluser_role" class="selectbox">
                            	<option value="">Please select</option>
                                <?php 
									$cmn->fillcombo(DB_PREFIX . 'user_role', 'SELECT user_role_id, user_role_name FROM ' . DB_PREFIX . 'user_role WHERE user_role_active = \'y\' ORDER BY user_role_name', 'user_role_id', 'user_role_name', (int) $objuser->user_role_id);
								?>
                            </select>
	                      </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>User Name <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtuser_name" class="textbox" id="txtuser_name" maxlength="100" value="<?php echo htmlspecialchars($objuser->user_name); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>Password <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="password" name="txtpassword" class="textbox" id="txtpassword" maxlength="50" value="<?php echo htmlspecialchars($objuser->password); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Active?</label></td>
                          <td align="left" valign="top"><input type="radio" name="rdouser_active" id="rdouser_active" value="y" <?php if ( $objuser->user_active == 'y' ) echo 'checked="checked"'; ?> />
                            Yes &nbsp;
                            <input type="radio" name="rdouser_active" id="rdouser_active" value="n" <?php if ( $objuser->user_active == 'n' ) echo 'checked="checked"'; ?> />
                            No </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top"><input type="submit" value="Submit" class="button" name="btnsubmit" id="btnsubmit" />
                            <input type="button" value="Cancel" class="button" name="btncancel" id="btncancel" onclick="javascript:window.location.href='user-list.php';" /></td>
                        </tr>
                      </table>
                    </form>
                    <script type="text/javascript" language="javascript">
						document.getElementById('txtfirst_name').focus();
					</script>
                    <?php 
						}
						else {
					?>
                    	<table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn view-table" width="550">
                            <tr>
                              <td align="left" valign="top" height="20"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" width="150"><label>First Name</label></td>
                              <td align="left" valign="top"><?php echo htmlspecialchars($objuser->first_name); ?></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" height="10"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" width="150"><label>Last Name</label></td>
                              <td align="left" valign="top"><?php echo htmlspecialchars($objuser->last_name); ?></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" height="10"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" width="150"><label>Email</label></td>
                              <td align="left" valign="top"><?php echo htmlspecialchars($objuser->email); ?></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" height="10"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" width="150"><label>User Role</label></td>
                              <td align="left" valign="top">
                                <?php echo $objuser->user_role_id ?>
                              </td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" height="10"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" width="150"><label>User Name</label></td>
                              <td align="left" valign="top"><?php echo htmlspecialchars($objuser->user_name); ?></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" height="10"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" width="150"><label>Password</label></td>
                              <td align="left" valign="top"><?php echo htmlspecialchars($objuser->password); ?></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" height="10"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" width="150"><label>Active?</label></td>
                              <td align="left" valign="top"><?php echo strtoupper($objuser->user_active); ?></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" height="10"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top">&nbsp;</td>
                              <td align="left" valign="top">
                                <input type="button" value="Back" class="button" name="btnback" id="btnback" onclick="javascript:window.location.href='user-list.php';" /></td>
                            </tr>
                      </table>
                    <?php	
						}
					?>
                   </td>
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
</html>
