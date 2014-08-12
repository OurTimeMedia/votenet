<?php

	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);


	$user_id = 0;
		
	if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id'])!="")
		$user_id = $_REQUEST['user_id'];
	
		//CHECK FOR RECORD EXISTS
	$record_condition = "";	
	
	if (!($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
		$msg->sendMsg("client_admin_list.php","",46);
		  
	//END CHECK

	
	$objClientAdmin = new client();
	
	$objClientAdmin->setAllValues($user_id);
	
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
	
	
	$objAdminLoginHistory = new adminhistory();
	
	$objAdminLoginHistory->user_id = $objClientAdmin->user_id;
	$objAdminLoginHistory->client_id = $objClientAdmin->client_id;
	
	$objAdminLoginHistory->setLoginHistory();
	
	
?>
<form action="<?php echo SERVER_HOST ?>client/<?PHP echo $objClientAdmin->user_username; ?>/index.php" method="POST" name="frm" id="frm">

	<input type="hidden"  id="txtuser_username" name="txtuser_username"  value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_username)) ?>" />
	
	<input type="hidden"  id="txtpassword" name="txtpassword" value="<?php echo htmlspecialchars($cmn->readValue($objClientAdmin->user_password)) ?>" />
	
	<input type="hidden" name="btnsubmit" id="btnsubmit" value="" />
</form>
<script type="text/javascript" language="javascript">
document.frm.submit();
</script>
<?php
	
	include SERVER_ADMIN_ROOT."include/footer.php";
	
?>