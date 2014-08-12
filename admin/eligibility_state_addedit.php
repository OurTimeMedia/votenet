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


	if (strtolower($mode)=="edit" && !($cmn->isRecordExists("eligibility_state", "state_id", $state_id, $record_condition)))
	{
		$msg->sendMsg("eligibility_state_list.php","",46);
	}	
	
	//END CHECK
	$objEligCrit = new eligibility_criteria();
	$objstate = new state();
	$objStateElig = new eligibility_state();
	$condition=" and for_all_state<>1 ";
	$arrState = $objstate->fetchAllAsArray();
	$arrEligCrit = $objEligCrit->fetchAllAsArray('',$condition);
		
	include "eligibility_state_db.php";
	
	//exit;
	$cancel_button = "javascript: window.location.href='eligibility_state_list.php';";
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
	
	if ($mode == EDIT)
	{
		$condition= "and es.state_id= ".$state_id;
		$eligibilitycriteriadata=$objStateElig->fetchAllAsArray($condition);
		$cancel_button ="javascript: window.location.href='eligibility_state_detail.php?state_id=".$state_id."';";
		
		$objstate->setAllValues($state_id);
	}
	else
	{
		$condition = " AND state_id not in (select state_id from ".DB_PREFIX."eligibility_state) ";
		$arrState = $objstate->fetchAllAsArray("", $condition);
	}
	
	$extraJs = array("eligibility_criteria_state.js","jquery-ui-1.8.4.custom.min.js","jquery-ui-1.8.custom.min.js","draganddrop.js");
	$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","div_addremove.css","devheart-examples.css");
	

	
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
	
	
?>
<div class="content_mn">
   <div class="cont_rt">
      <div class="user_tab_mn">
      <?php $msg->displayMsg(); ?>
        <div class="blue_title">
            <div class="blue_title_rt">
              <div class="fleft"><?php if($mode==EDIT) { print "Edit State - Eligibility Criteria Join"; } else { print "Create State - Eligibility Criteria Join"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("eligibility_state_detail.php","eligibility_state_detail","Back","?state_id=".$state_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("eligibility_state_list.php","eligibility_state_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."eligibility_state_form.php";?>
        </div>
      </div>
    </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
