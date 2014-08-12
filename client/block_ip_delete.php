<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	$user_id=0;
	
	if (isset($_REQUEST['block_ipaddress_id']) && trim($_REQUEST['block_ipaddress_id'])!="")
		$block_ipaddress_id = $objEncDec->decrypt($_REQUEST['block_ipaddress_id']);
	
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if ( !($cmn->isRecordExists("block_ipaddress", "block_ipaddress_id ", $block_ipaddress_id, $record_condition)))
		$msg->sendMsg("block_ip_list.php","",46);

	//END CHECK

	global $aBlockIPLookupTables;
	
	if ($cmn->validateDeletedIds($block_ipaddress_id, $aBlockIPLookupTables)==false)
		$msg->sendMsg("block_ip_detail.php?block_ipaddress_id=".$objEncDec->encrypt($block_ipaddress_id),"IP Address ",47);
		
	$objSecurityBlockIP = new security_block_ip();
	
	$mode=DELETE;
	
	include "block_ip_db.php";	
		
	$objSecurityBlockIP->setAllValues($block_ipaddress_id);
	
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
                  <div class="fleft"><?php print "Delete Block IP Address"; ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getClientMenuLink("block_ip_detail.php","block_ip_detail","Back","?block_ipaddress_id=".$objEncDec->encrypt($block_ipaddress_id),"back.png",false); 
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
                  <tr>
        			<td class="listtab-rt-bro-user" style="background:#fff;">Are you sure you want to delete block ip address <strong><?php print $cmn->readValueDetail($objSecurityBlockIP->ipaddress);?></strong> ?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="block_ipaddress_id" id="block_ipaddress_id" value="<?php print $objEncDec->encrypt($block_ipaddress_id);?>" />
          <input type="submit" id="btndelete" title="Delete" name="btndelete" value="Delete" class="btn_img" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn_img" onclick="javascript: window.location.href='block_ip_detail.php?block_ipaddress_id=<?php print $objEncDec->encrypt($block_ipaddress_id);?>';" /></td>
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