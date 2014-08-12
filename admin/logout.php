<?php
require_once("include/general_includes.php");
$cmn->logoutAdmin();
$msg->sendMsg(SERVER_ADMIN_HOST."index.php","Logout",6);
?>