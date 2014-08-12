<?php 
set_time_limit(0);
$domain = $_REQUEST['domain'];
//print_r($_SESSION);	
$objWebsite = new website();
$condition = " AND domain='".$domain."' ";
$client_id = $objWebsite->fieldValue("client_id","",$condition);

$index = -1;

require_once (COMMON_CLASS_DIR ."clscommon.php");
$cmn = new common();

require_once (COMMON_CLASS_DIR ."clsfield.php");
$objField = new field();
$objField->language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
$objField->client_id = $client_id;
$condition = " AND field_mapping_id='1' ";
$fieldList = $objField->fetchAllFieldFront($client_id, $condition);
require_once (COMMON_CLASS_DIR ."clsentry.php");
$objEntry = new entry();

if(isset($_SESSION['err']))
{
	echo str_replace("##imgpath##",BASE_DIR,$_SESSION['err']);
	$msg->clearMsg();
}

define("FACEBOOK_APP_ID", '390602214325653');
define("FACEBOOK_API_KEY", '390602214325653');
define("FACEBOOK_SECRET_KEY", '99a5e834c0881e9e50b2fa6305373c1c');
define("FACEBOOKAPPLICATION","Election Impact");
define("DOMAINFORFB","electionimpact.com");
?>
  <script type="text/javascript" src="../js/csspopup.js"></script>
  <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
  <script type="text/javascript" src="../js/tumb_share.js"></script>
   <div class="step-facebook1">
           	  <div class="step-facebook">
				<img src="../images/post-it-btn.jpg" alt="Post It" width="160" height="45" onclick="mypopup('facebookpostit.php')" style="cursor:pointer" />
			    <img src="../images/tweet-btn.jpg" alt="Tweet It" width="169" height="45"  onclick="mypopup('https://www.<?php echo SITE_DOMAIN_NAME;?>/voter/twitter.php?callback=<?php echo SERVER_HOST;?>')" style="cursor:pointer" />				
				</div>
				<div class="step-facebook">
				<table width="400" border="0" align="center">
					<tr>
						<td width="50%" align="center" style="padding-right: 40px;"><g:plusone size="tall" annotation="none" href="<?php echo SERVER_HOST;?>"></g:plusone>				
						<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script></td>
						<td width="50%" align="center" style="padding-right: 40px;">{$tumblr_string}</td>
					</tr>
				</table>	
				<!-- Place this tag where you want the +1 button to render -->				 

				</div>
            	<div class="step-facebook"><img src="../images/<?php echo BTN_INVITE_YOUR_FRIEND;?>" alt="Invite Your Facebook Friends" width="381" height="50" onclick="sendRequestToRecipients();" style="cursor:pointer" /></div>           	
            </div>
			<div id="blanket" style="display:none;"></div>
<div id="popUpDiv" style="display:none;">
<a href="javascript:void(0);" onclick="popup('popUpDiv')"></a>
</div>
<script language="javascript">
function mypopup(path)
{
	window.open(path, "mywindow", "location=1,status=1,top=250,left=250,  width=500,height=250");
}
function mypopup1(path)
{
	window.open(path, "mywindow", "location=1,status=1,top=250,left=250, width=639,height=600");
}				
</script>
<script type="text/javascript" src="https://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
	FB.init({
		appId  : '<?php echo FACEBOOK_APP_ID?>',
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml  : true  // parse XFBML
	});
	
	function sendRequestToRecipients() {			
        var user_ids = ""; 		
        FB.ui({
		  method: 'apprequests',
          message: 'Join me on <?php echo FACEBOOKAPPLICATION?>!',
          to: user_ids, 
        }, requestCallback);
      }
	  
	  function requestCallback(response) {        
      }	  
</script>