<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	
	$email_templates_id = 0;
		
	if (isset($_REQUEST['hdnemail_templates_id']) && trim($_REQUEST['hdnemail_templates_id'])!="")
	{
		$email_templates_id = $objEncDec->decrypt($_REQUEST['hdnemail_templates_id']);
		$entityID = $objEncDec->decrypt($_REQUEST['hdnemail_templates_id']);
	}
		
	//set mode...
	$mode = ADD;
	if ($email_templates_id > 0)
		$mode = EDIT;
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("email_templates", "email_templates_id", $email_templates_id, $record_condition)))
		$msg->sendMsg("email_template_list.php","",46);
		  
	//END CHECK
	
	$objEmaiTemplates = new email_templates();

	include SERVER_CLIENT_ROOT."email_template_db.php";
	
	$cancel_button = "javascript: window.location.href='email_template_list.php';";

	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
		include_once "email_template_field.php";

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
		$objEmaiTemplates->setAllValues($email_templates_id);
	}
		
	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objClient = new client();
	$objEmaiTemplates->client_id = $objClient->fieldValue("client_id",$userID);

	$extraJs = array("email_template.js","timymce_editor.js","main.js");
	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top.php";

?>
  <div class="content_mn">
    <div class="content_mn2">
      <div class="cont_mid">
        <div class="cont_lt">
          <div class="cont_rt">
            <div class="user_tab_mn">
              <div class="blue_title">
                <div class="blue_title_lt">
                  	<div class="blue_title_rt">
                    <div class="fleft">&nbsp;<?php if ($mode==EDIT) { print "Edit Email Template"; } else { print "Create Email Template"; } ?></div>
                    <div class="fright"><?php 
                   		if ($mode==EDIT) 
                   		{
                   			print $cmn->getMenuLink("email_template_list.php","email_template_list","Back","","back.png",false); 
                   		
                   		}
                   		else 
                   		{
                   			print $cmn->getMenuLink("email_template_list.php","email_template_list","Back","","back.png",false); 
                   		}
                   ?></div>
                  </div>
                </div>
              </div>
              <div class="content-box">
              	<div class="content-left-shadow">

                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
             <?php  include SERVER_CLIENT_ROOT."email_template_form.php";?>
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
document.getElementById('txtemail_templates_name').focus();
</script>
</body>
</html>