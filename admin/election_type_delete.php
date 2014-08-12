<?php
//include css files
require_once("include/general_includes.php");

//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

//fetch election date id to delete that record
if (isset($_REQUEST['election_type_id']) && trim($_REQUEST['election_type_id'])!="")
	$election_type_id = $_REQUEST['election_type_id'];
	
$mode=DELETE;
$objelection_type = new election_type();

// include file for DB related operations
include "election_type_db.php";	

//set all value for given id
$objelection_type->setAllValues($election_type_id);

//call js files
$extraJs = array("election_type.js");
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
                  <div class="fleft"><?php print "Delete Election Type"; ?></div>
                  <div class="fright"> 
                   <?php print $cmn->getAdminMenuLink("election_type_detail.php","election_type_detail","Back","?election_type_id=".$election_type_id,"back.png",false); ?>
				   </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont_delete">
            <div class="access_submit">
             <?php if(isset($_POST["err"])){ ($_POST["err"]!="") ? $msg->displayMsg() : "";} ?>
          <form id="frm" name="frm" method="post">
        	Are you sure you want to delete this Election Type <strong><?php print $objelection_type->election_type_name;?></strong> ?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="election_type_id" id="election_type_id" value="<?php print $election_type_id;?>" />
          <input type="submit" id="btndelete" name="btndelete" value="Delete" title="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='election_type_detail.php?election_type_id=<?php print $election_type_id;?>';" />
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