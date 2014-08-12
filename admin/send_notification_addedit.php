<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	
	$notification_id = 0;
		
	if (isset($_REQUEST['hdnnotification_id']) && trim($_REQUEST['hdnnotification_id'])!="")
		$notification_id = $_REQUEST['hdnnotification_id'];
		
	//set mode...
	$mode = ADD;
	if ($notification_id > 0)
		$mode = EDIT;
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("notification", "notification_id", $notification_id, $record_condition)))
		$msg->sendMsg("send_notification_list.php","",46);
		  
	//END CHECK

	$objSendNotification = new send_notification();

	include SERVER_ADMIN_ROOT."send_notification_db.php";
	
	$cancel_button = "javascript: window.location.href='send_notification_list.php';";
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include_once "send_notification_field.php";

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
		$objSendNotification->setAllValues($notification_id);
		$cancel_button = "javascript: window.location.href='send_notification_detail.php?notification_id=".$notification_id."';";
	}
	
	$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css");
	$extraJs = array("send_notification.js","jquery-ui-1.8.4.custom.min.js","servertime.php","timymce_editor.js","jquery-ui-timepicker-addon.min.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
	
	$objUser = new user();
	$resUsersArr = $objUser->fetchAllAsArray();
	$userNames = "";
	for($i=0;$i<count($resUsersArr);$i++)
	{
		$userNames.=$resUsersArr[$i]["user_username"].",";
	}
?>


<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('#txtnotification_send_date').datetimepicker({
		minDate: new Date(),
    	ampm: true
    });
});
</script>

<div class="content_mn">
    <div class="cont_mid">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
               <div class="blue_title_rt">
                  <div class="fleft">&nbsp;<?php if ($mode==EDIT) { print "Edit Notification"; } else { print "Create Notification"; } ?></div>
                  <div class="fright"> 
                   <?php 
                   		if ($mode==EDIT) 
                   		{
                   			print $cmn->getAdminMenuLink("send_notification_detail.php","send_notification_detail","Back","?notification_id=".$notification_id,"back.png",false); 
                   		
                   		}
                   		else 
                   		{
                   			print $cmn->getAdminMenuLink("send_notification_list.php","send_notification_list","Back","","back.png",false); 
                   		}
                   ?>                  
                   </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <?php include SERVER_ADMIN_ROOT."send_notification_form.php";?>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
<script type="text/javascript" language="javascript">
document.getElementById('txtnotification_title').focus();
</script>