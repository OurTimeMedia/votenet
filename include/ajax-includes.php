<?php
	require_once 'eiadmin/include/global-declarations.php';
	require_once ADMIN_PANEL_PATH . 'include/server-defines.php';
	require_once ADMIN_PANEL_PATH . 'include/connect.php';
	require_once ADMIN_PANEL_PATH . 'class/clscommon.php';
	require_once ADMIN_PANEL_PATH . 'class/clsmessage.php';
	require_once ADMIN_PANEL_PATH . 'class/clssite-config.php';
	
	$GLOBALS['scope']	= 'front';
	$site_config_id		= 1;
	
	$cmn				= new common();
	$msg				= new message();
	$objsite_config		= new site_config();
	
	$objsite_config->setallvalues($site_config_id);