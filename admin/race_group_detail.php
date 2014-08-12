<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	$user_id = 0;
	if (isset($_REQUEST['race_group_id']) && trim($_REQUEST['race_group_id'])!="")
	{
		$race_group_id = $_REQUEST['race_group_id'];
	}	

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if (!($cmn->isRecordExists("race_group", "race_group_id", $race_group_id, $record_condition)))
		$msg->sendMsg("race_group_list.php","",46);
	//END CHECK

	$objRaceGroup = new race_group();
	$cancel_button = "javascript: window.location.href='race_group_list.php';";
	$condition= "";
	$objRaceGroup->setAllValues($race_group_id,$condition);
	
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
                  <div class="fleft">Race Group Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("race_group_list.php","race_group_list","Back","","back.png",false);?>
            <?php print ($race_group_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("race_group_addedit.php","race_group_addedit","Edit","?race_group_id=".$race_group_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("race_group_delete.php","race_group_delete","Delete","?race_group_id=".$race_group_id,"delete.png",false):"";?>
          
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
					$arrLanguages = $objRaceGroup->fetchRaceGroupLanguage();
					$arrRaceGroupLanguages = $objRaceGroup->fetchRaceGroupLanguageDetail();
					
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
			$lableField = 'Race Group Name:';
			$race_group_name_value = $cmn->readValueDetail($objRaceGroup->race_group_name);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$race_group_name_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrRaceGroupLanguages[$language[$i]['language_id']]['race_group_name']))
					$race_group_name_value = $cmn->readValueDetail($arrRaceGroupLanguages[$language[$i]['language_id']]['race_group_name']);
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($race_group_name_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}?>		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">Active:</td>
					<td align="left" valign="top">&nbsp;<?php ($objRaceGroup->race_group_active==1) ? print 'Yes' : print 'No' ?>
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