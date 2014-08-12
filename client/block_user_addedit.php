<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	
	$blockuser_id = 0;
		
	if (isset($_REQUEST['hdnblockuser_id']) && trim($_REQUEST['hdnblockuser_id'])!="")
		$blockuser_id = $objEncDec->decrypt($_REQUEST['hdnblockuser_id']);
		
	//set mode...
	$mode = ADD;
	if ($blockuser_id > 0)
		$mode = EDIT;
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("block_user", "blockuser_id", $blockuser_id, $record_condition)))
		$msg->sendMsg("block_user_list.php","",46);
		  
	//END CHECK

	$objSecurityBlockUser = new security_block_user();

	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objClient = new client();
	$objSecurityBlockUser->client_id = $objClient->fieldValue("client_id",$userID);
	
	$objUser = new user();
	include SERVER_CLIENT_ROOT."block_user_db.php";
	
	$cancel_button = "javascript: window.location.href='block_user.php';";
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include_once "block_user_field.php";

		// Set red border for error fields
		$err_fields = split("\|", $_SESSION["err_fields"]);
		unset($_SESSION["err_fields"]);
		for ($i=0;$i<count($err_fields);$i++)
		{
			$err_fields[$i] = "class_".$err_fields[$i];
			$$err_fields[$i] = "input-red-border";
		}
	
	}
	else if ($mode == EDIT)
	{
		$objSecurityBlockUser->setAllValues($blockuser_id);
		$cancel_button = "javascript: window.location.href='block_user_detail.php?blockuser_id=".$objEncDec->encrypt($blockuser_id)."';";
		
		$objSecurityBlockUser->user = $objUser->fieldValue("user_username",$objSecurityBlockUser->user_id);		
	}
	
	$extraJs = array("security.js");
	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top.php";
	
	
	$resUsersArr = $objUser->fetchAllAsArray();
	$userNames = "";
	for($i=0;$i<count($resUsersArr);$i++)
	{
		$userNames.=$resUsersArr[$i]["user_username"].",";
	} 
	
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
                  <div class="fleft"><?php if ($mode==EDIT) { print "Block User Edit"; } else { print "Block User Add"; } ?></div>
                  <div class="fright"> 
                   <?php 
				   		if ($mode==EDIT) 
                   		{
                   			print $cmn->getClientMenuLink("block_user_detail.php","block_user_detail","Back","?blockuser_id=".$objEncDec->encrypt($blockuser_id),"back.png",false); 
                   		
                   		}
                   		else 
                   		{
                   			print $cmn->getMenuLink("block_user_list.php","block_user_list","Back","","back.png",false); 
                   		}
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
             <?php  include SERVER_CLIENT_ROOT."block_user_form.php";?>
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
<script type="text/javascript" language="javascript">
document.getElementById('txtuser').focus();
</script>
</body>
</html>