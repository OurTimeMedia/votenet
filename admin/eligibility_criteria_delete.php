<?php
require_once("include/general_includes.php");
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

if (isset($_REQUEST['eligibility_criteria_id']) && trim($_REQUEST['eligibility_criteria_id'])!="")
	$eligibility_criteria_id = $_REQUEST['eligibility_criteria_id'];
	
$mode=DELETE;
$objEligCrit = new eligibility_criteria();
include "eligibility_criteria_db.php";	
$condition= "";
		$objEligCrit->setAllValues($eligibility_criteria_id , $condition);		
	
$extraJs = array("eligibility_criteria.js");
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
                  <div class="fleft"><?php print "Delete Eligibility Criteria"; ?></div>
                  <div class="fright"> 
                   <?php print $cmn->getAdminMenuLink("eligibility_criteria_detail.php","eligibility_criteria_detail","Back","?eligibility_criteria_id=".$eligibility_criteria_id,"back.png",false); ?>
				   </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont_delete">
            <div class="access_submit">
             <?php if(isset($_POST["err"])){ ($_POST["err"]!="") ? $msg->displayMsg() : "";} ?>
          <form id="frm" name="frm" method="post">
        	Are you sure you want to delete this Eligibility Criteria <strong><?php print $objEligCrit->eligibility_criteria;?></strong> ?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="eligibility_criteria_id" id="eligibility_criteria_id" value="<?php print $eligibility_criteria_id;?>" />
          <input type="submit" id="btndelete" name="btndelete" value="Delete" title="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='eligibility_criteria_detail.php?eligibility_criteria_id=<?php print $eligibility_criteria_id;?>';" />
        	</form>
        	</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>