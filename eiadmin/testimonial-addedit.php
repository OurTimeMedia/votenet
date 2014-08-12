<?php
	require_once 'include/general-includes.php';
	require_once 'class/testimonial.class.php';
	require_once 'fckeditor/fckeditor.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));

	//code to assign primary key to main variable...
	$id = 0;
	if (isset($_REQUEST['id']) && trim($_REQUEST['id'])!='')
		$id = $_REQUEST['id'];

	//set mode...
	$strmode='add';
	if(isset($_REQUEST['mode']))
		$strmode = trim($_REQUEST['mode']);

	//code to check record existance in case of edit...
	$record_condition = '';
	if ($strmode=='edit' && !($cmn->is_record_exists('testimonial', 'id', $id, $record_condition)))
		$msg->send_msg('testimonial-list.php','',46);

	//create object of main entity...
	$obj = new testimonial();

	//include db file here...
	require_once 'testimonial-db.php';

	if(isset($_SESSION['err']))
	{
		$obj->id		= (int) $id;
		$obj->title		= $cmn->getval(trim($cmn->read_value($_POST['txttitle'],'')));
		$obj->content	= $cmn->getval(trim($cmn->read_value($_POST['txtcontent'],'')));
		$obj->active	= $cmn->getval(trim($cmn->read_value($_POST['rdoactive'],'')));
		
		$obj->by_name	= $cmn->setval(trim($cmn->read_value($_FILES['txt_file']['name'],'')));
	}
	else
	{
		if($strmode=='edit')
		{
			$obj->setallvalues($id);
			
            $strfile = TESTIMONIAL_UPLOAD_DIR . $obj->by_name;
            
			if(!( file_exists($strfile) && is_file($strfile))){
                $strfile = '';
            }
			
			//echo $strfile;
		}
	}
	
	$objfck = new FCKeditor("txtcontent");
	$objfck->BasePath = "fckeditor/";
	$objfck->Height = "500";
	$objfck->Width = "800";
	$objfck->Value = $obj->content;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ADMIN_PANEL_PAGE_TITLE; ?></title>
<?php require_once 'include/theme.php'; ?>

<link rel="stylesheet" href="js/date-picker/css/jquery-ui-1.8.20.custom.css">
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/date-picker/js/jquery.ui.core.js"></script>
<script src="js/date-picker/js/jquery.ui.widget.js"></script>
<script src="js/date-picker/js/jquery.ui.datepicker.js"></script>
<script>
$(function() {
	$( "#txtdate" ).datepicker();
});
</script>

<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script language="javascript" type="text/javascript" src="js/validation.js"></script>
<script language="javascript" type="text/javascript">
	function validate(){
		var index = 0;
		var arValidate = new Array;
		arValidate[index++] = new Array("R", "document.frm.txttitle", "title");
		if (!Isvalid(arValidate)){
			return false;
		}
		return true;
	}
	
	function delete_file(){
		if(confirm('Are you sure, you want to remove this image?')){
			document.getElementById('frmtestimonialdelete').submit();
		}
	}
</script>
</head>
<body>
<form name="frmtestimonialdelete" id="frmtestimonialdelete" style="display:none;visibility:hidden;" method="post">
	<input type="hidden" name="hdnmodedeletetestimonial" id="hdnmodedeletetestimonial" value="<?php echo htmlspecialchars($obj->id); ?>" style="display:none;visibility:hidden;" />
</form>
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
                  <td align="left" valign="top" class="box-heading"><h2>Customers</h2></td>
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
                    <form name="frm" id="frm" method="post" action="<?php echo trim($_SERVER['REQUEST_URI']); ?>" onsubmit="javascript: return validate();" enctype="multipart/form-data">
                      <table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn" width="100%">
                        <tr>
                          <td align="right" valign="top" class="required-sentence" colspan="2"><?php echo REQUIRED_SENTENCE; ?></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top" height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"width="150"><label>Title:<?php echo REQUIRED; ?></label></td>
                          <td align="left" valign="top"><input type="text" name="txttitle" class="textbox" id="txttitle" value="<?php echo htmlspecialchars($obj->title); ?>" maxlength="100" /></td>
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
                          <td align="left" valign="top"width="150"><label>Image:</label></td>
                          <td align="left" valign="top">
                          	<input type="file" name="txt_file" class="textbox" id="txt_file" />
							<input type="hidden" name="txtold_file" class="textbox" id="txtold_file" value="<?php echo $obj->by_name; ?>" />
							<!--txtold_doc_file-->
							<?php if($strfile != ''){ ?>
								<a href="#" class="view" onClick="javascript:open_window('<?php echo $strfile; ?>','<?php echo $obj->by_name; ?>',500,500);"><strong>(View)</strong></a>
                                <a href="#" class="view" onClick="javascript:delete_file();"><strong>(Delete)</strong></a>
                            <?php } ?>
                          </td>
                        </tr>
						<tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"width="150"><label>Active?:</label></td>
                          <td align="left" valign="top"><input checked="checked" type="radio" name="rdoactive" id="rdoactive" value="y" <?php if($obj->active=='y') echo 'checked="checked"'; ?>/>
                            Yes
                            <input type="radio" name="rdoactive" id="rdoactive" value="n" <?php if($obj->active=='n') echo 'checked="checked"'; ?>/>
                            No </td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"height="10"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                          <td align="left" valign="top"><input type="submit" name="btnsubmit" class="button" id="btnsubmit" value="Save"/>
                            <input type="button" name="btncancel" class="button" value="Cancel" id="btncancel" onclick="javascript:window.location.href='testimonial-list.php'"  /></td>
                        </tr>
                      </table>
                    </form>
                    <?php 
						}
						else
						{
					?>
                    <table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn view-table" width="550">
                      <tr>
                        <td align="left" valign="top"width="150"><label>Title:<?php echo REQUIRED; ?></label></td>
                        <td align="left" valign="top"><?php echo htmlspecialchars($obj->title); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Content:</label></td>
                        <td align="left" valign="top"><?php echo $obj->content; ?></td>
                      </tr>
						<tr>
							<td align="left" valign="top"height="10"></td>
						</tr>
						<tr>
                          <td align="left" valign="top"width="150"><label>Image:</label></td>
                          <td align="left" valign="top">
                          	<!--txtold_doc_file-->
							<?php if($strfile != ''){ ?>
								<a href="#" onClick="javascript:open_window('<?php echo $strfile; ?>','<?php $obj->by_name; ?>',500,500);"><strong>(View)</strong></a>
                            <?php } ?>
                          </td>
                        </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Active?:</label></td>
                        <td align="left" valign="top"><?php echo strtoupper(htmlspecialchars($obj->active)); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top"><input type="button" name="btnback" class="button" id="btnback" onclick="javascript:window.location.href='testimonial-list.php'" value="Back" /></td>
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
	document.getElementById('txttitle').focus();
</script>
</body>
</html>