<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	
	$plan_id = 0;
		
	if (isset($_REQUEST['plan_id']) && trim($_REQUEST['plan_id'])!="")
	{
		$plan_id = $_REQUEST['plan_id'];
		$entityID = $_REQUEST['plan_id'];
	}
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if (!($cmn->isRecordExists("plan", "plan_id", $plan_id, $record_condition)))
		$msg->sendMsg("plan_list.php","",46);
		  
	//END CHECK

	$objPlan = new plan();

	$cancel_button = "javascript: window.location.href='plan_list.php';";
	
	$objPlan->setAllValues($plan_id);
	
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
                  <div class="fleft">Contest Plan Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("plan_list.php","plan_list","Back","","back.png",false);?>
            <?php print $cmn->getAdminMenuLink("plan_addedit.php","plan_addedit","Edit","?hdnplan_id=".$plan_id,"edit.png",false);?>
            <?php print $cmn->getAdminMenuLink("plan_delete.php","plan_delete","Delete","?plan_id=".$plan_id,"delete.png",false);?>
           			</div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

				<tr class="row01">
			<td align="left" valign="top" class="txtbo" width="20%">
				Title:			</td>

			<td align="left" valign="top">
				&nbsp;<?php echo htmlspecialchars($objPlan->plan_title); ?>			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Description:			</td>

			<td align="left" valign="top">
				&nbsp;<?php echo htmlspecialchars($objPlan->plan_description); ?>			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Amount:			</td>

			<td align="left" valign="top">
				&nbsp;$<?php echo htmlspecialchars($objPlan->plan_amount); ?>			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Custom Domain:			</td>

			<td align="left" valign="top">
				&nbsp;<?php ($objPlan->custom_domain == 1) ? print 'Yes' : print 'No' ?>			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Custom Field:			</td>

			<td align="left" valign="top">
				&nbsp;<?php ($objPlan->custom_field == 1) ? print 'Yes' : print 'No' ?>			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Custom  Color:			</td>

			<td align="left" valign="top">
				&nbsp;<?php ($objPlan->custom_color == 1) ? print 'Yes' : print 'No' ?>			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Download Data:			</td>

			<td align="left" valign="top">
				&nbsp;<?php ($objPlan->download_data == 1) ? print 'Yes' : print 'No' ?>			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				FB Application:			</td>

			<td align="left" valign="top">
				&nbsp;<?php ($objPlan->FB_application == 1) ? print 'Yes' : print 'No' ?>			</td>
		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				API Access:			</td>

			<td align="left" valign="top">&nbsp;<?php ($objPlan->API_access == 1) ? print 'Yes' : print 'No' ?>		</td>
		</tr>		
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Publish:			</td>

			<td align="left" valign="top">
				&nbsp;<?php ($objPlan->plan_ispublish == 1) ? print 'Yes' : print 'No' ?>			</td>
		</tr>
		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Active:			</td>

			<td align="left" valign="top">
				&nbsp;<?php ($objPlan->plan_isactive==1) ? print 'Yes' : print 'No' ?>			</td>
			</tr>
			</table>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
