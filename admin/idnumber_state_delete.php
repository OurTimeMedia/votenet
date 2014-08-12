<?php
require_once("include/general_includes.php");
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

if (isset($_REQUEST['state_id']) && trim($_REQUEST['state_id'])!="")
	$state_id = $_REQUEST['state_id'];
	
$mode=DELETE;
$objidnumber = new idnumber_state();
include "idnumber_state_db.php";	
$condition=" and es.state_id=".$state_id;
$idnumberdata=$objidnumber->fetchAllAsArray($condition);
//print_r($idnumberdata);
$extraJs = array("idnumber_state.js");
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
                  <div class="fleft"><?php print "Delete State - ID Number Join"; ?></div>
                  <div class="fright"> 
                   <?php print $cmn->getAdminMenuLink("idnumber_state_detail.php","idnumber_state_detail","Back","?state_id=".$state_id,"back.png",false); ?>
				   </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont_delete">
            <div class="access_submit">
             <?php if(isset($_POST["err"])){ ($_POST["err"]!="") ? $msg->displayMsg() : "";} ?>
          <form id="frm" name="frm" method="post">
        	Are you sure you want to delete ID Number details for  <strong><?php print $idnumberdata[0]['state_code']." - ".$idnumberdata[0]['state_name'];?></strong> state ?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="idnumber_state_id" id="idnumber_state_id" value="<?php print $idnumber_state_id;?>" />
          <input type="submit" id="btndelete" name="btndelete" value="Delete" title="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='idnumber_state_detail.php?state_id=<?php print $state_id;?>';" />
        	</form>
        	</div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>