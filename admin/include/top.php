<?php
	
	$menu = new adminmenu();	

	$cmn->isAuthorized(SERVER_ADMIN_HOST."index.php", SYSTEM_ADMIN_USER_ID);
	
	// START Checking User Access
	$pgname=trim($cmn->getCurrentPageName());
	
	$current_module = $cmn->getCurrentModule($pgname);
	
	$cmn->checkAccessAdmin($pgname, $current_module, $cmn->getFirstAdminMenu($cmn->getSession(SYSTEM_ADMIN_USER_ID)));

	// END Checking User Access

	$cmn->systemMenuAddedID = $cmn->addLatestVisit($cmn->getSession(SYSTEM_ADMIN_USER_ID),$entityID);
?>
<div class="header_mn">
  <div class="logo"><a href="dashboard.php"><img src="<?php echo SERVER_ADMIN_HOST ?>images/logo.png" class="fleft" alt="Election Impact System Administrator Panel" title="Election Impact System Administrator Panel" /></a>
  </div>
  <div class="logout">
    <div> <a href="logout.php">LOGOUT</a></div>
  </div>
</div>
<?php


	if (trim($cmn->readValue($current_module,""))!="")
		echo $menu->getMenu($cmn->getSession(SYSTEM_ADMIN_USER_ID), $current_module); 
	else
		echo $menu->getMenu($cmn->getSession(SYSTEM_ADMIN_USER_ID), "NO_MODULE_SPECIFIED"); 	


?>
