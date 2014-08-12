<?php
//include css files
require_once("include/general_includes.php");

//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

//fetch election date id to delete that record
if (isset($_REQUEST['election_date_id']) && trim($_REQUEST['election_date_id'])!="")
	$election_date_id = $_REQUEST['election_date_id'];
	
$mode=DELETE;
$objElectionDate = new election_date();

// include file for DB related operations
include "election_date_db.php";	

//call js files
$extraJs = array("election_date.js");
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
                  <div class="fleft"><?php print "Delete Election Date"; ?></div>
                  <div class="fright"> 
                   <?php print $cmn->getAdminMenuLink("election_date_detail.php","state_detail","Back","?election_date_id=".$election_date_id,"back.png",false); ?>
				   </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont_delete">
            <div class="access_submit">
             <?php if(isset($_POST["err"])){ ($_POST["err"]!="") ? $msg->displayMsg() : "";} ?>
          <form id="frm" name="frm" method="post">
        	Are you sure you want to delete this Election Date?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="election_date_id" id="election_date_id" value="<?php print $election_date_id;?>" />
          <input type="submit" id="btndelete" name="btndelete" value="Delete" title="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='election_date_detail.php?election_date_id=<?php print $election_date_id;?>';" />
        	</form>
        	</div>
            </div>
          </div>
        </div>
      </div>
    </div> 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>