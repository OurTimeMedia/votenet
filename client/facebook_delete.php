<?php
require_once("include/general_includes.php");

$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$objEncDec = new encdec();	

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$clientID = $objClient->fieldValue("client_id",$userID);
	
//CHECK FOR RECORED EXISTS
$record_condition = "";	
if (!($cmn->isRecordExists("facebook_client", "client_id", $clientID, $record_condition)))
	$msg->sendMsg("facebook.php","",46);

//END CHECK

global $aClientAdminLookupTables;
	
$fb_client_id = 0;
$condition = " AND client_id = '".$clientID."'";
$objFBClient = new facebookclient();
$fb_client_id = $objFBClient->fieldValue("fb_client_id", "", $condition);

$mode=DELETE;

include "facebook_db.php";	

$extraJs = array("facebook.js");
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
?>

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
                  <div class="fleft"><?php print "Delete Facebook Application"; ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getClientMenuLink("facebook.php","facebook","Back","","back.png",false); 
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
             <?php if(isset($_POST["err"])){ 
        	 ($_POST["err"]!="") ? $msg->displayMsg() : "";
      } ?>
          <form id="frm" name="frm" method="post">
          <table cellpadding="0" cellspacing="0" width="100%" class="listtab">
				  <tr class="row01">
        			<td class="listtab-rt-bro-user" style="border-bottom:none;">If you want to delete Election Impact Facebook Application from your Facebook Page, follow below steps.</td>
                  </tr>				  
				  <tr class="row01">
        			<td class="listtab-rt-bro-user" style="border-bottom:none;"><strong>Step 1: Delete Facebook application from your Facebook page</strong><br>
					- Go to your Facebook page with admin rights and click on "Edit Page >> Manage Permissions" as mentioned in following screenshot.
					<br><img src="<?PHP echo SERVER_CLIENT_HOST ?>images/facebook-remove-1.jpg" border="0">
					<br><br>
					- Click on "Apps" link available under left panel navigation links as mentioned in following screenshot.<br><img src="<?PHP echo SERVER_CLIENT_HOST ?>images/facebook-remove-2.jpg" border="0"><br><br>
					- Remove the "Register to Vote!" application by clicking on "x" icon as mentioned in following screenshot.<br><img src="<?PHP echo SERVER_CLIENT_HOST ?>images/facebook-remove-3.jpg" border="0"><br><br>
					</td>
                  </tr>
				   <tr class="row01">
        			<td class="listtab-rt-bro-user" style="border-bottom:none;">&nbsp;</td>
                  </tr>
                  <tr class="row01">
        			<td class="listtab-rt-bro-user"><strong>Step 2: Delete Facebook Application from your Election Impact account</strong><br>- Click on "Delete" button to delete Facebook application.<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="rid" id="rid" value="<?php print $objEncDec->encrypt($rid);?>" />
          <input type="submit" id="btndelete" title="Delete" name="btndelete" value="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='facebook.php';" /></td>
                  </tr>                
                </table>
        	</form>        	
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
</div>
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>
</body>
</html>