<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	
	$blockuser_id = 0;
		
	if (isset($_REQUEST['hdnblockuser_id']) && trim($_REQUEST['hdnblockuser_id'])!="")
		$blockuser_id = $_REQUEST['hdnblockuser_id'];
		
	//set mode...
	$mode = ADD;
	if ($blockuser_id > 0)
		$mode = EDIT;
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("block_user", "blockuser_id", $blockuser_id, $record_condition)))
		$msg->sendMsg("security_block_user.php","",46);
		  
	//END CHECK

	$objSecurityBlockUser = new security_block_user();
	$objUser = new user();
	include SERVER_ADMIN_ROOT."security_block_user_db.php";
	
	$cancel_button = "javascript: window.location.href='security_block_user.php';";
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include_once "security_block_user_field.php";

		// Set red border for error fields
		$err_fields = split("\|", $_SESSION["err_fields"]);
		unset($_SESSION["err_fields"]);
		for ($i=0;$i<count($err_fields);$i++)
		{
			$err_fields[$i] = "class_".$err_fields[$i];
			$$err_fields[$i] = "input-red-border";
		}
	}
	
	$extraJs = array("security.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
	
	
	$resUsersArr = $objUser->fetchAllAsArray();
	$userNames = "";
	for($i=0;$i<count($resUsersArr);$i++)
	{
		$userNames.=$resUsersArr[$i]["user_username"].",";
	}
?>

<div class="content_mn">
    <div class="cont_mid">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
               <div class="blue_title_rt">
                  <div class="fleft"><?php if ($mode==EDIT) { print "Edit User Name"; } else { print "Add User Name"; } ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getAdminMenuLink("security_block_user.php","security_block_user","Back","","back.png",false); 
                   		
                   ?>
                  
                   </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <?php include SERVER_ADMIN_ROOT."security_block_user_form.php";?>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
<script type="text/javascript" language="javascript">
document.getElementById('txtuser').focus();
</script>