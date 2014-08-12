<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	
	$block_ipaddress_id = 0;
		
	if (isset($_REQUEST['hdnblock_ipaddress_id']) && trim($_REQUEST['hdnblock_ipaddress_id'])!="")
	{
		$block_ipaddress_id = $objEncDec->decrypt($_REQUEST['hdnblock_ipaddress_id']);
		$entityID = $objEncDec->decrypt($_REQUEST['hdnblock_ipaddress_id']);
	}
		
	//set mode...
	$mode = ADD;
	if ($block_ipaddress_id > 0)
		$mode = EDIT;
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("block_ipaddress", "block_ipaddress_id", $block_ipaddress_id, $record_condition)))
		$msg->sendMsg("block_ip_list.php","",46);
		  
	//END CHECK

	$objSecurityBlockIP = new security_block_ip();

	include SERVER_CLIENT_ROOT."block_ip_db.php";
	
	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objClient = new client();
	$objSecurityBlockIP->client_id = $objClient->fieldValue("client_id",$userID);
	
	$cancel_button = "javascript: window.location.href='block_ip_list.php';";
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include_once "block_ip_field.php";

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
		$objSecurityBlockIP->setAllValues($block_ipaddress_id);
		$cancel_button = "javascript: window.location.href='block_ip_detail.php?block_ipaddress_id=".$objEncDec->encrypt($block_ipaddress_id)."';";
	}
	
	$extraJs = array("security.js");
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
                  <div class="fleft"><?php if ($mode==EDIT) { print "Edit Block IP Address"; } else { print "Add Block IP Address"; } ?></div>
                  <div class="fright"> 
                   <?php 
				   		if ($mode==EDIT) 
                   		{
                   			print $cmn->getMenuLink("block_ip_detail.php","block_ip_detail","Back","?block_ipaddress_id=".$objEncDec->encrypt($block_ipaddress_id),"back.png",false);
                   		}
                   		else 
                   		{
                   			print $cmn->getMenuLink("block_ip_list.php","block_ip_list","Back","","back.png",false);
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
             <?php include SERVER_CLIENT_ROOT."block_ip_form.php";?>
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
<script type="text/javascript" language="javascript">
document.getElementById('txtipaddress').focus();
</script>
</body>
</html>