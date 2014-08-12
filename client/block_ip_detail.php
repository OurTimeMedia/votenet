<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	
	$user_id = 0;
		
	if (isset($_REQUEST['block_ipaddress_id']) && trim($_REQUEST['block_ipaddress_id'])!="")
	{
		$block_ipaddress_id = $objEncDec->decrypt($_REQUEST['block_ipaddress_id']);
		$entityID = $objEncDec->decrypt($_REQUEST['block_ipaddress_id']);
	}
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if (!($cmn->isRecordExists("block_ipaddress", "block_ipaddress_id", $block_ipaddress_id, $record_condition)))
		$msg->sendMsg("block_ip_list.php","",46);
		  
	//END CHECK

	$objSecurityBlockIP = new security_block_ip();

	$cancel_button = "javascript: window.location.href='block_ip_list.php';";
	
	$objSecurityBlockIP->setAllValues($block_ipaddress_id);
	
?>
<?php
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
                  <div class="fleft">Block IP Address Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getMenuLink("block_ip_list.php","block_ip_list","Back","","back.png",false);?>
            <?php print $cmn->getMenuLink("block_ip_addedit.php","block_ip_addedit","Edit","?hdnblock_ipaddress_id=".$objEncDec->encrypt($block_ipaddress_id),"edit.png",false);?>
            <?php print $cmn->getMenuLink("block_ip_delete.php","block_ip_delete","Delete","?block_ipaddress_id=".$objEncDec->encrypt($block_ipaddress_id),"delete.png",false);?>
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
             <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

				<tr class="row4">
					<td align="left" width="15%" class="left-none">
						<strong>IP Address:</strong>
					</td>		
					<td class="listtab-rt-bro-user">
						<?php echo $cmn->readValueDetail($objSecurityBlockIP->ipaddress); ?>
					</td>		
				</tr>
                
				<tr class="row4">
					<td align="left" class="left-none">
						<strong>Blocked By:</strong>
					</td>
		
					<td class="listtab-rt-bro-user">
						<?php $objUser = new client(); echo $objUser->fieldValue("user_username",$objSecurityBlockIP->created_by); ?>
					</td>
		
				</tr>
		
				<tr class="row4">
					<td align="left" class="left-none">
						<strong>Blocked Date:</strong>
					</td>
		
					<td class="listtab-rt-bro-user">
						<?php $dt = explode(" ",$objSecurityBlockIP->created_date); print $cmn->dateTimeFormat(htmlspecialchars($dt[0]),'%m/%d/%Y'); ?>
					</td>
				</tr>
			
			</table>
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