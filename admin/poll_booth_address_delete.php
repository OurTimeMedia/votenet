<?php
require_once("include/general_includes.php");
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

if (isset($_REQUEST['poll_booth_id']) && trim($_REQUEST['poll_booth_id'])!="")
	$poll_booth_id = $_REQUEST['poll_booth_id'];
	
$mode=DELETE;
$objPollBooth = new poll_booth();
include "poll_booth_address_db.php";	

$objPollBooth->setAllValues($poll_booth_id);

$extraJs = array("poll_booth_address.js");
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
                  <div class="fleft"><?php print "Delete State Voter Registration Office Location"; ?></div>
                  <div class="fright"> 
                   <?php print $cmn->getAdminMenuLink("poll_booth_address_detail.php","poll_booth_address_detail","Back","?poll_booth_id=".$poll_booth_id,"back.png",false); ?>
				   </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont_delete">
            <div class="access_submit">
             <?php if(isset($_POST["err"])){ ($_POST["err"]!="") ? $msg->displayMsg() : "";} ?>
          <form id="frm" name="frm" method="post">
        	Are you sure you want to delete this State Voter Registration Office Location <strong><?php print $objPollBooth->official_title;?></strong> ?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="poll_booth_id" id="poll_booth_id" value="<?php print $poll_booth_id;?>" />
          <input type="submit" id="btndelete" name="btndelete" value="Delete" title="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='poll_booth_address_detail.php?poll_booth_id=<?php print $poll_booth_id;?>';" />
        	</form>
        	</div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>