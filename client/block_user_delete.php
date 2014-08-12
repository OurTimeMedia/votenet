<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	$user_id=0;
	
	if (isset($_REQUEST['blockuser_id']) && trim($_REQUEST['blockuser_id'])!="")
		$blockuser_id = $objEncDec->decrypt($_REQUEST['blockuser_id']);
	
	//CHECK FOR RECORED EXISTS 
	$record_condition = "";	
	if ( !($cmn->isRecordExists("block_user", "blockuser_id ", $blockuser_id, $record_condition)))
		$msg->sendMsg("block_user_list.php","",46);

	//END CHECK

	global $aBlockIPLookupTables;
	
	if ($cmn->validateDeletedIds($blockuser_id, $aBlockIPLookupTables)==false)
		$msg->sendMsg("block_user_detail.php?blockuser_id=".$objEncDec->encrypt($blockuser_id),"User Name ",47);
		
	$objSecurityBlockUser = new security_block_user();
	
	$mode=DELETE;
	
	include "block_user_db.php";	
		
	$objSecurityBlockUser->setAllValues($blockuser_id);
	
	$objUser = new client();	
?>

<?php
	$extraJs = array("security.js");
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
                  <div class="fleft"><?php print "Delete Block User"; ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getClientMenuLink("block_user_detail.php","block_user_detail","Back","?blockuser_id=".$objEncDec->encrypt($blockuser_id),"back.png",false); 
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
          <table cellpadding="0" cellspacing="0" width="100%" class="listtab12">
                  <tr class="row01">
        			<td class="listtab-td-last">Are you sure you want to delete <strong><?php  if($objSecurityBlockUser->user_id!=0) { echo $objUser->userName($objSecurityBlockUser->user_id); } ?></strong>  from the blocked user list?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="blockuser_id" id="blockuser_id" value="<?php print $objEncDec->encrypt($blockuser_id);?>" />
          <input type="submit" id="btndelete" title="Delete" name="btndelete" value="Delete" class="btn_img" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn_img" onclick="javascript: window.location.href='block_user_detail.php?blockuser_id=<?php print $objEncDec->encrypt($blockuser_id);?>';" /></td>
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