<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	$user_id = 0;
		
	if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id'])!="")
	{
		$user_id = $_REQUEST['user_id'];
		$entityID = $_REQUEST['user_id'];
	}
		
	
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if (!($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
		$msg->sendMsg("system_admin_list.php","",46);
		
	
	$objSystemAdmin = new user();
	$objAdminMenu = new adminmenu();

	include "system_admin_db.php";
	
	$cancel_button = "javascript: window.location.href='system_admin_detail.php?user_id=".$user_id."';";
	
	$objSystemAdmin->setAllValues($user_id);
	
	$extraJs = array('prototype.js');
	
	include SERVER_ADMIN_ROOT."include/header.php"; 
	include SERVER_ADMIN_ROOT."include/top.php"; 
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
                  <div class="fleft">System Admin Access Rights for [ <?php print $objSystemAdmin->user_firstname." ".$objSystemAdmin->user_lastname;?> ]</div>
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("system_admin_detail.php","system_admin_detail","Back","?user_id=".$user_id,"back.png",false,'');?> </div>
                </div>
              </div>
            </div>
          
            <div class="blue_title_cont_delete">
          	<form id="frm" name="frm" method="post">
			<div style="margin:0px;padding:0px;">
                <div class="access_submit1">
                	<?php print $objAdminMenu->getAdminMenuTree(0,false,true,$user_id);?>
                </div>

                <div class="access_submit">
                    <input type="submit" title="Save" class="btn" value="Save" name="btnsave_access" id="btnsave_access"/>&nbsp;&nbsp;
                    <input type="button" class="btn" title="Cancel" value="Cancel" name="btncanel" id="btncanel" onClick="<?php print $cancel_button; ?>"/>
                </div>
            </div>
            
          </form>
        </div>
       
          </div>
        </div>
      </div>
    </div> 
  </div>
</div>
<?php include "include/footer.php";?>

