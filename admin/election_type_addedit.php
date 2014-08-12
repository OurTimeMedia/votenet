<?php
	//include base file
	require_once("include/general_includes.php");
	
	//check admin login authentication
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	//fetch election type id 
	if(isset($_REQUEST['election_type_id']))
		$election_type_id=$_REQUEST['election_type_id'];
	if(!isset($election_type_id) || $election_type_id <=0)
		$election_type_id = 0;
		
	//set mode...
	$mode = ADD;
	if ($election_type_id > 0)
		$mode = EDIT;

	//fetch language data	
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	

	if (strtolower($mode)=="edit" && !($cmn->isRecordExists("election_type", "election_type_id", $election_type_id, $record_condition)))
	{
		$msg->sendMsg("election_type_list.php","",46);
	}	
	
	//END CHECK
	
	//include election type class
	$objelection_type = new election_type();
	
	// include file for DB related operations
	include "election_type_db.php";
	
	//variable define
	$cancel_button = "javascript: window.location.href='election_type_list.php';";
	$election_typearr = array();
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		//include("election_type_field.php");
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
		$objelection_type->setAllValues($election_type_id , $condition);		
		$cancel_button ="javascript: window.location.href='election_type_detail.php?election_type_id=".$election_type_id."';";
	}
		//call js files
	$extraJs = array("election_type.js");
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
              <div class="fleft"><?php if($mode==EDIT) { print "Edit Election Type"; } else { print "Create Election Type"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("election_type_detail.php","election_type_detail","Back","?election_type_id=".$election_type_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("election_type_list.php","election_type_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."election_type_form.php";?>
        </div>
      </div>
    </div>
</div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
