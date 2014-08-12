<?php
//include general base file
require_once("include/general_includes.php");

//check admin authentication	
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
//check action mode 
if(isset($_REQUEST['election_date_id']))
	$election_date_id=$_REQUEST['election_date_id'];
if(!isset($election_date_id) || $election_date_id <=0)
	$election_date_id = 0;

//set action mode...
$mode = ADD;
if ($election_date_id > 0)
	$mode = EDIT;
//END CHECK	

// create class objects
$objLanguage = new language();
$objElectionDate = new election_date();
$objState = new state();
$objElectionType = new election_type();
	
//fetch all language details
$condi=" and language_isactive=1 and language_ispublish=1";
$language=$objLanguage->fetchRecordSet("",$condi);

//CHECK FOR RECORED EXISTS
$record_condition = "";	
if (strtolower($mode)=="edit" && !($cmn->isRecordExists("election_date", "election_date_id", $election_date_id, $record_condition)))
{
	$msg->sendMsg("election_date_list.php","",46);
}	
//END CHECK

// include file for DB related operations
include "election_date_db.php";

//define variables
$cancel_button = "javascript: window.location.href='election_date_list.php';";
$statearr = array();
	
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
else if ($mode == EDIT) // fetch data for edit record
{
	$condition= "";
	$objElectionDate->setAllValues($election_date_id , $condition);		
	$cancel_button ="javascript: window.location.href='election_date_detail.php?election_date_id=".$election_date_id."';";
}
	//fetch all state data
	$arrState = $objState->fetchAllAsArray();
	
	//fetch all election type data
	$arrElectionType = $objElectionType->fetchAllAsArray();
	
	//include css files
	$extraCss = array("calendar.css");
	
	//include js files
	$extraJs = array("jquery-ui-timepicker-addon.min.js","election_date.js");
	
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>
<div class="content_mn">
   <div class="cont_rt">
      <div class="user_tab_mn">
      <?php $msg->displayMsg(); ?>
        <div class="blue_title">
            <div class="blue_title_rt">
              <div class="fleft"><?php if($mode==EDIT) { print "Edit Election Date"; } else { print "Create Election Date"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("election_date_detail.php","state_detail","Back","?election_date_id=".$election_date_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("election_date_list.php","state_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."election_date_form.php";?>
        </div>
      </div>
    </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
