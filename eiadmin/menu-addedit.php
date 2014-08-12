<?php 
	require_once 'include/general-includes.php';
	require_once 'class/clsmenu.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));
		
	$menu_id = 0;
	if (isset($_REQUEST['menu_id']) && trim($_REQUEST['menu_id'])!="")
		$menu_id = $_REQUEST['menu_id'];

	//set mode...
	$strmode="add";
	if(isset($_REQUEST["mode"]))
		$strmode = trim($_REQUEST["mode"]);

	//code to check record existance in case of edit...
	$record_condition = "";
	if ($strmode=="edit" && !($cmn->is_record_exists("menu", "menu_id", $menu_id, $record_condition)))
		$msg->send_msg("menu-list.php","",46);

	//create object of main entity...
	$objmenu = new menu();
	
	$objmenu->menu_active = 'y';

	//include db file here...
	require_once 'menu-db.php';

	if(isset($_SESSION["err"]))
	{
			$objmenu->menu_name = $cmn->getval(trim($cmn->read_value($_POST["txtmenu_name"],"")));
			$objmenu->listing_page = $cmn->getval(trim($cmn->read_value($_POST["txtlisting_page"],"")));
			$objmenu->addedit_page = $cmn->getval(trim($cmn->read_value($_POST["txtaddedit_page"],"")));
			$objmenu->menu_icon = $cmn->getval(trim($cmn->read_value($_POST["txtmenu_icon"],"")));
			$objmenu->menu_order = $cmn->getval(trim($cmn->read_value($_POST["txtmenu_order"],"")));
			$objmenu->menu_active = $cmn->getval(trim($cmn->read_value($_POST["rdomenu_active"],"")));
	}
	else
	{
		if($strmode=="edit")
			$objmenu->setallvalues($menu_id);
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
		arValidate[index++] = new Array("R", "document.frm.txtmenu_name", "menu name");
		arValidate[index++] = new Array("R", "document.frm.txtlisting_page", "listing page");
		arValidate[index++] = new Array("R", "document.frm.txtaddedit_page", "add/edit page");
		arValidate[index++] = new Array("R", "document.frm.txtmenu_icon", "menu icon");
		arValidate[index++] = new Array("R", "document.frm.txtmenu_order", "display order");
		arValidate[index++] = new Array("I", "document.frm.txtmenu_order", "display order");
		arValidate[index++] = new Array("G", "document.frm.txtmenu_order", "display order");
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
                  <td align="left" valign="top" class="box-heading"><h2>Menu</h2></td>
                </tr>
                <tr>
                  <td align="left" valign="top" height="15"></td>
                </tr>
                <tr>
                  <td align="right" valign="top" class="required-sentence"><?php echo REQUIRED_SENTENCE; ?></td>
                </tr>
                <tr>
                  <td align="left" valign="top" height="10"></td>
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
                  <td align="left" valign="top"><form name="frm" id="frm" method="post" action="<?php echo trim($_SERVER['REQUEST_URI']); ?>" onsubmit="javascript: return validate();">
                      <table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn" width="550">
                        <tr>
                          <td align="left" valign="top" width="150"><label>Menu <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtmenu_name" class="textbox" id="txtmenu_name" maxlength="100" value="<?php echo htmlspecialchars($objmenu->menu_name); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>Listing Page <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtlisting_page" class="textbox" id="txtlisting_page" maxlength="255" value="<?php echo htmlspecialchars($objmenu->listing_page); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>Add/Edit Page <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtaddedit_page" class="textbox" id="txtaddedit_page" maxlength="255" value="<?php echo htmlspecialchars($objmenu->addedit_page); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                         <tr>
                          <td align="left" valign="top" width="150"><label>Menu Icon <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtmenu_icon" class="textbox" id="txtmenu_icon" maxlength="255" value="<?php echo htmlspecialchars($objmenu->menu_icon); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="150"><label>Display Order <?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtmenu_order" class="textbox" id="txtmenu_order" maxlength="11" value="<?php echo htmlspecialchars($objmenu->menu_order); ?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Active?</label></td>
                          <td align="left" valign="top"><input type="radio" name="rdomenu_active" id="rdomenu_active" value="y" <?php if ( $objmenu->menu_active == 'y' ) echo 'checked="checked"'; ?> />
                            Yes &nbsp;
                            <input type="radio" name="rdomenu_active" id="rdomenu_active" value="n" <?php if ( $objmenu->menu_active == 'n' ) echo 'checked="checked"'; ?> />
                            No </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top"><input type="submit" value="Save" class="button" name="btnsubmit" id="btnsubmit" />
                            <input type="button" value="Cancel" class="button" name="btncancel" id="btncancel" onclick="javascript:window.location.href='menu-list.php';" /></td>
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
	document.getElementById('txtmenu_name').focus();
</script>
</html>