<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	if(isset($_REQUEST['state_id']))
		$state_id=$_REQUEST['state_id'];
	if(!isset($state_id) || $state_id <=0)
		$state_id = 0;
		
	//set mode...
	$mode = ADD;
	if ($state_id > 0)
		$mode = EDIT;
		
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	


	if (strtolower($mode)=="edit" && !($cmn->isRecordExists("state", "state_id", $state_id, $record_condition)))
	{
		$msg->sendMsg("state_list.php","",46);
	}	
	
	//END CHECK
	$objstate = new state();
	include "state_db.php";
	
	//exit;
	$cancel_button = "javascript: window.location.href='state_list.php';";
	$statearr = array();
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		//include("state_field.php");
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
		$condition= "";
		$objstate->setAllValues($state_id , $condition);		
		$cancel_button ="javascript: window.location.href='state_detail.php?state_id=".$state_id."';";
	}
	
	$extraJs = array("state.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>
<div class="content_mn">
   <div class="cont_rt">
      <div class="user_tab_mn">
      <?php $msg->displayMsg(); ?>
        <div class="blue_title">
            <div class="blue_title_rt">
              <div class="fleft"><?php if($mode==EDIT) { print "Edit State"; } else { print "Create State"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("state_detail.php","state_detail","Back","?state_id=".$state_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("state_list.php","state_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."state_form.php";?>
        </div>
      </div>
    </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
