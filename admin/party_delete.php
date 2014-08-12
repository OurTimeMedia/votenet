<?php
require_once("include/general_includes.php");
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

if (isset($_REQUEST['party_id']) && trim($_REQUEST['party_id'])!="")
	$party_id = $_REQUEST['party_id'];
	
$mode=DELETE;
$objparty = new party();
include "party_db.php";	

$objparty->setAllValues($party_id);

$extraJs = array("party.js");
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
                  <div class="fleft"><?php print "Delete Party"; ?></div>
                  <div class="fright"> 
                   <?php print $cmn->getAdminMenuLink("party_detail.php","party_detail","Back","?party_id=".$party_id,"back.png",false); ?>
				   </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont_delete">
            <div class="access_submit">
             <?php if(isset($_POST["err"])){ ($_POST["err"]!="") ? $msg->displayMsg() : "";} ?>
          <form id="frm" name="frm" method="post">
        	Are you sure you want to delete this Party <strong><?php print $objparty->party_name;?></strong> ?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="party_id" id="party_id" value="<?php print $party_id;?>" />
          <input type="submit" id="btndelete" name="btndelete" value="Delete" title="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='party_detail.php?party_id=<?php print $party_id;?>';" />
        	</form>
        	</div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>