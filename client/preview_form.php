<?php
require_once("include/general_includes.php");
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$objClient = new client();
$userID = $cmn->getSession(ADMIN_USER_ID);

$client_id = $objClient->fieldValue("client_id",$userID);

$objWebsite = new website();
$objWebsite->setAllValues($client_id);

if($objWebsite->is_subdomain==0) {
$previewLink = "https://".$cmn->readValueDetail($objWebsite->domain).".".SITE_DOMAIN_NAME."/index.php?sessionId=".session_id();
} else {
 $previewLink = "http://".$cmn->readValueDetail($objWebsite->domain)."/index.php";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Election Impact Control Panel</title>
</head>
<body>
<form name="frmPreview" id="frmPreview" method="post" action="<?PHP echo $previewLink; ?>">
	<input type="hidden" name="ispreview" id="ispreview" value="1" />	
	<input type="hidden" name="previewform" id="previewform" value="1" />	
</form>
<script language = "javascript">
document.frmPreview.submit();
</script>
</body>
</html>