<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	$plan_id=0;
	
	if (isset($_REQUEST['plan_id']) && trim($_REQUEST['plan_id'])!="")
		$plan_id = $_REQUEST['plan_id'];
	
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if ( !($cmn->isRecordExists("plan", "plan_id ", $plan_id, $record_condition)))
		$msg->sendMsg("plan_list.php","",46);

	//END CHECK
	
	global $aPlanLookupTables;
	
	if($cmn->validateDeletedIds($plan_id, $aPlanLookupTables)==false)
		$msg->sendMsg("plan_detail.php?plan_id=".$plan_id,"Plan",47);
		
	$objPlan = new plan();
	
	$mode=DELETE;
	
	include "plan_db.php";	
		
	$objPlan->setAllValues($plan_id);
	
	
?>

<?php
	$extraJs = array("plan.js");
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
                  <div class="fleft"><?php print "Delete Plan"; ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getAdminMenuLink("plan_detail.php","plan_detail","Back","?plan_id=".$plan_id,"back.png",false); 
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
        	Are you sure you want to delete this contest plan <strong><?php print $objPlan->plan_title;?></strong> ?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="plan_id" id="plan_id" value="<?php print $plan_id;?>" />
          <input type="submit" id="btndelete" title="Delete" name="btndelete" value="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='plan_detail.php?plan_id=<?php print $plan_id;?>';" />
        	</form>
        	</div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
