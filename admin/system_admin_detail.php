<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	
	$user_id = 0;
		
	if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id'])!="")
	{
		$user_id = $_REQUEST['user_id'];
		$entityID = $_REQUEST['user_id'];
	}
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if (!($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
		$msg->sendMsg("system_admin_list.php","",46);
		  
	//END CHECK

	$objSystemAdmin = new user();

	$cancel_button = "javascript: window.location.href='system_admin_list.php';";
	
	$objSystemAdmin->setAllValues($user_id);
	
?>
<?php
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
                  <div class="fleft">System Admin Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("system_admin_list.php","system_admin_list","Back","","back.png",false);?>
            <?php print $cmn->getAdminMenuLink("system_admin_addedit.php","system_admin_addedit","Edit","?hdnuser_id=".$user_id,"edit.png",false);?>
            <?PHP if($user_id!=USER_TYPE_SUPER_SYSTEM_ADMIN) { ?>
            <?PHP if($user_id!=$cmn->getSession(SYSTEM_ADMIN_USER_ID)) { ?>
            <?php print $cmn->getAdminMenuLink("system_admin_delete.php","system_admin_delete","Delete","?user_id=".$user_id,"delete.png",false);?>
            <?PHP } ?>
            <?php print $cmn->getAdminMenuLink("system_admin_access.php","system_admin_access","Access Rights","?user_id=".$user_id,"access.png");?>
            <?PHP } ?> 
            	 </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

				<tr class="row01">
					<td align="left" valign="top" width="15%" class="txtbo">
						Username:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objSystemAdmin->user_username); ?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						First Name:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objSystemAdmin->user_firstname); ?>
					</td>
		
				</tr>
		
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Last Name:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objSystemAdmin->user_lastname); ?>
					</td>
		
				</tr>
				
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Designation:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objSystemAdmin->user_designation); ?>
					</td>
		
				</tr>
		
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Email:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<a title="<?php print htmlspecialchars($objSystemAdmin->user_email); ?>" href="mailto:<?php print htmlspecialchars($objSystemAdmin->user_email); ?>"><?php echo htmlspecialchars($objSystemAdmin->user_email); ?></a>
					</td>
		
				</tr>
		
				
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Phone:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objSystemAdmin->user_phone); ?>
					</td>
		
				</tr>
		
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Address1:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objSystemAdmin->user_address1); ?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Address2:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objSystemAdmin->user_address2); ?>
					</td>
		
				</tr>
		
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						City:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objSystemAdmin->user_city); ?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						State:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objSystemAdmin->user_state); ?>
					</td>
		
				</tr>
		
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Country:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php if($objSystemAdmin->user_country != 0 ) echo $cmn->getContryNameById($objSystemAdmin->user_country) ?>
					</td>
		
				</tr>
		
				
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Active:
					</td>
		
					<td align="left" valign="top">
					
						&nbsp;<?php ($objSystemAdmin->user_isactive==1) ? print 'Yes' : print  'No' ?>
					</td>
		
				</tr>
		
			</table>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
