<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	
	$blockuser_id = 0;
		
	if (isset($_REQUEST['blockuser_id']) && trim($_REQUEST['blockuser_id'])!="")
	{
		$blockuser_id = $objEncDec->decrypt($_REQUEST['blockuser_id']);
		$entityID = $objEncDec->decrypt($_REQUEST['blockuser_id']);
	}
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if (!($cmn->isRecordExists("block_user", "blockuser_id", $blockuser_id, $record_condition)))
		$msg->sendMsg("block_user_list.php","",46);
		  
	//END CHECK

	$objSecurityBlockUser = new security_block_user();
	$objUser = new client();
	
	$cancel_button = "javascript: window.location.href='block_user_list.php';";
	
	$objSecurityBlockUser->setAllValues($blockuser_id);
	
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
                  <div class="fleft">Block User Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getMenuLink("block_user_list.php","block_user_list","Back","","back.png",false);?>
            <?php print $cmn->getMenuLink("block_user_addedit.php","block_user_addedit","Edit","?hdnblockuser_id=".$objEncDec->encrypt($blockuser_id),"edit.png",false);?>
            <?php print $cmn->getMenuLink("block_user_delete.php","block_user_delete","Delete","?blockuser_id=".$objEncDec->encrypt($blockuser_id),"delete.png",false);?>
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

				<tr class="row01">
					<td align="left" valign="top" width="15%" class="left-none">
						<strong>User Name:</strong>
					</td>
		
					<td class="listtab-rt-bro-user">
						<?php  
							   $user_name = $objUser->userName($objSecurityBlockUser->user_id); 
							   echo $user_name;
						?>
					</td>
		
				</tr>
                
				<tr class="row4">
					<td align="left" valign="top" class="left-none">
						<strong>Blocked By:</strong>
					</td>
		
					<td class="listtab-rt-bro-user">
						<?php $objUser = new client(); echo $objUser->fieldValue("user_username",$objSecurityBlockUser->created_by); ?>
					</td>
		
				</tr>
		
				<tr class="row4">
					<td align="left" valign="top" class="left-none">
						<strong>Blocked Date:</strong>
					</td>
		
					<td class="listtab-rt-bro-user">
						<?php $dt = explode(" ",$objSecurityBlockUser->created_date); print $cmn->dateTimeFormat(htmlspecialchars($dt[0]),'%m/%d/%Y'); ?>
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