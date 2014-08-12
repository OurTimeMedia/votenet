<?php
	require_once("include/general_includes.php");
	
	require_once(SERVER_ROOT."common/class/clsadminmenu.php");

	//$cmn->isAuthorized("index.php");
	
	//$cmn->checkReferral('bodystyle_list.php', 'bodystyle_list.php');
	
	$objadminmenu =	new adminmenu();
	
	$rsmenu = $objadminmenu->fetchRecordSet();
	if (isset($_REQUEST["admin_menu_parent_id"]))
		$objadminmenu->admin_menu_parent_id = $_REQUEST["admin_menu_parent_id"];
	else		
		$objadminmenu->admin_menu_parent_id = "0";
	$objadminmenu->admin_menu_order="0";
	$objadminmenu->admin_menu_isactive="1";	

	if(isset($_POST["err"]))
	{
		$objadminmenu->admin_menu_id 		= trim($_POST["admin_menu_id"]);
		$objadminmenu->admin_menu_parent_id = trim($_POST["cboadmin_menu_parent_id"]);
		$objadminmenu->admin_menu_name		= trim($_POST["txtadmin_menu_name"]);
		$objadminmenu->admin_menu_page_name	= trim($_POST["txtadmin_menu_page_name"]);
		$objadminmenu->admin_menu_module	= trim($_POST["txtadmin_menu_module"]);
		$objadminmenu->admin_menu_icon	= trim($_POST["txtadmin_menu_icon"]);
		$objadminmenu->admin_menu_order 	= trim($_POST["txtadmin_menu_order"]);
		$objadminmenu->admin_menu_isactive 	= trim($_POST["optadmin_menu_isactive"]);
		$objadminmenu->admin_menu_isvisible = trim($_POST["optadmin_menu_isvisible"]);
		
		$strmode 				= trim($_POST["mode"]);
		
	}
	elseif ( isset($_GET['admin_menu_id']) && $_GET['mode']=="edit" )
	{
		$strmode =	"edit";
		$objadminmenu->setAllValues($_GET['admin_menu_id']);
		
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php print SITE_TITLE;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo SERVER_ADMIN_HOST?>css/style.css" >
<script type="text/javascript" src="<?php echo SERVER_ADMIN_HOST?>js/common.js"></script>

<script type="text/javascript" src="<?php echo SERVER_ADMIN_HOST?>js/menu.js"></script> 

</head>

<body>
<?php include "include/top.php"; ?>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
          <div class="user_tab_mn">
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">Contest Admin Users</div>
                  <div class="fright"> <img src="<?php echo SERVER_ADMIN_ROOT?>images/add_new.png" alt="Add New Menu" title="Add New Menu" /> <a href="admin_menu.php" title="Add New Menu">Add New Menu</a></div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
              <?php if(isset($_POST["err"])){ 
        	 ($_POST["err"]!="") ? $msg->displayMsg() : "";
      } ?>
          <form name="frm" method="post" action="admin_menu_db.php" onSubmit="return submitfrm(this);" >
							<table align="left" width="100%" border="0" cellpadding="3" cellspacing="1" class="tableback">
								<tr>
									<td width="15%" height="20" align="left" valign="middle" class="tdtah11gr">Parent Menu:<?php print COMPULSORY_FIELD; ?></td>
									<td width="250" align="left" valign="middle" class="tdtah11gr">
									<select name="cboadmin_menu_parent_id" class="txtbox" id="cboadmin_menu_parent_id" style="width:250px">
											<option value="0">Select Parent Menu</option>
											<?php while($rws=mysql_fetch_array($rsmenu)){ ?>
											<option value="<?php print trim($rws["admin_menu_id"]) ?>"><?php print trim($rws["admin_menu_name"]) ?></option>
											<?php } ?>
										</select>
										<?php $cmn->setHtmlValue("document.frm.cboadmin_menu_parent_id",$objadminmenu->admin_menu_parent_id); ?>
									</td>
								</tr>
								<tr>
									<td width="15%" height="20" align="left" valign="middle" class="tdtah11gr">Menu:<?php print COMPULSORY_FIELD; ?></td>
									<td width="250" align="left" valign="middle" class="tdtah11gr"><input name="txtadmin_menu_name" type="text" class="txtbox" id="txtadmin_menu_name" style="width:250px" value="<?php print $objadminmenu->admin_menu_name;?>" maxlength="50"></td>
								</tr>
								<tr>
									<td width="15%" height="20" align="left" valign="middle" class="tdtah11gr">Page name:<?php print COMPULSORY_FIELD; ?></td>
									<td width="250" align="left" valign="middle" class="tdtah11gr"><input name="txtadmin_menu_page_name" type="text" class="txtbox" id="txtadmin_menu_page_name" style="width:250px" value="<?php print $objadminmenu->admin_menu_page_name;?>" maxlength="200"></td>
								</tr>

								<tr>
									<td width="15%" height="20" align="left" valign="middle" class="tdtah11gr">Module:<?php print COMPULSORY_FIELD; ?></td>
									<td width="250" align="left" valign="middle" class="tdtah11gr"><input name="txtadmin_menu_module" type="text" class="txtbox" id="txtadmin_menu_module" style="width:250px" value="<?php print $objadminmenu->admin_menu_module;?>" maxlength="200"></td>
								</tr>
								<tr>
									<td width="15%" height="20" align="left" valign="middle" class="tdtah11gr">Icon:<?php print COMPULSORY_FIELD; ?></td>
									<td width="250" align="left" valign="middle" class="tdtah11gr"><input name="txtadmin_menu_icon" type="text" class="txtbox" id="txtadmin_menu_icon" style="width:250px" value="<?php print $objadminmenu->admin_menu_icon;?>" maxlength="200"></td>
								</tr>
								
								<!--
								<tr>
									<td height="20" align="left" valign="middle" class="tdtah11gr">Display Order:<?php print COMPULSORY_FIELD; ?></td>
									<td align="left" valign="middle" class="tdtah11gr">&nbsp;</td>
								</tr>
								-->
								<tr>
									<td height="20" align="left" valign="middle" class="tdtah11gr">Status:<span class="tahoma11rednormal"></span></td>
									<td align="left" valign="middle" class="tdtah11gr">
										<input type="radio" name="optadmin_menu_isactive" value="0" <?php ($objadminmenu->admin_menu_isactive==0) ? print 'checked="checked"' : '' ?> /><span class="tah11gr">Inactive</span>
										<input type="radio" name="optadmin_menu_isactive" value="1" <?php ($objadminmenu->admin_menu_isactive==1) ? print 'checked="checked"' : '' ?> /><span class="tah11gr">Active</span>
									</td>
								</tr>

								<tr>
									<td height="20" align="left" valign="middle" class="tdtah11gr">Visible:<span class="tahoma11rednormal"></span></td>
									<td align="left" valign="middle" class="tdtah11gr">
										<input type="radio" name="optadmin_menu_isvisible" value="0" <?php ($objadminmenu->admin_menu_isvisible==0) ? print 'checked="checked"' : '' ?> /><span class="tah11gr">No</span>
										<input type="radio" name="optadmin_menu_isvisible" value="1" <?php ($objadminmenu->admin_menu_isvisible==1) ? print 'checked="checked"' : '' ?> /><span class="tah11gr">Yes</span>
									</td>
								</tr>
								
								<tr>
									<td height="20" align="left" valign="middle" class="tdtah11gr">Order:<span class="tahoma11rednormal"></span></td>
									<td align="left" valign="middle" class="tdtah11gr">
										<input name="txtadmin_menu_order" type="textbox" class="txtbox" value="<?php print $objadminmenu->admin_menu_order; ?>" id="txtadmin_menu_order" style="width:250px" maxlength="50">
									</td>
								</tr>
								<tr>
									<td height="20" align="left" valign="middle"  class="tdtah11gr">&nbsp;</td>
									<td height="20" align="left" valign="middle"  class="tdtah11gr"><input name="Submit" class="btn" type="submit" value="Save" title="Save"> 
									&nbsp;										
										<input name="btncancel" type="button" title="Cancel" class="btn" id="btncancel" value="Cancel" onclick="window.location.href='admin_menu_list.php'">
										<input type="hidden" name="mode" value="<?php print $strmode; ?>" />
										<input type="hidden" name="admin_menu_id" value="<?php print $objadminmenu->admin_menu_id; ?>" />
									</td>
								</tr>
							</table>
						</form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "include/footer.php";?>
</body>
</html>

