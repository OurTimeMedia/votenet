<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	
	$language_id = 0;
		
	if (isset($_REQUEST['hdnlanguage_id']) && trim($_REQUEST['hdnlanguage_id'])!="")
	{
		$language_id = $_REQUEST['hdnlanguage_id'];
		$entityID = $_REQUEST['hdnlanguage_id'];
	}
		
	//set mode...
	$mode = ADD;
	if ($language_id > 0)
		$mode = EDIT;
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("language", "language_id", $language_id, $record_condition)))
		$msg->sendMsg("language_list.php","",46);
		  
	//END CHECK

	$objLanguage = new language();

	include SERVER_ADMIN_ROOT."language_db.php";
	
	$cancel_button = "javascript: window.location.href='language_list.php';";
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include_once "language_field.php";

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
		$objLanguage->setAllValues($language_id);
		$cancel_button = "javascript: window.location.href='language_detail.php?language_id=".$language_id."';";
	}
	
	$extraJs = array("language.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
	
	$objResource = new resource();
	$resourceArray = $objResource->fetchAllAsArray();
?>

<div class="content_mn">
    <div class="cont_mid">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
               <div class="blue_title_rt">
                  <div class="fleft"><?php if ($mode==EDIT) { print "Edit Language"; } else { print "Create Language"; } ?></div>
                  <div class="fright"> 
                   <?php 
                   		if ($mode==EDIT) 
                   		{
                   			print $cmn->getAdminMenuLink("language_detail.php","language_detail","Back","?language_id=".$language_id,"back.png",false); 
                   		
                   		}
                   		else 
                   		{
                   			print $cmn->getAdminMenuLink("language_list.php","language_list","Back","","back.png",false); 
                   		}
                   ?>
                  
                   </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <?php include SERVER_ADMIN_ROOT."language_form.php";?>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
<script type="text/javascript" language="javascript">
document.getElementById('txtlanguage_name').focus();
</script>