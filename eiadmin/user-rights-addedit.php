<?php 
	require_once 'include/general-includes.php';
	require_once 'class/clsuser-rights.php';
	require_once 'class/clsuser-role.php';
	require_once 'class/clsmenu.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));
		
	$user_role_id = 0;
	if (isset($_REQUEST['user_role_id']) && trim($_REQUEST['user_role_id'])!="")
		$user_role_id = $_REQUEST['user_role_id'];
		
	if ( $user_role_id <= 0 ) {
		$cmn->header_location('user-rights-list.php');
		exit();
	}

	//create object of main entity...
	$objuser_rights = new user_rights();
	$objuser_role = new user_role();
	$objmenu = new menu();
	
	//include db file here...
	require_once 'user-rights-db.php';

	$strcondition = ' AND user_role_id = ' . (int) $user_role_id;
	$aruser_rights = $objuser_rights->fetchallasarray(NULL, NULL, $strcondition);
	$aruser_role = $objuser_role->fetchallasarray((int) $user_role_id);
	$armenu = $objmenu->fetchallasarray(NULL, NULL, ' AND menu_active = \'y\'');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ADMIN_PANEL_PAGE_TITLE; ?></title>
<?php require_once 'include/theme.php'; ?>
<style type="text/css">
	.user-role {
		color:#333333;	
	}
	.user-role-name {
		color:#CC0000;
		font-size:16px;	
	}
	.menu-name {
		font-weight:bold;
		padding:0 0 0 10px;	
	}
	.menu-right {
		padding:0 0 0 20px;		
	}
	.menu-right-checkbox {
		padding-left:10px;	
	}
</style>
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
                  <td align="left" valign="top" class="box-heading"><h2>User Rights</h2></td>
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
                  <td align="left" valign="top">
                  	<?php 
						if ( $user_rights_array['edit'] ) {
					?>
                  	<form name="frm" id="frm" method="post" action="<?php echo trim($_SERVER['REQUEST_URI']); ?>" onsubmit="javascript: return validate();">
                      <table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn user-role" width="100%">
                        <tr>
                          <td align="left" valign="top" width="150">&nbsp;</td>
                          <td align="left" valign="top">
                          	<?php 
								if ( is_array($armenu) && count($armenu) ) {
							?>
                            		<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td align="left" valign="top" class="user-role-name">
                                            	<?php echo $cmn->getval($aruser_role[0]['user_role_name']); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td align="left" valign="top" height="10"></td>
                                        </tr>
                                        <tr>
                                        	<td align="left" valign="top">
                                            	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                	<tr>
                                                    	<th width="17%" align="left" valign="top">MENU</th>
                                                        <th width="17%" align="center" valign="top">VIEW DETAILS</th>
                                                        <th width="17%" align="center" valign="top">ADD RECORDS</th>
                                                        <th width="17%" align="center" valign="top">EDIT RECORDS</th>
                                                        <th width="17%" align="center" valign="top">DELETE RECORDS</th>
                                                        <th width="16%" align="center" valign="top">EXPORT TO CSV</th>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left" valign="top" height="10"></td>
                                                    </tr>
                                                    <?php 
														$inttotal_menu = count($armenu);
														for ( $intcounter = 0; $intcounter < $inttotal_menu; $intcounter++ ) {
													?>
                                                    <tr>
                                                    	<td align="left" valign="top">
                                                        	<?php echo $cmn->getval($armenu[$intcounter]['menu_name']); ?>
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '1'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 1); ?> />
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '2'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 2); ?> />
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '3'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 3); ?> />
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '4'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 4); ?> />
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '6'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 6); ?>/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left" valign="top" height="10"></td>
                                                    </tr>
                                                    <?php 
														}
													?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                            <?php	
								}
							?>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top"><input type="submit" value="Submit" class="button" name="btnsubmit" id="btnsubmit" />
                            <input type="button" value="Cancel" class="button" name="btncancel" id="btncancel" onclick="javascript:window.location.href='user-rights-list.php';" /></td>
                        </tr>
                      </table>
                    </form>
                    <?php 
						}
						else {
					?>
                    	<table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn user-role" width="100%">
                        <tr>
                          <td align="left" valign="top" width="150">&nbsp;</td>
                          <td align="left" valign="top">
                          	<?php 
								if ( is_array($armenu) && count($armenu) ) {
							?>
                            		<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    	<tr>
                                        	<td align="left" valign="top" class="user-role-name">
                                            	<?php echo $cmn->getval($aruser_role[0]['user_role_name']); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td align="left" valign="top" height="10"></td>
                                        </tr>
                                        <tr>
                                        	<td align="left" valign="top">
                                            	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                	<tr>
                                                    	<th width="17%" align="left" valign="top">MENU</th>
                                                        <th width="17%" align="center" valign="top">VIEW DETAILS</th>
                                                        <th width="17%" align="center" valign="top">ADD RECORDS</th>
                                                        <th width="17%" align="center" valign="top">EDIT RECORDS</th>
                                                        <th width="17%" align="center" valign="top">DELETE RECORDS</th>
                                                        <th width="16%" align="center" valign="top">EXPORT TO CSV</th>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left" valign="top" height="10"></td>
                                                    </tr>
                                                    <?php 
														$inttotal_menu = count($armenu);
														for ( $intcounter = 0; $intcounter < $inttotal_menu; $intcounter++ ) {
													?>
                                                    <tr>
                                                    	<td align="left" valign="top">
                                                        	<?php echo $cmn->getval($armenu[$intcounter]['menu_name']); ?>
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '1'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 1); ?> disabled="disabled" />
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '2'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 2); ?> disabled="disabled" />
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '3'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 3); ?> disabled="disabled" />
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '4'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 4); ?> disabled="disabled" />
                                                        </td>
                                                        <td align="center" valign="top">
                                                        	<input type="checkbox" name="chkrights[]" id="chkrights[]" value="<?php echo (int) $armenu[$intcounter]['menu_id'] . '|' . '6'; ?>" <?php echo $objuser_rights->set_checked_status($aruser_rights, (int) $armenu[$intcounter]['menu_id'], 6); ?> disabled="disabled" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="left" valign="top" height="10"></td>
                                                    </tr>
                                                    <?php 
														}
													?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                            <?php	
								}
							?>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top">
                            <input type="button" value="Back" name="btnback" id="btnback" onclick="javascript:window.location.href='user-rights-list.php';" /></td>
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
