<?php	
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	
	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objClient = new client();
	$client_id = $objClient->fieldValue("client_id",$userID);

	$objWebsite = new website();
	$objWebsite->setAllValues($client_id);
	
	// $sBannerPath = SERVER_HOST . "common/files/banners/" . $objWebsite->banner_image;
	//	$sBannerPath = AMAZON_S3_LINK.BUCKET_NAME."/ElectionImpactProd/files/banners/" . $objWebsite->banner_image;
	$sBannerPath = SERVER_HOST . BANNER_IMAGE . $objWebsite->banner_image;
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php print SITE_TITLE;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo SERVER_CLIENT_HOST?>css/style.css" />
<script type="text/javascript" src="<?php echo SERVER_CLIENT_HOST?>js/common.js"></script>
<style type="text/css">
	.header_banner {
		height:280px;
		font-family:Arial, Helvetica, sans-serif;
		font-size:30px;
		color:#ffffff;
		font-weight:bold;
		padding:0px 0px 0px 20px;		
	}
	
	.banner-container {
		float:left;
		width:960px;
		overflow:hidden;
		padding:5px;
	}
</style>
</head>
<body>
<div class="banner-container">
<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" onSubmit="return designValidations();">
  <table width="950" cellspacing="0" cellpadding="0" border="0">
    <tbody>
      <tr>
        <td valign="top" align="left"><img src="<?php echo $sBannerPath; ?>" border="0"></td>
      </tr>
    </tbody>
  </table>
</form>  
</div>
</body>
</html>
