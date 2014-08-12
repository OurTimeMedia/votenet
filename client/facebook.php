<?php
require_once 'include/general_includes.php';
require_once 'include/facebook-platform/src/facebook.php';

$api_key = '234813906622727';
$api_secret_key = 'e4090273b465dfd939d8a87560b71f65';

$objEncDec = new encdec();

$objClientAdmin = new client();
$user_id = $cmn->getSession(ADMIN_USER_ID);
$client_id = $objClientAdmin->fieldValue("client_id",$user_id);

$condition = " AND ".DB_PREFIX."user.client_id = '".$client_id."'";
$client_username = $objClientAdmin->fieldValue("user_username", "", $condition);

$fb_client_id = 0;
$condition = " AND client_id = '".$client_id."'";
$objFBClient = new facebookclient();
$fb_client_id = $objFBClient->fieldValue("fb_client_id", "", $condition);

$facebook = new Facebook(array(
  'appId'  => $api_key,
  'secret' => $api_secret_key,
  'cookie' => true
));

$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$objEncDec = new encdec();

include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
?>
<script type="text/javascript">
function FbResponse(response)
{
	setTimeout("FbResponse1('"+response+"')",1500);	
}

function FbResponse1(response)
{
	if(response == 0)
	{
		alert("Facebook application not added.");
		window.location.reload();
	}
	else
	{
		alert("Facebook application added successfully.");
		window.location.reload();
	}
}
</script>
<div id="fb-root"></div>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
         <div class="user_tab_mn">
           <?php $msg->displayMsg(); ?> 
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">Facebook</div>                 
                  <div class="fright">				  
				  <?php 
				  if($fb_client_id > 0)
				  print $cmn->getMenuLink("facebook_delete.php","facebook_delete","Delete","","delete2.gif");
				  
				  ?>
				  </div>
                </div>
              </div>
            </div>           
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
								<?php if($fb_client_id == 0){ ?>
								<script src="http://connect.facebook.net/en_US/all.js"></script>
								<script>
								  FB.init({
									appId  : '<?php echo $api_key;?>',
									status : true, // check login status
									cookie : true, // enable cookies to allow the server to access the session
									xfbml  : true, // parse XFBML
									oauth  : true // enable OAuth 2.0
								  });
								</script>
								<?php if ($user) { ?>
									<table border="0">
									<tr>
									<td width="200" align="left">
									<input type="button" name="Install an application" class="btnfacebook" value="Install an application" onClick="return formSubmit();" style="margin-left: 57px;" />
									</td>
									<td align="left" valign="middle">
									Please note that, to install this application there must be Facebook Page availabel with your account. To create Facebbok page, please <a href="http://www.facebook.com/pages/create.php" target="_blank">Click Here</a>.
									</td>
									</tr>
									</table>
									<script type="text/javascript">
										function formSubmit()
										{
											// var url = "http://www.facebook.com/dialog/pagetab?app_id=<?PHP echo $api_key; ?>&next=<?php echo SERVER_HOST."facebook_integration.php?client_id=".$objEncDec->encrypt($client_id);?>";
											
											var url = "<?php echo SERVER_CLIENT_HOST.$client_username."/facebook_integration.php?client_id=".$objEncDec->encrypt($client_id);?>";
											// window.open(url,'name','height=300,width=800,left=200,top=200');		
											
											var obj = {
											  method: 'pagetab',
											  redirect_uri: url,
											  display: 'popup'
											};

											FB.ui(obj);											
										}
									</script>
									<?php
									} else { 									
									$params = array(
									  'scope' => 'publish_stream, manage_pages, offline_access',
									  'display' => 'popup'
									);
									$loginUrl = $facebook->getLoginUrl($params);
									?>
								<table cellpadding="0" cellspacing="0" border="0" width="100%"  class="table-bg" style="clear:both;" align="center" >
                                    <tr>
                                      <td align="left" valign="top" style="padding-top:20px;"><table width="95%" align="center" cellpadding="0" cellspacing="0" class="listtab">
                                        <tr class="row4">
                                          <td width="20%" class="listtab-rt-bro-user">
										  <!-- <a href="#" onclick="popup('<?php echo $loginUrl;?>')"><img src="<?php echo SERVER_CLIENT_HOST?>images/facebook-image.png"  /></a> -->
										  <fb:login-button size="large" onlogin="window.location.reload();">Connect with Facebook</fb:login-button>
										  </td>
                                        </tr>
                                      </table></td>
                                    </tr>
                                </table>													
								<?php } ?>
								</div>
								<?php } else { ?>
								<table cellspacing="0" cellpadding="0" align="center" width="95%" class="listtab">
									<tbody><tr class="row4">
									  <td align="center" width="20%" class="listtab-rt-bro-user"><strong class="txt18blue2"><br>
									  </strong>
										<table cellspacing="0" cellpadding="0" border="0" width="100%">
										  <tbody><tr>
											<td width="13%" style="border:0px; padding-left:61px;"><img width="100" height="101" src="<?php echo SERVER_CLIENT_HOST?>images/fb-logo.png"></td>
											<td align="left" width="84%" style="border:0px;"><strong class="txt18blue2">Thank you for using Facebook Application.<br>
												<br>
Facebook EI Application has been added in your Facebook page.</strong></td>
											<td width="26%" style="border:0px;">&nbsp;</td>
										  </tr>
										</tbody></table>
										<strong class="txt18blue2"><br>
<br>
									  </strong></td>
									</tr>
								  </tbody></table>
								<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include SERVER_CLIENT_ROOT."include/footer.php";?>
</body>
</html>