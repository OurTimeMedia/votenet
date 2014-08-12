<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	$user_id=0;
	
	if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id'])!="")
		$user_id = $_REQUEST['user_id'];
	
	if ($user_id == 1)	// Super user cannot be deleted
		$msg->sendMsg("client_admin_list.php","",48);
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if ( !($cmn->isRecordExists("user", "user_id ", $user_id, $record_condition)))
		$msg->sendMsg("client_admin_list.php","",46);

	//END CHECK

	global $aClientAdminLookupTables;
	
	if($cmn->validateDeletedIds($user_id, $aClientAdminLookupTables)==false)
		$msg->sendMsg("client_admin_detail.php?user_id=".$user_id,"Admin user",47);
		
	$objClientAdmin = new user();
	
	$mode=DELETE;
	
	include "client_admin_db.php";	
		
	$objClientAdmin->setAllValues($user_id);
	
?>

<?php
	$extraJs = array("client_admin.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>

<div class="content_mn">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft"><?php print "Delete Client Admin"; ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getAdminMenuLink("client_admin_detail.php","client_admin_detail","Back","?user_id=".$user_id,"back.png",false); 
                   ?>
                  
                   </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont_delete">
            <div class="access_submit">
             <?php if(isset($_POST["err"])){ 
        	 ($_POST["err"]!="") ? $msg->displayMsg() : "";
      } ?>
          <form id="frm" name="frm" method="post">
        	Are you sure you want to delete this admin user <strong><?php print $objClientAdmin->user_firstname." ".$objClientAdmin->user_lastname;?></strong> ?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="user_id" id="user_id" value="<?php print $user_id;?>" />
          <input type="submit" id="btndelete" name="btndelete" value="Delete" title="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='client_admin_detail.php?user_id=<?php print $user_id;?>';" />
        	</form>
        	</div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
