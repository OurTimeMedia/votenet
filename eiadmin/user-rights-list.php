<?php 
	require_once 'include/general-includes.php';
	require_once 'class/clsuser-rights.php';
	require_once 'class/clsuser-role.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));
	
	$objuser_rights 			=	new user_rights();
	$objuser_role 			=	new user_role();
	$objpaging		=	new paging();
	require_once 'user-rights-db.php';
	$cond = " AND 1=1";
	$searchparent = "";
	if ( isset($_GET['txtsearch']) && trim($_GET['txtsearch']) != '' )
	{
		$cond .= " AND ( user_role_name like '%" . $cmn->setval($_GET['txtsearch']) . "%' )";
	}
	//$cond = " and 1=2 ";
	$objpaging->strorderby = "user_role_id";
	$objpaging->strorder = "desc";
	$arrw=$objpaging->set_page_details($objuser_role,"user-rights-list.php",PAGESIZE,$cond);
	$array_lookup_table=array( array("table"=>"user","field"=>"user_role_id"));
	$inttotal_column = 1;
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
                  <td align="left" valign="top" class="box-heading"><h2>User Rights</h2></td>
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
                                              <td align="left" valign="middle"><strong style="font-size:13px;">User Role:</strong> &nbsp; </td>
                                              <td align="left" valign="top" width="5"></td>
                                              <td align="left" valign="top"><input type="text" name="txtsearch" class="textbox" id="txtsearch" value="<?php if ( isset($_GET['txtsearch']) ) echo htmlspecialchars($_GET['txtsearch']); ?>" maxlength="200" /></td>
                                              <td align="left" valign="top" width="5"></td>
                                              <td align="left" valign="top"><input type="submit" name="btnsearch" class="button" id="btnsearch" value="Search" /></td>
                                              <td align="left" valign="top" width="5"></td>
                                              <td align="left" valign="top"><input type="button" name="btnreset" class="button" id="btnreset" value="Reset" onclick="javascript:window.location.href='user-rights-list.php';" /></td>
                                            </tr>
                                          </table>
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
                                      <?php 
									  	if ( $user_rights_array['delete'] ) {
											$inttotal_column++;
									  ?>
                                      <th align="center" valign="top" width="10%">
									  	<input type="checkbox" name="chkselect_unselect_all" id="chkselect_unselect_all" value="" onclick="javascript:setdelete_checkbox(this.checked);" />
									  </th>
                                      <?php 
										}
									  ?>
                                      <th align="left" valign="top"> User Role<?php $objpaging->_sortimages("user_role_name", $cmn->getcurrentpagename()); ?> </th>
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
												$arrayuser_role_ids[] = $rw['user_role_id'];
									?>
													<tr class="<?php echo $rowclass; ?>">
                                                      <?php 
													  	if ( $user_rights_array['delete'] ) {
													  ?>
                                                      <td align="center" valign="middle" height="25">
													  	<input type="checkbox" name="deletedids[]" id="deletedids" value="<?php echo (int) $rw['user_role_id']; ?>" />
													  </td>
                                                      <?php 
														}
													  ?>
													  <td align="left" valign="middle" height="25">
													  	<a  class="edit" href="user-rights-addedit.php?mode=edit&user_role_id=<?php echo (int) $rw['user_role_id']; ?>">
															<?php echo $cmn->getval($rw['user_role_name']); ?>
														</a>
													  </td>
													</tr>
                                    <?php 
											}
											$inactiveids = implode(",",$arrayuser_role_ids);
									?>
                                    		<tr>
											  <?php 
											  	if ( $user_rights_array['delete'] ) {
											  ?>
                                              <td align="center" valign="middle" height="25"><input type="button" name="btndelete" class="button" id="btndelete" value="Delete" onclick="javascript: set_action('delete','user rights');" /></td>
											  <?php 
												}
											  ?>
                                              <td align="left" valign="middle" height="25">
                                              	<?php 
													if ( $user_rights_array['export'] ) {
												?>
	                                                <input type="button" name="btnexport" class="button" id="btnexport" value="Export to CSV" onclick="javascript: set_action('export','user rights');" />
                                               	<?php 
													}
												?>
												<input type="hidden" name="hdnmode" value="" />
												<input type="hidden" name="inactiveids" value="<?php print $inactiveids; ?>" />
												<input type="hidden" name="cpage" value="<?php print $cpage; ?>">
											  </td>
											</tr>
									<?php
										}
										else {
									?>
											<tr class="background1">
											  <td align="center" valign="middle" height="25" colspan="<?php echo $inttotal_column; ?>">
												 <em>No user role(s) found.</em>
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