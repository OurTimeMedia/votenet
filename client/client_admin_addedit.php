<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();	
	
	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objClientAdmin = new client();
	$objClientAdmin->client_id = $objClientAdmin->fieldValue("client_id",$userID);
	
	$user_id = 0;
		
	if (isset($_REQUEST['hdnuser_id']) && trim($_REQUEST['hdnuser_id'])!="")
	{
		$user_id = $objEncDec->decrypt($_REQUEST['hdnuser_id']);
		$entityID = $objEncDec->decrypt($_REQUEST['hdnuser_id']);
	}
		
	//set mode...
	$mode = ADD;
	if ($user_id > 0)
		$mode = EDIT;
	
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
		$msg->sendMsg("client_admin_list.php","",46);
		  
	//END CHECK

	
	$objClientAdmin->user_type_id = USER_TYPE_CLIENT_ADMIN;
	include "client_admin_db.php";
	
	$cancel_button = "javascript: window.location.href='client_admin_list.php';";
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include("client_admin_field.php");

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
		$objClientAdmin->setAllValues($user_id);
		$cancel_button = "javascript: window.location.href='client_admin_detail.php?user_id=".$objEncDec->encrypt($user_id)."';";
		$confirmPassword = $objClientAdmin->user_password;
	}

	$extraCss = array("calendar.css");
	$extraJs = array("jquery-ui-timepicker-addon.min.js","client_admin.js");
	
	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top.php";
?>

<div class="content_mn">
	<div class="content_mn2">
    <div class="cont_mid">
    	<div class="cont_lt">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
             <div class="blue_title_lt">
               <div class="blue_title_rt">
                  <div class="fleft"><?php if ($mode==EDIT) { print "Edit Admin User"; } else { print "Create Admin User"; } ?></div>
                  <div class="fright"> 
                   <?php 
                   		if ($mode==EDIT) 
                   		{
                   			print $cmn->getClientMenuLink("client_admin_detail.php","client_admin_detail","Back","?user_id=".$objEncDec->encrypt($user_id),"back.png",false); 
                   		
                   		}
                   		else 
                   		{
                   			print $cmn->getClientMenuLink("client_admin_list.php","client_admin_list","Back","","back.png",false); 
                   		}
                   ?>
                  
                   </div>
              </div>
              </div>
            </div>
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
             <?php include SERVER_CLIENT_ROOT."client_admin_form.php";?>
            </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
     	</div>
    </div>
 	</div>
</div>
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>
</body>
</html>