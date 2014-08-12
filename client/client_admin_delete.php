<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();	
	$user_id=0;
	
	if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id'])!="")
		$user_id = $objEncDec->decrypt($_REQUEST['user_id']);
	
	if ($user_id == 1)	// Super user cannot be deleted
		$msg->sendMsg("client_admin_list.php","",48);
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if ( !($cmn->isRecordExists("user", "user_id ", $user_id, $record_condition)))
		$msg->sendMsg("client_admin_list.php","",46);

	//END CHECK

	global $aClientAdminLookupTables;
	
	if ($cmn->validateDeletedIds($user_id, $aClientAdminLookupTables)==false)
		$msg->sendMsg("client_admin_detail.php?user_id=".$objEncDec->encrypt($user_id),"Admin ",47);
		
	$objClientAdmin = new client();
	
	$mode=DELETE;
	
	include "client_admin_db.php";	
		
	$objClientAdmin->setAllValues($user_id);
	
?>

<?php
	$extraJs = array("client_admin.js");
	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top.php";
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
                  <div class="fleft"><?php print "Delete Admin"; ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getClientMenuLink("client_admin_detail.php","client_admin_detail","Back","?user_id=".$objEncDec->encrypt($user_id),"back.png",false); 
                   ?>
                  
                   </div>
                </div>
              </div>
            </div>
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">            
             <?php if(isset($_POST["err"])){ 
        	 ($_POST["err"]!="") ? $msg->displayMsg() : "";
      } ?>
          <form id="frm" name="frm" method="post">
          <table cellpadding="0" cellspacing="0" width="100%" class="listtab">
                  <tr class="row01">
        			<td class="listtab-rt-bro-user">Are you sure you want to delete this admin user <strong><?php print $cmn->readValueDetail($objClientAdmin->user_firstname)." ".$cmn->readValueDetail($objClientAdmin->user_lastname);?></strong> ?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="user_id" id="user_id" value="<?php print $objEncDec->encrypt($user_id);?>" />
          <input type="submit" id="btndelete" title="Delete" name="btndelete" value="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='client_admin_detail.php?user_id=<?php print $objEncDec->encrypt($user_id);?>';" /></td>
                  </tr>                
                </table>
        	</form>        	
            </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
 	</div>
</div>
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>
</body>
</html>