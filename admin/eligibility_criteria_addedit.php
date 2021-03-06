<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	if(isset($_REQUEST['eligibility_criteria_id']))
		$eligibility_criteria_id=$_REQUEST['eligibility_criteria_id'];
	if(!isset($eligibility_criteria_id) || $eligibility_criteria_id <=0)
		$eligibility_criteria_id = 0;
		
	//set mode...
	$mode = ADD;
	if ($eligibility_criteria_id > 0)
		$mode = EDIT;
		
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	


	if (strtolower($mode)=="edit" && !($cmn->isRecordExists("eligibility_criteria", "eligibility_criteria_id", $eligibility_criteria_id, $record_condition)))
	{
		$msg->sendMsg("eligibility_criteria_list.php","",46);
	}	
	//END CHECK
	$objEligCrit = new eligibility_criteria();
	include "eligibility_criteria_db.php";
	//exit;
	$cancel_button = "javascript: window.location.href='eligibility_criteria_list.php';";
	$eligibility_criteria_arr = array();
	
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
		$condition= "";
		$objEligCrit->setAllValues($eligibility_criteria_id , $condition);		
	
	$cancel_button ="javascript: window.location.href='eligibility_criteria_detail.php?eligibility_criteria_id=".$eligibility_criteria_id."';";
	}
	$extraJs = array("eligibility_criteria.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>
<div class="content_mn">
   <div class="cont_rt">
      <div class="user_tab_mn">
      <?php $msg->displayMsg(); ?>
        <div class="blue_title">
            <div class="blue_title_rt">
              <div class="fleft"><?php if($mode==EDIT) { print "Edit Eligibility Criteria"; } else { print "Create Eligibility Criteria"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("eligibility_criteria_detail.php","eligibility_criteria_detail","Back","?eligibility_criteria_id=".$eligibility_criteria_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("eligibility_criteria_list.php","eligibility_criteria_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."eligibility_criteria_form.php";?>
        </div>
      </div>
    </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
