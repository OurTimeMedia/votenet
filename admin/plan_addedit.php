<?php
	require_once("include/general_includes.php");
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	$plan_id = 0;
	if (isset($_REQUEST['hdnplan_id']) && trim($_REQUEST['hdnplan_id'])!="")
	{
		$plan_id = $_REQUEST['hdnplan_id'];
		$entityID = $_REQUEST['hdnplan_id'];
	}
	//set mode...
	$mode = ADD;
	if ($plan_id > 0)
		$mode = EDIT;
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if ($mode==EDIT && !($cmn->isRecordExists("plan", "plan_id", $plan_id, $record_condition)))
		$msg->sendMsg("plan_list.php","",46);
	//END CHECK
	$objPlan = new plan();
	include_once "plan_field.php";
	include SERVER_ADMIN_ROOT."plan_db.php";
	$cancel_button = "javascript: window.location.href='plan_list.php';";
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
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
		$objPlan->setAllValues($plan_id);
		$cancel_button = "javascript: window.location.href='plan_detail.php?plan_id=".$plan_id."';";
	}
	$extraJs = array("plan.js");
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
                  <div class="fleft"><?php if ($mode==EDIT) { print "Edit Plan"; } else { print "Create Plan"; } ?></div>
                  <div class="fright"> 
                   <?php 
                   		if ($mode==EDIT) 
                   		{
                   			print $cmn->getAdminMenuLink("plan_detail.php","plan_detail","Back","?plan_id=".$plan_id,"back.png",false); 
                   		
                   		}
                   		else 
                   		{
                   			print $cmn->getAdminMenuLink("plan_list.php","plan_list","Back","","back.png",false); 
                   		}
                   ?>
                  
                   </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <?php include SERVER_ADMIN_ROOT."plan_form.php";?>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
<script type="text/javascript" language="javascript">
document.getElementById('txtplan_title').focus();
</script>