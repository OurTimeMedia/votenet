<?php
	require_once("include/general_includes.php");
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	$user_id = 0;
	if (isset($_REQUEST['hdnuser_id']) && trim($_REQUEST['hdnuser_id'])!="")
	{
		$user_id = $_REQUEST['hdnuser_id'];
		$entityID = $_REQUEST['hdnuser_id'];
	}
	//set mode...
	$mode = ADD;
	if ($user_id > 0)
		$mode = EDIT;
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if ($mode==EDIT && !($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
		$msg->sendMsg("system_admin_list.php","",46);
	//END CHECK

	$objSystemAdmin = new user();
	if($mode == ADD)
	{
		$objSystemAdmin->user_type_id = USER_TYPE_SYSTEM_ADMIN;
	}
	include "system_admin_db.php";
	$cancel_button = "javascript: window.location.href='system_admin_list.php';";
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include("system_admin_field.php");

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
		$objSystemAdmin->setAllValues($user_id);
		$cancel_button = "javascript: window.location.href='system_admin_detail.php?user_id=".$user_id."';";
	}

	$extraJs = array("system_admin.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>

<div class="content_mn">
    <div class="cont_mid">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
               <div class="blue_title_rt">
                  <div class="fleft"><?php if ($mode==EDIT) { print "Edit System Admin"; } else { print "Create System Admin"; } ?></div>
                  <div class="fright"> 
                   <?php 
                   		if ($mode==EDIT) 
                   		{
                   			print $cmn->getAdminMenuLink("system_admin_detail.php","system_admin_detail","Back","?user_id=".$user_id,"back.png",false); 
                   		
                   		}
                   		else 
                   		{
                   			print $cmn->getAdminMenuLink("system_admin_list.php","system_admin_list","Back","","back.png",false); 
                   		}
                   ?>
                  
                   </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <?php include SERVER_ADMIN_ROOT."system_admin_form.php";?>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
