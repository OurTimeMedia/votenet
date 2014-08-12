<?php
	$menu = new menu();	

	if (strpos($_SERVER['REQUEST_URI'],"registeration.php") === false) 
	{
		$cmn->isAuthorized("index.php");
	}
	
	// START Checking User Access
	$pgmame=trim($cmn->getCurrentPageName());

	$current_module = $cmn->getCurrentModule($pgmame);
	$cmn->checkAccess($pgmame, $current_module, $cmn->getFirstMenu($cmn->getSession(ADMIN_USER_ID)));
	$cmn->systemMenuAddedID = $cmn->addLatestVisit($cmn->getSession(ADMIN_USER_ID),$entityID,5);
	//	echo $current_module;
	// END Checking User Access

?>
<div class="page_mn">
  <div class="header_mn">
    <div class="logo"><a href="dashboard.php"><img alt="Election Impact" class="fleft" src="<?PHP echo SERVER_CLIENT_HOST; ?>images/logo.png"></a></div>
	<?PHP if (strpos($_SERVER['REQUEST_URI'],"registeration.php") === false) 
	{ ?>
    <div class="logout">
      <div><a href="logout.php">Logout</a></div>
    </div>
	<?PHP } ?>
       <div class="welcome-text-block">  Welcome to the Control Panel, <?php print $cmn->getSession(ADMIN_USER_DISPLAYNAME);?> <br>
       (Current Date &amp; Time: <?php print date("l, F d,Y h:iA T"); ?>) </div>
  </div>
<?php
	if (trim($cmn->readValue($current_module,""))!="")
		echo $menu->getMenu($cmn->getSession(ADMIN_USER_ID), $current_module, $cmn->defaultMenu); 
	else
		echo $menu->getMenu($cmn->getSession(ADMIN_USER_ID), "NO_MODULE_SPECIFIED");
?>


