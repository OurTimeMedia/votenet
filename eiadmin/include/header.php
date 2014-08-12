<div class="padding-left-right header-div">
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
      <td align="left" valign="middle" class="forhm"><h1><?php echo SITE_NAME; ?> <span>Administration Panel</span></h1></td>
      <?php 
	  	if ( $cmn->is_admin_loggedin() ) {
	  ?>
        <td align="right" valign="middle">
			<?php echo date('F d, Y h:i:s A'); ?> &nbsp; | &nbsp; Welcome <?php echo $cmn->get_session(ADMIN_NAME) ?> &nbsp; <img src="<?php echo ADMIN_THEME; ?>images/adic.gif" alt="" />&nbsp; Logged in as: <strong><?php echo $cmn->get_session(ADMIN_USER_NAME) ?></strong> &nbsp; | &nbsp; <a href="logout.php">Logout</a>
        </td>
     <?php 
		}
	 ?>
    </tr>
  </table>
</div>
<?php 
	if ( $cmn->is_admin_loggedin() ) {
?>
<div class="menu-div toplinks" style="position:relative; width:100%; margin:0 auto;">
  <ul id="mycarousel" class="jcarousel-skin-tango menumnt">
	<li><a href="dashboard.php" <?php echo ('dashboard.php' == $current_page or $current_page == '') ? 'class="act"' : ''; ?>>Dashboard</a></li>
    <?php 
        if ( is_array($armenu_main) && count($armenu_main) ) {
            $inttotal_menu = count($armenu_main);
            for ( $intcounter = 0; $intcounter < $inttotal_menu; $intcounter++ )
			{
				//Applying active class for menu
				$clsClass	= ($armenu_main[$intcounter]['listing_page'] == $current_page or $armenu_main[$intcounter]['addedit_page'] == $current_page) ? 'class="act"' : '';
    ?>
                <li><a <?php echo $clsClass; ?> href="<?php echo $cmn->getval($armenu_main[$intcounter]['listing_page']); ?>"><?php echo $cmn->getval($armenu_main[$intcounter]['menu_name']); ?></a></li>                
                
    <?php	
            }	
        }
    ?>
    <li><a href="change-password.php" <?php echo ('change-password.php' == $current_page) ? 'class="act"' : ''; ?>>Change Password</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</div>
<?php 
	}