<?php

	require_once("include/general_includes.php");
	$site_config_id = 1;
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	if (isset($_REQUEST['hdnsite_config_id']) && trim($_REQUEST['hdnsite_config_id'])!="")
		$site_config_id = $_REQUEST['hdnsite_config_id'];
		
	//set mode...
	$mode = ADD;
	if ($site_config_id > 0)
		$mode = EDIT;

	//CHECK FOR RECORED EXISTS
	$record_condition = " AND site_config_id='".$site_config_id."' ";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("site_config", "site_config_id", $site_config_id, $record_condition)))
		$msg->sendMsg("system_maintenance.php","",46);
		  
	//END CHECK

	$objSystemMaintenance = new system_maintenance();

	include SERVER_ADMIN_ROOT."system_maintenance_db.php";
	
	$cancel_button = "javascript: window.location.href='system_maintenance.php';";

	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include_once "system_maintenance_field.php";

		// Set red border for error fields
		$err_fields = explode("\|", $_SESSION["err_fields"]);
		unset($_SESSION["err_fields"]);
		for ($i=0;$i<count($err_fields);$i++)
		{
			$err_fields[$i] = "class_".$err_fields[$i];
			$$err_fields[$i] = "input-red-border";
		}
	}
	
	if ($mode == EDIT)
	{
		$objSystemMaintenance->setAllValues($site_config_id);
	}
	
	$extraJs = array("system_maintenance.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
	
?>

<div class="content_mn">
    <div class="cont_mid">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
               <div class="blue_title_rt">
                  <div class="fleft"><?php print "System Maintenance"; ?></div>
                  <div class="fright">&nbsp;</div>
              </div>
            </div>
            <div class="blue_title_cont">
             <?php include SERVER_ADMIN_ROOT."system_maintenance_form.php";?>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>