<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	
	$block_ipaddress_id = 0;
		
	if (isset($_REQUEST['hdnblock_ipaddress_id']) && trim($_REQUEST['hdnblock_ipaddress_id'])!="")
		$block_ipaddress_id = $_REQUEST['hdnblock_ipaddress_id'];
		
	//set mode...
	$mode = ADD;
	if ($block_ipaddress_id > 0)
		$mode = EDIT;
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("block_ipaddress", "block_ipaddress_id", $block_ipaddress_id, $record_condition)))
		$msg->sendMsg("security_block_ip_list.php","",46);
		  
	//END CHECK

	$objSecurityBlockIP = new security_block_ip();

	include SERVER_ADMIN_ROOT."security_block_ip_db.php";
	
	$cancel_button = "javascript: window.location.href='security_block_ip_list.php';";
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include_once "security_block_ip_field.php";

		// Set red border for error fields
		$err_fields = split("\|", $_SESSION["err_fields"]);
		unset($_SESSION["err_fields"]);
		for ($i=0;$i<count($err_fields);$i++)
		{
			$err_fields[$i] = "class_".$err_fields[$i];
			$$err_fields[$i] = "input-red-border";
		}
	}
	
	$extraJs = array("security.js");
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
                  <div class="fleft"><?php if ($mode==EDIT) { print "Edit IP Address"; } else { print "Add IP Address"; } ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getAdminMenuLink("security_block_ip_list.php","security_block_ip_list","Back","","back.png",false); 
                   		
                   ?>
                  
                   </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <?php include SERVER_ADMIN_ROOT."security_block_ip_form.php";?>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
<script type="text/javascript" language="javascript">
document.getElementById('txtipaddress').focus();
</script>