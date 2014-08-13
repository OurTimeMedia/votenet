<?php
header('p3p: CP="NOI ADM DEV PSAi COM NAV OUR OTR STP IND DEM"');
//please don't breake sequence of includes and declaration.
if(!isset($_SESSION))
	session_start();

/*	
if($_SERVER['HTTP_X_FORWARDED_PROTO']!="https")
{
	if($_SERVER['REQUEST_URI'] != "/voter/register_vote_fb.php")
	{
		if(strpos($_SERVER['HTTP_HOST'], "electionimpact.com"))
		{
			$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			header("Location: $redirect");
			exit;
		}	
	}
}
*/

define("SERVER_ROOT",$_SERVER['DOCUMENT_ROOT']."/");
define("SERVER_HOST","http://".$_SERVER['HTTP_HOST']."/");
define("SERVER_ADMIN_HOST","http://".$_SERVER['HTTP_HOST']."/voter/");
define("SERVER_VOTER_HOST","http://".$_SERVER['HTTP_HOST']."/voter/");
define("SERVER_VOTER_ROOT",$_SERVER['DOCUMENT_ROOT']."/voter/");
define("SERVER_CLIENT_HOST","http://".$_SERVER['HTTP_HOST']."/client/");

if(isset($_REQUEST['domain']))
{
	define("CURRENT_VOTER_URL","http://".$_SERVER['HTTP_HOST']."/");
}

require_once ("include/global_declarations.php");
require_once (COMMON_INCLUDE_DIR ."connect.php");

function __autoload($className)
{	
	require_once (SERVER_ROOT."common/class/cls".$className.".php");
}
?>
