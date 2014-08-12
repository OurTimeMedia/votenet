<?PHP

require_once 'include/general_includes.php';

	$sQuery  =  "SELECT site_config_isonline,site_config_offline_message,site_config_image FROM " . DB_PREFIX . "site_config WHERE site_config_id = '1'";
	$rs = mysql_query($sQuery);
	$res = mysql_fetch_array($rs);

	if($res["site_config_isonline"]==1)
	{
		$offline_message =  $res["site_config_offline_message"];
		$site_config_image =  $res["site_config_image"];
	}
	else
	{
		$offline_message = "Site is working fine. Please use your provided URL to access contest panel.";
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php print SITE_TITLE;?></title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<div class="page_mn">
  <div class="login_mn">
    <div class="login_header_mn">
      <div class="login_logo"><a href="#"><img src="images/logo.png" alt="" /></a></div>
      <div class="login_rt_txt"><img src="images/right_title.png" alt="" /></div>
    </div>
    <div class="login_cont_mn">
    	<table cellpadding="0" cellspacing="0" align="center" style="padding-top:100px;">
        <tr valign="top">
          <td>
    	<?PHP echo htmlspecialchars($offline_message); ?>
        </td>
        </tr>
        <tr>
        	<td>&nbsp;
            	
            </td>
        </tr>
        <tr valign="top">
          <td align="center">
        <?php 	
                  if (!empty($site_config_image)) {
                  	
						?>
							
							<img src='<?php echo SERVER_HOST ?>common/files/image.php/<?php echo $site_config_image?>?image=/files/maintanance/<?php echo $site_config_image?>' alt=''  title=''/>
			<br/><br/>
						<?php
						
                  }
                  ?>
          </td>
        </tr>
        </table>
    </div>
   </div>
  </div>
 </body>
 </html>
  