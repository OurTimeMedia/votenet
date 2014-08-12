<?php
	ob_start();
	session_start();
	error_reporting (E_ALL ^  E_NOTICE);
	$link = mysql_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD) or die(mysql_error());
	mysql_select_db(DATABASE_NAME) or die(mysql_error());
?>