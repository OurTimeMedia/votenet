<?php 
	require_once 'include/general-includes.php';
	require_once 'class/clsmenu.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));
	
	$objmenu 			=	new menu();
	$objpaging		=	new paging();
	require_once 'menu-db.php';
	$cond = " AND 1=1";
	$searchparent = "";
	if ( isset($_GET['txtsearch']) && trim($_GET['txtsearch']) != '' )
	{
		$cond .= " AND ( menu_name like '%" . $cmn->setval($_GET['txtsearch']) . "%' )";
	}
	//$cond = " and 1=2 ";
	$objpaging->strorderby = "menu_order";
	$objpaging->strorder = "asc";
	$arrw=$objpaging->set_page_details($objmenu,"menu-list.php",PAGESIZE,$cond);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ADMIN_PANEL_PAGE_TITLE; ?></title>
<?php require_once 'include/theme.php'; ?>
<script type="text/javascript" src="js/common.js"></script>
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
                  <td style="padding:20px;">
					<form name="frm" id="frm" action="<?php echo trim($_SERVER['REQUEST_URI']); ?>" method="post" >
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
                      <tr>
                        <td align="left" valign="top" class="search-panel">
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
                        	<tr>
                            	<td align="left" valign="middle">
                                	    <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                              <td align="left" valign="middle"><strong style="font-size:13px;">Menu:</strong> &nbsp; </td>
                                              <td align="left" valign="top" width="5"></td>
                                              <td align="left" valign="top"><input type="text" name="txtsearch" class="textbox" id="txtsearch" value="<?php if ( isset($_GET['txtsearch']) ) echo htmlspecialchars($_GET['txtsearch']); ?>" maxlength="200" /></td>
                                              <td align="left" valign="top" width="5"></td>
                                              <td align="left" valign="top"><input type="submit" name="btnsearch" class="button" id="btnsearch" value="Search" /></td>
                                              <td align="left" valign="top" width="5"></td>
                                              <td align="left" valign="top"><input type="button" name="btnreset" class="button" id="btnreset" value="Reset" onclick="javascript:window.location.href='menu-list.php';" /></td>
                                            </tr>
                                          </table>
                                </td>
                                <td align="right" valign="middle">
                                	<a href="menu-addedit.php" class="new-record-link">New Menu</a>
                                </td>
                            </tr>
                        </table>
						</td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                              <tr>
                                <td align="left" valign="top" class="paging-panel"><?php print $objpaging->draw_panel("panel1");?> </td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" height="10"></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top"><table cellpadding="0" cellspacing="0" border="0" width="100%" class="listmn">
                                    <tr>
                                      <th align="center" valign="top" width="10%">
									  	<input type="checkbox" name="chkselect_unselect_all" id="chkselect_unselect_all" value="" onclick="javascript:setdelete_checkbox(this.checked);" />
									  </th>
                                      <th align="left" valign="top" width="25%"> Menu<?php $objpaging->_sortimages("menu_name", $cmn->getcurrentpagename()); ?> </th>
                                      <th align="left" valign="top" width="20%"> Listing Page<?php $objpaging->_sortimages("listing_page", $cmn->getcurrentpagename()); ?> </th>
                                      <th align="left" valign="top" width="20%"> Add/Edit Page<?php $objpaging->_sortimages("addedit_page", $cmn->getcurrentpagename()); ?> </th>
                                      <th align="right" valign="top" width="10%"> Order<?php $objpaging->_sortimages("menu_order", $cmn->getcurrentpagename()); ?> </th>
                                      <th align="center" valign="top" width="17%"> Active/Inactive<?php $objpaging->_sortimages("menu_active", $cmn->getcurrentpagename()); ?> </th>
                                    </tr>
                                    <?php 
										if (count($arrw)>0)
										{
											$rowclass="background2";
											for($i=0;$i<count($arrw);$i++)
											{
												if ($rowclass=="background1")
													$rowclass="background2";
												else
													$rowclass="background1";
												$rw=$arrw[$i];
												$arraymenu_ids[] = $rw['menu_id'];
									?>
													<tr class="<?php echo $rowclass; ?>">
													  <td align="center" valign="middle" height="25">
													  	<input type="checkbox" name="deletedids[]" id="deletedids" value="<?php echo (int) $rw['menu_id']; ?>" />
													  </td>
													  <td align="left" valign="middle" height="25">
													  	<a  class="edit" href="menu-addedit.php?mode=edit&menu_id=<?php echo (int) $rw['menu_id']; ?>">
															<?php echo $cmn->getval($rw['menu_name']); ?>
														</a>
													  </td>
                                                      <td align="left" valign="middle" height="25">
												  		<?php echo $cmn->getval($rw['listing_page']); ?>
													  </td>
                                                      <td align="left" valign="middle" height="25">
												  		<?php echo $cmn->getval($rw['addedit_page']); ?>
													  </td>
                                                      <td align="right" valign="middle" height="25">
												  		<?php echo $cmn->getval($rw['menu_order']); ?>
													  </td>
													  <td align="center" valign="middle" height="25"><input type="checkbox" name="activeids[]" id="activeids" value="<?php echo (int) $rw['menu_id']; ?>" <?php if ( $rw['menu_active'] == 'y' ) echo 'checked=checked'; ?> /></td>
													</tr>
                                    <?php 
											}
											$inactiveids = implode(",",$arraymenu_ids);
									?>
											<tr>
											  <td align="center" valign="middle" height="25"><input type="button" name="btndelete" id="btndelete" value="Delete" class="button" onclick="javascript: set_action('delete','menu');" /></td>
											  <td align="center" valign="middle" height="25" colspan="4">
												<input type="hidden" name="hdnmode" value="" />
												<input type="hidden" name="inactiveids" value="<?php print $inactiveids; ?>" />
												<input type="hidden" name="cpage" value="<?php print $cpage; ?>">
											  </td>
											  <td align="center" valign="middle" height="25"><input type="button" name="btnactive" id="btnactive" class="button" value="Save" onclick="javascript: set_action('active','menu');" /></td>
											</tr>
									<?php
										}
										else {
									?>
											<tr class="background1">
											  <td align="center" valign="middle" height="25" colspan="6">
												 <em>No menu(s) found.</em>
											  </td>
											</tr>
									<?php
										}
									?>
                                  </table></td>
                              </tr>
                            </table>
                          </td>
                      </tr>
                    </table></form></td>
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
	document.getElementById('txtsearch').focus();
</script>
</html>