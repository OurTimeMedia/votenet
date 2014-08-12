<?php
	require_once 'include/general-includes.php';
	require_once 'class/clssite-config.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));

	//code to assign primary key to main variable...
	$site_config_id = 1;
	
	//set mode...
	$strmode='edit';

	//code to check record existance in case of edit...
	$record_condition = '';
	if ($strmode=='edit' && !($cmn->is_record_exists('site_config', 'site_config_id', $site_config_id, $record_condition)))
		$msg->send_msg('dashboard.php','',46);

	//create object of main entity...
	$objsite_config = new site_config();

	//include db file here...
	require_once 'site-config-db.php';

	$objsite_config->setallvalues($site_config_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ADMIN_PANEL_PAGE_TITLE; ?></title>
<?php require_once 'include/theme.php'; ?>
<script language="javascript" type="text/javascript" src="js/validation.js"></script>
<script language="javascript" type="text/javascript">
	function validate(){
		var index = 0;
		var arValidate = new Array;
		arValidate[index++] = new Array("R", "document.frm.txtadmin_name", "admin name");
		arValidate[index++] = new Array("R", "document.frm.txtadmin_email", "admin email");
		arValidate[index++] = new Array("E", "document.frm.txtadmin_email", "admin email");
		arValidate[index++] = new Array("R", "document.frm.txtfrom_name", "from name");
		arValidate[index++] = new Array("R", "document.frm.txtfrom_email", "from email");
		arValidate[index++] = new Array("E", "document.frm.txtfrom_email", "from email");
		arValidate[index++] = new Array("E", "document.frm.txtsales_email", "sales email");
		/*arValidate[index++] = new Array("R", "document.frm.txtstreet", "street");
		arValidate[index++] = new Array("R", "document.frm.txttown", "town");
		arValidate[index++] = new Array("R", "document.frm.txtstate", "state");
		arValidate[index++] = new Array("R", "document.frm.txtzipcode", "zipcode");
		arValidate[index++] = new Array("R", "document.frm.txtphone", "phone number");
        arValidate[index++] = new Array("R", "document.frm.txtfax", "fax number"); */
		
		if(document.frm.facebook_url.value != '')
			arValidate[index++] = new Array("W", "document.frm.facebook_url", "facebook URL");
		
		if(document.frm.twitter_url.value != '')
			arValidate[index++] = new Array("W", "document.frm.twitter_url", "twitter URL");
			
		if(document.frm.blog_url.value != '')
			arValidate[index++] = new Array("W", "document.frm.blog_url", "blog RSS URL");
		
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
            <td class="main-content"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td align="left" valign="top" class="box-heading"><h2>Site Config.</h2></td>
                </tr>
                <tr>
                  <td align="left" valign="top" height="15"></td>
                </tr>
                <?php 
							if ( isset($_SESSION['err']) ) {
						?>
                <tr>
                  <td align="left" valign="top"><?php $msg->display_msg(); ?></td>
                </tr>
                <?php	
							}
						?>
                <tr>
                  <td align="left" valign="top"><form name="frm" id="frm" method="post" action="<?php echo trim($_SERVER['REQUEST_URI']); ?>" onsubmit="javascript: return validate();">
                      <table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn" width="100%">
                        <tr>
                          <td align="right" valign="top" class="required-sentence" colspan="2"><?php echo REQUIRED_SENTENCE; ?></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" width="250"><label>Admin Name:<?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtadmin_name" class="textbox" id="txtadmin_name" value="<?php echo htmlspecialchars($objsite_config->admin_name); ?>" maxlength="50" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Admin Email:<?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtadmin_email" class="textbox" id="txtadmin_email" value="<?php echo htmlspecialchars($objsite_config->admin_email); ?>" maxlength="100" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>From Name:<?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtfrom_name" class="textbox" id="txtfrom_name" value="<?php echo htmlspecialchars($objsite_config->from_name); ?>" maxlength="50" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>From Email:<?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtfrom_email" class="textbox" id="txtfrom_email" value="<?php echo htmlspecialchars($objsite_config->from_email); ?>" maxlength="100" /></td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Sales Email:</label></td>
                          <td align="left" valign="top"><input type="text" name="txtsales_email" class="textbox" id="txtsales_email" value="<?php echo htmlspecialchars($objsite_config->sales_email); ?>" maxlength="100" /></td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        
						<tr>
                          <td align="left" valign="top"><label>Street:</label></td>
                          <td align="left" valign="top"><input type="text" name="txtstreet" class="textbox" id="txtstreet" value="<?php echo htmlspecialchars($objsite_config->street); ?>" maxlength="250" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Town:</label></td>
                          <td align="left" valign="top"><input type="text" name="txttown" class="textbox" id="txttown" value="<?php echo htmlspecialchars($objsite_config->town); ?>" maxlength="75" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>State:</label></td>
                          <td align="left" valign="top"><input type="text" name="txtstate" class="textbox" id="txtstate" value="<?php echo htmlspecialchars($objsite_config->state); ?>" maxlength="75" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Zipcode:</label></td>
                          <td align="left" valign="top"><input type="text" name="txtzipcode" class="textbox" id="txtzipcode" value="<?php echo htmlspecialchars($objsite_config->zipcode); ?>" maxlength="50" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Phone:</label></td>
                          <td align="left" valign="top"><input type="text" name="txtphone" class="textbox" id="txtphone" value="<?php echo htmlspecialchars($objsite_config->phone); ?>" maxlength="50" /></td>
                        </tr>
                          <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top"><label>Fax:</label></td>
                            <td align="left" valign="top"><input type="text" name="txtfax" class="textbox" id="txtfax" value="<?php echo htmlspecialchars($objsite_config->fax); ?>" maxlength="50" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Copyright:</label></td>
                          <td align="left" valign="top"><input type="text" name="txtCopy" class="textbox" id="txtCopy" value="<?php echo htmlspecialchars($objsite_config->Copy); ?>" maxlength="100" /></td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Facebook URL:</label></td>
                          <td align="left" valign="top"><input type="text" name="facebook_url" class="textbox" id="facebook_url" value="<?php echo htmlspecialchars($objsite_config->facebook_url); ?>" maxlength="100" /></td>
                        </tr>
						
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Twitter URL:</label></td>
                          <td align="left" valign="top"><input type="text" name="twitter_url" class="textbox" id="twitter_url" value="<?php echo htmlspecialchars($objsite_config->twitter_url); ?>" maxlength="100" /></td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><label>Blog RSS URL:</label></td>
                          <td align="left" valign="top"><input type="text" name="blog_url" class="textbox" id="blog_url" value="<?php echo htmlspecialchars($objsite_config->blog_url); ?>" maxlength="100" /></td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
						
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top"><input type="submit" name="btnsubmit" class="button" id="btnsubmit" value="Save"/>
                            <input type="button" name="btnback" class="button" value="Cancel" id="btnback" onclick="javascript:window.location.href='dashboard.php'" /></td>
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
<script type="text/javascript" language="javascript">
	document.getElementById('txtadmin_name').focus();
</script>
</body>
</html>