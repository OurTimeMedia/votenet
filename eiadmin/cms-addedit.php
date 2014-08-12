<?php
	require_once 'include/general-includes.php';
	require_once 'class/cms.class.php';
	require_once 'fckeditor/fckeditor.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));

	//code to assign primary key to main variable...
	$cms_id = 0;
	if (isset($_REQUEST['cms_id']) && trim($_REQUEST['cms_id'])!='')
		$cms_id = $_REQUEST['cms_id'];

	//set mode...
	$strmode='add';
	if(isset($_REQUEST['mode']))
		$strmode = trim($_REQUEST['mode']);

	//code to check record existance in case of edit...
	$record_condition = '';
	if ($strmode=='edit' && !($cmn->is_record_exists('cms', 'cms_id', $cms_id, $record_condition)))
		$msg->send_msg('cms-list.php','',46);

	//create object of main entity...
	$objcms = new cms();

	//include db file here...
	require_once 'cms-db.php';

	if(isset($_SESSION['err']))
	{
		$objcms->cms_id			= (int) $cms_id;
		$objcms->cms_title		= $cmn->getval(trim($cmn->read_value($_POST['txtcms_title'],'')));
		$objcms->cms_sub_title	= $cmn->getval(trim($cmn->read_value($_POST['txtcms_sub_title'],'')));
		
		$objcms->seo_url		= $cmn->getval(trim($cmn->read_value($_POST['txtseo_url'],'')));
		$objcms->ext_url		= $cmn->getval(trim($cmn->read_value($_POST['txtext_url'],'')));
		$objcms->parent			= $cmn->getval(trim($cmn->read_value($_POST['parent'],'')));
		
		$objcms->cms_content	= $cmn->getval(trim($cmn->read_value($_POST['txtcms_content'],'')));
		$objcms->meta_title		= $cmn->getval(trim($cmn->read_value($_POST['txtmeta_title'],'')));
		$objcms->meta_desc		= $cmn->getval(trim($cmn->read_value($_POST['txtmeta_desc'],'')));
		$objcms->meta_keywords	= $cmn->getval(trim($cmn->read_value($_POST['txtmeta_keywords'],'')));
		$objcms->cms_active		= $cmn->getval(trim($cmn->read_value($_POST['rdocms_active'],'')));
		$objcms->front_menu		= $cmn->getval(trim($cmn->read_value($_POST['front_menu'],'')));
	}
	else
	{
		if($strmode=='edit')
			$objcms->setallvalues($cms_id);
	}
	
	$objfck = new FCKeditor("txtcms_content");
	$objfck->BasePath = "fckeditor/";
	$objfck->Height = "500";
	$objfck->Width = "800";
	$objfck->Value = $objcms->cms_content;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ADMIN_PANEL_PAGE_TITLE; ?></title>
<?php require_once 'include/theme.php'; ?>
<script language="javascript" type="text/javascript" src="js/validation.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script language="javascript" type="text/javascript">
	function validate(){
		var index = 0;
		var arValidate = new Array;
		arValidate[index++] = new Array("R", "document.frm.txtcms_title", "title");
		arValidate[index++] = new Array("L", "document.frm.txtseo_url", "seo url");
		
		if(document.frm.txtext_url.value != '')
			arValidate[index++] = new Array("W", "document.frm.txtext_url", "external url");
		
		if (!Isvalid(arValidate)){
			return false;
		}
		
		if(document.frm.txtext_url.value == '' && document.frm.txtseo_url.value == '')
		{
			alert('Please provide seo or external url.');
			return false;
		}
		else if(document.frm.txtext_url.value != '' && document.frm.txtseo_url.value != '')
		{
			alert('Please provide either seo or external url.');
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
                  <td align="left" valign="top" class="box-heading"><h2>CMS</h2></td>
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
                          <td align="left" valign="top"width="150"><label>Title:<?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txtcms_title" class="textbox" id="txtcms_title" value="<?php echo htmlspecialchars($objcms->cms_title); ?>" maxlength="100" /></td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
						
                        <tr>
                          <td align="left" valign="top"width="150"><label>Sub title:</label></td>
                          <td align="left" valign="top"><input type="text" name="txtcms_sub_title" class="textbox" id="txtcms_sub_title" value="<?php echo htmlspecialchars($objcms->cms_sub_title); ?>" maxlength="100" /></td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
							<td align="left" valign="top"width="150"><label>SEO URL:</label></td>
							<td align="left" valign="top"><?php echo $SITE_URL; ?><input type="text" name="txtseo_url" class="textbox" id="txtseo_url" value="<?php echo htmlspecialchars($objcms->seo_url); ?>" maxlength="100" /> <span class="red-text">Use only A-Z, a-z, 0-9, -, _</span> </td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10">&nbsp;</td>
						  <td align="left" valign="top" height="10"><b>OR</b></td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
						
                        <tr>
							<td align="left" valign="top"width="150"><label>External URL:</label></td>
							<td align="left" valign="top"><input type="text" name="txtext_url" class="textbox" id="txtext_url" value="<?php echo htmlspecialchars($objcms->ext_url); ?>" maxlength="100" /> <span class="red-text">Full URL of external site (e.g. http://www.google.com)</span> </td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
							<td align="left" valign="top"width="150"><label>Link to existing cms:</label></td>
							<td align="left" valign="top">
								<select name="link_to_cms" id="link_to_cms" class="selectbox">
									<option value="0">No link</option>
									<?php echo $cmn->fillcombo(DB_PREFIX.'cms', '', 'cms_id', 'cms_title', $objcms->link_to_cms); ?>
								</select>
							</td>
                        </tr>
						
						<tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
							<td align="left" valign="top"width="150"><label>Parent cms:</label></td>
							<td align="left" valign="top">
								<select name="parent" id="parent" class="selectbox">
									<option value="0">No parent</option>
									<?php echo $objcms->getCmsCombo($objcms->parent); ?>
								</select>
							</td>
                        </tr>
						
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"width="150"><label>Content:</label></td>
                          <td align="left" valign="top">
                          	<?php echo $objfck->Create(); ?>
                          </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"width="150"><label>Meta Title:</label></td>
                          <td align="left" valign="top"><input type="text" name="txtmeta_title" class="textbox" id="txtmeta_title" value="<?php echo htmlspecialchars($objcms->meta_title); ?>" maxlength="100" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"width="150"><label>Meta Description:</label></td>
                          <td align="left" valign="top"><textarea name="txtmeta_desc" id="txtmeta_desc" class="textbox" style="width:650px;height:150px;"><?php echo htmlspecialchars($objcms->meta_desc); ?></textarea></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"width="150"><label>Meta Keywords:</label></td>
                          <td align="left" valign="top"><textarea name="txtmeta_keywords" id="txtmeta_keywords" class="textbox" style="width:650px;height:150px;"><?php echo htmlspecialchars($objcms->meta_keywords); ?></textarea></td>
                        </tr>
						<tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Display in front menu?:</label></td>
                        <td align="left" valign="top"><input checked="checked" type="radio" name="front_menu" id="front_menu_y" value="y" <?php if($objcms->front_menu=='y') echo 'checked="checked"'; ?>/>
                            Yes
                            <input type="radio" name="front_menu" id="front_menu_n" value="n" <?php if($objcms->front_menu=='n') echo 'checked="checked"'; ?>/>
                            No </td>
                      </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"width="150"><label>Active?:</label></td>
                          <td align="left" valign="top"><input checked="checked" type="radio" name="rdocms_active" id="rdocms_active" value="y" <?php if($objcms->cms_active=='y') echo 'checked="checked"'; ?>/>
                            Yes
                            <input type="radio" name="rdocms_active" id="rdocms_active" value="n" <?php if($objcms->cms_active=='n') echo 'checked="checked"'; ?>/>
                            No </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top"><input type="submit" name="btnsubmit" class="button" id="btnsubmit" value="Save"/>
                            <input type="button" name="btncancel" class="button" id="btncancel" onclick="javascript:window.location.href='cms-list.php'" value="Cancel" /></td>
                        </tr>
                      </table>
                    </form>
                    <?php 
						}
					else {
					?>
                    <table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn view-table" width="550">
                      <tr>
                        <td align="left" valign="top"width="150"><label>Title:<?php echo REQUIRED; ?></label></td>
                        <td align="left" valign="top"><?php echo htmlspecialchars($objcms->cms_title); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Content:<?php echo REQUIRED; ?></label></td>
                        <td align="left" valign="top"><?php echo $objcms->cms_content; ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Meta Title:</label></td>
                        <td align="left" valign="top"><?php echo htmlspecialchars($objcms->meta_title); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Meta Desc:</label></td>
                        <td align="left" valign="top"><?php echo htmlspecialchars($objcms->meta_desc); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Meta Keywords:</label></td>
                        <td align="left" valign="top"><?php echo htmlspecialchars($objcms->meta_keywords); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Display in front menu?:</label></td>
                        <td align="left" valign="top"><?php echo strtoupper(htmlspecialchars($objcms->front_menu)); ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Active?:</label></td>
                        <td align="left" valign="top"><?php echo strtoupper(htmlspecialchars($objcms->cms_active)); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top"><input type="button" name="btnback" class="button" id="btnback" onclick="javascript:window.location.href='cms-list.php'" value="Back" /></td>
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
<script type="text/javascript" language="javascript">
	document.getElementById('txtcms_title').focus();
</script>
</body>
</html>