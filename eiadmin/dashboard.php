<?php 
	require_once 'include/general-includes.php';
	$cmn->is_authorized('index.php', trim($_SERVER['REQUEST_URI']));
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
    <td height="100%" valign="top" class="content-background">
      <div class="content">
      <table cellpadding="0" cellspacing="0" width="100%">
        <tr valign="top">
          <td class="main-content">
          	  
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <tr>
                    <td align="left" valign="top" class="box-heading"><h2>Dashboard</h2></td>
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
                    <td align="left" valign="top" class="dashboard">
                      <div> 
                        <a href="dashboard.php"><img src="<?php echo ADMIN_THEME; ?>images/icons/dashboard.png" alt="Dashboard" title="Dashboard" /><br/>
                        Dashboard</a>
                      </div>
                      <?php 
					  	if ( is_array($armenu_main) && count($armenu_main) ) {
							$inttotal_menu = count($armenu_main);
							for ( $intcounter = 0; $intcounter < $inttotal_menu; $intcounter++ ) {
					 ?>
                     			<div> 
                                   <a href="<?php echo $cmn->getval($armenu_main[$intcounter]['listing_page']); ?>"><img src="<?php echo ADMIN_THEME . $cmn->getval($armenu_main[$intcounter]['menu_icon']); ?>" alt="<?php echo $cmn->getval($armenu_main[$intcounter]['menu_name']); ?>" title="<?php echo $cmn->getval($armenu_main[$intcounter]['menu_name']); ?>" /><br/>
                                   <?php echo $cmn->getval($armenu_main[$intcounter]['menu_name']); ?></a>
                                </div>
                     <?php	
							}	
						}
					  ?>
                      <div> 
                        <a href="change-password.php"><img src="<?php echo ADMIN_THEME; ?>images/icons/change-password.png" alt="Change Password" title="Change Password" /><br/>
                       Change Password</a>
                      </div>
                      <div> 
                        <a href="logout.php"><img src="<?php echo ADMIN_THEME; ?>images/icons/logout.png" alt="Logout" title="Logout" /><br/>
                       Logout</a>
                      </div>
                    </td>
                  </tr>
               </table>
              
          </td>
        </tr>
      </table>        
      </div>
    </td>
  </tr>
  <tr>
    <td valign="middle" height="40" class="footer-main"><?php require_once 'include/footer.php'; ?></td>
  </tr>
</table>
</body>
</html>
