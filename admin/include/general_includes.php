<?php
session_start();
//please don't breake sequence of includes and declaration.

define("SERVER_ROOT",$_SERVER['DOCUMENT_ROOT']."/");


require_once (SERVER_ROOT."common/include/global_declarations.php");
require_once (SERVER_ROOT."common/include/connect.php");
require_once (SERVER_ROOT."common/nusoap/nusoap.php");

function __autoload($className)
{
	require_once (SERVER_ROOT."common/class/cls".$className.".php");
}

$cmn = new common();
$msg = new message();
$siteconfig = new siteconfig();
$entityID = 0;

?>