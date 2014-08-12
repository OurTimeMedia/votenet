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
	
	if(0)
	{
		echo '<pre>';
		print_r($objsite_config);
		echo '</pre>';
		
		/*
			site_config Object (
				[site_config_id] => 1
				[admin_name] => Administrator
				[admin_email] => admin@kybernetworks.com
				[from_name] => Kyber Networks
				[from_email] => sales@kybernetworks.com
				[sales_email] => sales@kybernetworks.com
				[Copy] => Copyright &copy; 2012 - kybernetworks.com. - All Rights Reserved.
				[street] => 5655 Silver Creek Valley Road, #441
				[town] => San Jose
				[state] => CA
				[zipcode] => 95138
				[phone] => (866) 267-3101
				[fax] => (408) 519-8180
				[checkedids] =>
				[uncheckedids] =>
				[create_date] => 2011-06-03 12:43:41
			)
		*/
	}
	
	$current_page = strtolower(trim(basename($_SERVER['PHP_SELF'])));