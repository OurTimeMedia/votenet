<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	if(isset($_REQUEST['poll_booth_id']))
		$poll_booth_id=$_REQUEST['poll_booth_id'];
	if(!isset($poll_booth_id) || $poll_booth_id <=0)
		$poll_booth_id = 0;
		
	//set mode...
	$mode = ADD;
	if ($poll_booth_id > 0)
		$mode = EDIT;
		
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	


	if (strtolower($mode)=="edit" && !($cmn->isRecordExists("poll_booth_address", "poll_booth_id", $poll_booth_id, $record_condition)))
	{
		$msg->sendMsg("poll_booth_address_list.php","",46);
	}	
	
	//END CHECK
	$objIdNumber = new id_number();
	$objstate = new state();
	$objPollBooth = new poll_booth();
	
	$arrState = $objstate->fetchAllAsArray();
	$arrEligCrit = $objIdNumber->fetchAllAsArray();
		
	include "poll_booth_address_db.php";
	
	//exit;
	$cancel_button = "javascript: window.location.href='poll_booth_address_list.php';";
	$party_arr = array();
	
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
		$objPollBooth->setAllValues($poll_booth_id , $condition);		
		$cancel_button ="javascript: window.location.href='poll_booth_address_detail.php?poll_booth_id=".$poll_booth_id."';";
	}
	
	$extraJs = array("poll_booth_address.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>
<div class="content_mn">
   <div class="cont_rt">
      <div class="user_tab_mn">
      <?php $msg->displayMsg(); ?>
        <div class="blue_title">
            <div class="blue_title_rt">
              <div class="fleft"><?php if($mode==EDIT) { print "Edit State Voter Registration Office Location"; } else { print "Create State Voter Registration Office Location"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("poll_booth_address_detail.php","poll_booth_address_detail","Back","?poll_booth_id=".$poll_booth_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("poll_booth_address_list.php","poll_booth_address_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."poll_booth_address_form.php";?>
        </div>
      </div>
    </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
