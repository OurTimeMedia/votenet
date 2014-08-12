<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	$user_id = 0;
	if (isset($_REQUEST['eligibility_criteria_id']) && trim($_REQUEST['eligibility_criteria_id'])!="")
	{
		$eligibility_criteria_id = $_REQUEST['eligibility_criteria_id'];
	}	

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if (!($cmn->isRecordExists("eligibility_criteria", "eligibility_criteria_id", $eligibility_criteria_id, $record_condition)))
		$msg->sendMsg("eligibility_criteria_list.php","",46);
	//END CHECK

	$objEligCrit = new eligibility_criteria();
	$cancel_button = "javascript: window.location.href='eligibility_criteria_list.php';";
	$condition= "";
	$objEligCrit->setAllValues($eligibility_criteria_id,$condition);
	
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);
	
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
                  <div class="fleft">Eligibility Criteria Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("eligibility_criteria_list.php","eligibility_criteria_list","Back","","back.png",false);?>
            <?php print ($eligibility_criteria_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("eligibility_criteria_addedit.php","eligibility_criteria_addedit","Edit","?eligibility_criteria_id=".$eligibility_criteria_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("eligibility_criteria_delete.php","eligibility_criteria_delete","Delete","?eligibility_criteria_id=".$eligibility_criteria_id,"delete.png",false):"";?>
          
           		 </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">
			 <tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Language:
					</td>
		
					<td align="left" valign="top"><?php 
					$arrLanguages = $objEligCrit->fetchEligibilityCriteriaLanguage();
					$arrECLanguages = $objEligCrit->fetchEligibilityCriteriaLanguageDetail();
					
					for($i=0;$i<count($language);$i++) { 
					if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1){
					?>
					<img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />
					<?php }} ?>
					</td>
		
				</tr>			
			<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'Eligibility Criteria:';
			$eligibility_criteria_value = $cmn->readValueDetail($objEligCrit->eligibility_criteria);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$eligibility_criteria_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrECLanguages[$language[$i]['language_id']]['eligibility_criteria']))
					$eligibility_criteria_value = $cmn->readValueDetail($arrECLanguages[$language[$i]['language_id']]['eligibility_criteria']);
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($eligibility_criteria_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
			<?php }}?>
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Default for all states:
					</td>
		
					<td align="left" valign="top">
					
						&nbsp;<?php ($objEligCrit->for_all_state==1) ? print 'Yes' : print 'No' ?>
					</td>
		
				</tr>
				
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Active:
					</td>
		
					<td align="left" valign="top">
					
						&nbsp;<?php ($objEligCrit->eligibility_active==1) ? print 'Yes' : print 'No' ?>
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
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
