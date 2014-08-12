<?php
	require_once 'include/general-includes.php';
	$cmn->logout_admin();
	$msg->send_msg("index.php","Logout",11);
?>