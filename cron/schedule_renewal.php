<?php
define("SERVER_ROOT",$_SERVER['DOCUMENT_ROOT']."/");
define("DB_PREFIX","ei_");
define("MAIN_DB_NAME","`election_impact_production`");
require_once (SERVER_ROOT."common/include/global_declarations.php");
require_once (SERVER_ROOT."common/include/connect.php");
function __autoload($className)
{
	require_once (SERVER_ROOT."common/class/cls".$className.".php");
}
	$objclient = new client();
	$objclient->renewalclientbeforeweek();
	$objclient->renewalclientbeforeoneday();
	$objclient->expireclientaccount();
?>