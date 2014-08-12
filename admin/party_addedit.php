<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	if(isset($_REQUEST['party_id']))
		$party_id=$_REQUEST['party_id'];
	if(!isset($party_id) || $party_id <=0)
		$party_id = 0;
		
	//set mode...
	$mode = ADD;
	if ($party_id > 0)
		$mode = EDIT;
		
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	


	if (strtolower($mode)=="edit" && !($cmn->isRecordExists("party", "party_id", $party_id, $record_condition)))
	{
		$msg->sendMsg("party_list.php","",46);
	}	
	
	//END CHECK
	$objparty = new party();
	include "party_db.php";
	
	//exit;
	$cancel_button = "javascript: window.location.href='party_list.php';";
	$partyarr = array();
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		//include("party_field.php");
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
		$objparty->setAllValues($party_id , $condition);		
		$cancel_button ="javascript: window.location.href='party_detail.php?party_id=".$party_id."';";
	}
	
	$extraJs = array("party.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>
<div class="content_mn">
   <div class="cont_rt">
      <div class="user_tab_mn">
      <?php $msg->displayMsg(); ?>
        <div class="blue_title">
            <div class="blue_title_rt">
              <div class="fleft"><?php if($mode==EDIT) { print "Edit Party"; } else { print "Create Party"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("party_detail.php","party_detail","Back","?party_id=".$party_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("party_list.php","party_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."party_form.php";?>
        </div>
      </div>
    </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
