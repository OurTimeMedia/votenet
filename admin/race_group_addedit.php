<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	if(isset($_REQUEST['race_group_id']))
		$race_group_id=$_REQUEST['race_group_id'];
	if(!isset($race_group_id) || $race_group_id <=0)
		$race_group_id = 0;
		
	//set mode...
	$mode = ADD;
	if ($race_group_id > 0)
		$mode = EDIT;
		
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	


	if (strtolower($mode)=="edit" && !($cmn->isRecordExists("race_group", "race_group_id", $race_group_id, $record_condition)))
	{
		$msg->sendMsg("race_group_list.php","",46);
	}	
	
	//END CHECK
	$objrace_group = new race_group();
	include "race_group_db.php";
	
	//exit;
	$cancel_button = "javascript: window.location.href='race_group_list.php';";
	$race_grouparr = array();
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		//include("race_group_field.php");
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
		$objrace_group->setAllValues($race_group_id , $condition);		
		$cancel_button ="javascript: window.location.href='race_group_detail.php?race_group_id=".$race_group_id."';";
	}
	
	$extraJs = array("race_group.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>
<div class="content_mn">
<div class="content_mn2">
   <div class="cont_rt">
      <div class="user_tab_mn">
      <?php $msg->displayMsg(); ?>
        <div class="blue_title">
            <div class="blue_title_rt">
              <div class="fleft"><?php if($mode==EDIT) { print "Edit Race Group"; } else { print "Create Race Group"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("race_group_detail.php","race_group_detail","Back","?race_group_id=".$race_group_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("race_group_list.php","race_group_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."race_group_form.php";?>
        </div>
      </div>
    </div>
</div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
