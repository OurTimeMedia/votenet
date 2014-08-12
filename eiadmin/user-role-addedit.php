<?php 
	require_once 'include/general-includes.php';
	require_once 'class/clsuser-role.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));
		
	$user_role_id = 0;
	if (isset($_REQUEST['user_role_id']) && trim($_REQUEST['user_role_id'])!="")
		$user_role_id = $_REQUEST['user_role_id'];

	//set mode...
	$strmode="add";
	if(isset($_REQUEST["mode"]))
		$strmode = trim($_REQUEST["mode"]);

	//code to check record existance in case of edit...
	$record_condition = "";
	if ($mode=="edit" && !($cmn->is_record_exists("user_role", "user_role_id", $user_role_id, $record_condition)))
		$msg->send_msg("user-role-list.php","",46);

	//create object of main entity...
	$objuser_role = new user_role();
	
	$objuser_role->user_role_active = 'y';

	//include db file here...
	require_once 'user-role-db.php';

	if(isset($_SESSION["err"]))
	{
		$objuser_role->user_role_name = $cmn->getval(trim($cmn->read_value($_POST["txtuser_role_name"],"")));
		$objuser_role->user_role_active = $cmn->getval(trim($cmn->read_value($_POST["rdouser_role_active"],"")));
	}
	else
	{
		if($strmode=="edit")
			$objuser_role->setallvalues($user_role_id);
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
		arValidate[index++] = new Array("R", "document.frm.txtuser_role_name", "user role");
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
                  <td align="left" valign="top" class="box-heading"><h2>User Role</h2></td>
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
                          <td align="left" valign="top" width="150"><label>User Role <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtuser_role_name" class="textbox" id="txtuser_role_name" maxlength="100" value="<?php echo htmlspecialchars($objuser_role->user_role_name); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
						 <tr>
                          <td align="left" valign="top" width="150"><label>User Text Area <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><textarea id="txtAre" name="txtAre" class="textbox"></textarea>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10">
						  </td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" width="150"><label>User Text Area <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="checkbox" name="chk" class="textbox" />
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10">
						  </td>
                        </tr>
						<tr>
                          <td align="left" valign="top" width="150"><label>User Text Area <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="radio" name="rdb" class="textbox" />
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10">
						  </td>
                        </tr>
						<tr>
                          <td align="left" valign="top" width="150"><label>User Text Area <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><select id="sel" class="selectbox">
						  <option value="abc">abc</option>
						  <option value="abc">def</option>
						  <option value="abc">efg</option>
						  <option value="abc">hij</option>
						  </select>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10">
						  </td>
                        </tr>
						
                        <tr>
                          <td align="left" valign="top"><label>Active?</label></td>
                          <td align="left" valign="top"><input type="radio" name="rdouser_role_active" id="rdouser_role_active" value="y" <?php if ( $objuser_role->user_role_active == 'y' ) echo 'checked="checked"'; ?> />
                            Yes &nbsp;
                            <input type="radio" name="rdouser_role_active" id="rdouser_role_active" value="n" <?php if ( $objuser_role->user_role_active == 'n' ) echo 'checked="checked"'; ?> />
                            No </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top"><input type="submit" value="Submit" class="button" name="btnsubmit" id="btnsubmit" />
                            <input type="button" value="Cancel" class="button" name="btncancel" id="btncancel" onclick="javascript:window.location.href='user-role-list.php';" /></td>
                        </tr>
                      </table>
                    </form>
                    <script type="text/javascript" language="javascript">
						document.getElementById('txtuser_role_name').focus();
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
                              <td align="left" valign="top" width="150"><label>User Role</label></td>
                              <td align="left" valign="top">
                              	<?php echo htmlspecialchars($objuser_role->user_role_name); ?>
                              </td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" height="10"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top"><label>Active?</label></td>
                              <td align="left" valign="top">
                              	<?php echo strtoupper($objuser_role->user_role_active); ?>
                              </td>
                            </tr>
                            <tr>
                              <td align="left" valign="top" height="10"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="top">&nbsp;</td>
                              <td align="left" valign="top">
                                <input type="button" value="Back" class="button" name="btnback" id="btnback" onclick="javascript:window.location.href='user-role-list.php';" /></td>
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