<?php
	//please don't beake sequence of includes and declaration.
	require_once 'server-defines.php';
	require_once 'include/global-declarations.php';
	require_once 'include/connect.php';
	require_once 'class/clscommon.php';
	require_once 'class/clsmessage.php';
	require_once 'class/clspaging.php';
	require_once 'class/clsvalidation.php';
	$GLOBALS["scope"] = 'admin';
	$cmn = new common();
	$msg = new message();
	if ( $cmn->is_admin_loggedin() ) {
		include_once 'class/clsmenu.php';
		include_once 'class/clsuser-rights.php';
		$objmenu_main = new menu();
		$objuser_rights_main = new user_rights();
		$strcondition = ' AND menu_active = \'y\' AND menu_id IN (SELECT DISTINCT menu_id FROM ' . DB_PREFIX . 'user_rights WHERE user_role_id = (SELECT user_role_id FROM ' . DB_PREFIX . 'user WHERE user_id = ' . (int) $cmn->get_session(ADMIN_USER_ID) . ' LIMIT 1))';
		$strorder = ' menu_order ASC';
		$armenu_main = $objmenu_main->fetchallasarray(NULL, NULL, $strcondition, $strorder);
		$current_page = strtolower(trim(basename($_SERVER['PHP_SELF'])));
		$arcurrent_menu = $objmenu_main->fetchallasarray(NULL, NULL, ' AND (listing_page = \'' . $current_page . '\' OR addedit_page = \'' . $current_page . '\')');
		$user_rights_array = $objuser_rights_main->get_user_rights();
		$objuser_rights_main->check_page_rights($user_rights_array);
	}