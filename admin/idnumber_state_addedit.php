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
	if (strtolower($mode)=="edit" && !($cmn->isRecordExists("idnumber_state", "state_id", $state_id,  $record_condition)))
	{
		$msg->sendMsg("idnumber_state_list.php","",46);
	}	
	//END CHECK
	$objIdNumber = new id_number();
	$objstate = new state();
	$objStateIdNumber = new idnumber_state();
	$arrState = $objstate->fetchAllAsArray();
	$arrIdnumber = $objIdNumber->fetchAllAsArray();

	
	
	include "idnumber_state_db.php";
	

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
		$objStateIdNumber->state_id = $state_id;
		$Idnumberdata=$objStateIdNumber->fetchAllAsArray($condition);
		$cancel_button ="javascript: window.location.href='idnumber_state_detail.php?state_id=".$state_id."';";
		$objstate->setAllValues($state_id);
	}
	else
	{
		$objStateIdNumber->state_id = 0;
		$condition = " AND state_id not in (select state_id from ".DB_PREFIX."idnumber_state) ";
		$arrState = $objstate->fetchAllAsArray("", $condition);
		
		$cancel_button ="javascript: window.location.href='idnumber_state_list.php';";
	}
	
	$extraJs = array("idnumber_state.js","jquery-ui-1.8.4.custom.min.js","jquery-ui-1.8.custom.min.js","draganddrop.js");//,"jquery-1.4.2.min.js"
	$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","div_addremove.css","devheart-examples.css");
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
              <div class="fleft"><?php if($mode==EDIT) { print "Edit State - ID Number Detail"; } else { print "Create State - ID Number Detail"; } ?></div>
              <div class="fright"> 
               <?php 
               		if ($mode==EDIT) 
               		{
               			print $cmn->getAdminMenuLink("idnumber_state_detail.php","idnumber_state_detail","Back","?state_id=".$state_id,"back.png",false); 
               		
               		}
               		else 
               		{
               			print $cmn->getAdminMenuLink("idnumber_state_list.php","idnumber_state_list","Back","","back.png",false); 
               		}
               ?>
              
               </div>
            </div>
          
        </div>
        <div class="blue_title_cont">
         <?php include SERVER_ADMIN_ROOT."idnumber_state_form.php";?>
        </div>
      </div>
    </div>
</div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
