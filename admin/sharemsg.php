<?php

	require_once("include/general_includes.php");
	$site_config_id = 1;
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	if (isset($_REQUEST['hdnsocialmediacontent_id']) && trim($_REQUEST['hdnsocialmediacontent_id'])!="")
		$site_config_id = $_REQUEST['hdnsocialmediacontent_id'];
		
	//set mode...
	$mode = ADD;
	if ($site_config_id > 0)
		$mode = EDIT;


$objclientsocialmediacontent=  new clientsocialmediacontent();

	include SERVER_ADMIN_ROOT."sharemsg_db.php";
	
	$cancel_button = "javascript: window.location.href='sharemsg.php';";

	
	
	if ($mode == EDIT)
	{
		$data=$objclientsocialmediacontent->fetchclientcontent(0);
	}
	
	$extraJs = array("share_msg.js");
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
                  <div class="fleft"><?php print "Share Messages"; ?></div>
                  <div class="fright">&nbsp;</div>
              </div>
            </div>
            <div class="blue_title_cont">
             <?php include SERVER_ADMIN_ROOT."share_msg_form.php";?>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>