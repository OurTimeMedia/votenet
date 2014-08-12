<?php
require_once("include/general_includes.php");
$cmn->logoutAdmin('client_admin');
$msg->sendMsg("index.php","Logout",6);
?>