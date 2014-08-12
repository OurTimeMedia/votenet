<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	if(isset($_REQUEST['id_number_id']))
		$id_number_id=$_REQUEST['id_number_id'];
	if(!isset($id_number_id) || $id_number_id <=0)
		$id_number_id = 0;
		
	//set mode...
	$mode = ADD;
	if ($id_number_id > 0)
		$mode = EDIT;
		
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	


	if (strtolower($mode)=="edit" && !($cmn->isRecordExists("id_number", "id_number_id", $id_number_id, $record_condition)))
	{
		$msg->sendMsg("id_number_list.php","",46);
	}	
	
	//END CHECK
	$objid_number = new id_number();
	include "id_number_db.php";
	
	//exit;
	$cancel_button = "javascript: window.location.href='id_number_list.php';";
	$id_numberarr = array();
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		//include("id_number_field.php");
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
		$objid_number->setAllValues($id_number_id , $condition);		
		$cancel_button ="javascript: window.location.href='id_number_detail.php?id_number_id=".$id_number_id."';";
	}
	
	$extraJs = array("id_number.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>
<div class="content_mn">
   <div class="cont_rt">
      <div class="user_tab_mn">
      <?php $msg->displayMsg(); ?>
        <div class="blue_title">
            <div class="blue_title_rt">
              <div class="fleft"><?php if($mode==EDIT) { print "Edit ID Number"; } else { print "Create ID Number"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("id_number_detail.php","id_number_detail","Back","?id_number_id=".$id_number_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("id_number_list.php","id_number_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."id_number_form.php";?>
        </div>
      </div>
    </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
