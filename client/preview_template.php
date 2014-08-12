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
	<?php if(isset($_REQUEST['bgColor']) && $_REQUEST['bgColor'] != "") { ?>
	<input type="hidden" name="bgColor" id="bgColor" value="<?php echo $_REQUEST['bgColor'];?>" />
	<?php } if(isset($_REQUEST['navBgColor']) && $_REQUEST['navBgColor'] != "") { ?>
	<input type="hidden" name="navBgColor" id="navBgColor" value="<?php echo $_REQUEST['navBgColor'];?>" />
	<?php } if(isset($_REQUEST['navTextColor']) && $_REQUEST['navTextColor'] != "") { ?>
	<input type="hidden" name="navTextColor" id="navTextColor" value="<?php echo $_REQUEST['navTextColor'];?>" />
	<?php } if(isset($_REQUEST['bgImage']) && $_REQUEST['bgImage'] != "") { ?>
	<input type="hidden" name="bgImage" id="bgImage" value="1" />
	<?php } if(isset($_REQUEST['HideBanner']) && $_REQUEST['HideBanner'] != "") { ?>
	<input type="hidden" name="HideBanner" id="HideBanner" value="1" />
	<?php } if(isset($_REQUEST['HideTopNavigation']) && $_REQUEST['HideTopNavigation'] != "") { ?>
	<input type="hidden" name="HideTopNavigation" id="HideTopNavigation" value="1" />
	<?php } if(isset($_REQUEST['HideRegistrationStep']) && $_REQUEST['HideRegistrationStep'] != "") { ?>
	<input type="hidden" name="HideRegistrationStep" id="HideRegistrationStep" value="1" />
	<?php } 
	if(isset($_REQUEST['bannerImage']) && $_REQUEST['bannerImage'] != "") { ?>
	<input type="hidden" name="bannerImage" id="bannerImage" value="1" />
	<?php } ?>
</form>
<script language = "javascript">
document.frmPreview.submit();
</script>
</body>
</html>