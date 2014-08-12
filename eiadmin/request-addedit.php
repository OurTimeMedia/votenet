<?php
	require_once 'include/general-includes.php';
	require_once 'class/request.class.php';
	require_once 'fckeditor/fckeditor.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));

	//code to assign primary key to main variable...
	$id = 0;
	if (isset($_REQUEST['id']) && trim($_REQUEST['id'])!='')
		$id = $_REQUEST['id'];

	//set mode...
	$strmode='show';
	if(isset($_REQUEST['mode']))
		$strmode = trim($_REQUEST['mode']);

	//code to check record existance in case of edit...
	$record_condition = '';
	if ($strmode=='edit' && !($cmn->is_record_exists('request', 'id', $id, $record_condition)))
		$msg->send_msg('request-list.php','',46);

	//create object of main entity...
	$obj = new request();
	$obj->setallvalues($id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ADMIN_PANEL_PAGE_TITLE; ?></title>
<?php require_once 'include/theme.php'; ?>
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
                  <td align="left" valign="top" class="box-heading"><h2>Request information</h2></td>
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
					<table cellpadding="0" cellspacing="0" border="0" align="left" class="frmmn view-table" width="550">
                      <tr>
                        <td align="left" valign="top"width="150"><label>Title:</label></td>
                        <td align="left" valign="top"><?php echo htmlspecialchars($obj->title); ?></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>First name:</label></td>
                        <td align="left" valign="top"><?php echo $obj->first_name; ?></td>
                      </tr>
						<tr>
							<td align="left" valign="top"height="10"></td>
						</tr>
						<tr>
                          <td align="left" valign="top"width="150"><label>Last name:</label></td>
                          <td align="left" valign="top"><?php echo $obj->last_name; ?></td>
                        </tr>
                      <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Organization:</label></td>
                        <td align="left" valign="top"><?php echo htmlspecialchars($obj->organization); ?></td>
                      </tr>
					  
					  <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Email:</label></td>
                        <td align="left" valign="top"><?php echo htmlspecialchars($obj->email); ?></td>
                      </tr>
					  
					  <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"width="150"><label>Phone:</label></td>
                        <td align="left" valign="top"><?php echo htmlspecialchars($obj->phone); ?></td>
                      </tr>
					  <tr>
                        <td align="left" valign="top"height="10"></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top"><input type="button" name="btnback" class="button" id="btnback" onclick="javascript:window.location.href='request-list.php'" value="Back" /></td>
                      </tr>
                    </table>
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