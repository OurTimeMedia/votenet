<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	$user_id = 0;
	if (isset($_REQUEST['poll_booth_id']) && trim($_REQUEST['poll_booth_id'])!="")
	{
		$poll_booth_id = $_REQUEST['poll_booth_id'];
	}	

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if (!($cmn->isRecordExists("poll_booth_address", "poll_booth_id", $poll_booth_id, $record_condition)))
		$msg->sendMsg("poll_booth_address_list.php","",46);
	//END CHECK

	$objPollBooth = new poll_booth();
	$cancel_button = "javascript: window.location.href='poll_booth_address_list.php';";
	$condition= "";
	$objPollBooth->setAllValues($poll_booth_id,$condition);
	
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
                  <div class="fleft">State Voter Registration Office Location Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("poll_booth_address_list.php","poll_booth_address_list","Back","","back.png",false);?>
            <?php print ($poll_booth_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("poll_booth_address_addedit.php","poll_booth_address_addedit","Edit","?poll_booth_id=".$poll_booth_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("poll_booth_address_delete.php","poll_booth_address_delete","Delete","?poll_booth_id=".$poll_booth_id,"delete.png",false):"";?>          
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
					// $arrElectionTypeLanguages = $objElectionType->fetchElectionTypeLanguageDetail();
					$arrLanguages = $objPollBooth->fetchPollBoothLanguage();			  
					$arrPBLanguages = $objPollBooth->fetchPollBoothLanguageDetail();
					
					for($i=0;$i<count($language);$i++) { 
					if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1){
					?>
					<img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />
					<?php }} ?>
					</td>		
				</tr>
				<tr class="row01">
					<td align="left" valign="top" class="txtbo" width="22%">State:</td>
					<td align="left" valign="top" width="78%"><?php echo $objPollBooth->state_code." - ".$objPollBooth->state_name; ?>&nbsp;</td>
				</tr>												
				<?php 
				for($i=0;$i<count($language);$i++) {
				$styleDetail = '';
				$lableField = 'Official Title:';
				$official_title_value = $cmn->readValueDetail($objPollBooth->official_title);
				
				if($language[$i]['language_id']!=1)
				{				
					$lableField = '&nbsp;';
					$official_title_value = "";
				}
				
				if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
				{
					$styleDetail = '';				
					if(isset($arrPBLanguages[$language[$i]['language_id']]['official_title']))
						$official_title_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['official_title']);
				?>
					<tr class="row01">
						<td align="left" valign="top" width="22%" class="txtbo">
							<?php echo $lableField;?>					</td>
			
						<td width="78%" align="left" valign="top">
							&nbsp;<?php echo htmlspecialchars($official_title_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
			
					</tr>
			<?php }}?>
				<?php 
				for($i=0;$i<count($language);$i++) {
				$styleDetail = '';
				$lableField = 'Building Name:';
				$building_name_value = $cmn->readValueDetail($objPollBooth->building_name);
				
				if($language[$i]['language_id']!=1)
				{				
					$lableField = '&nbsp;';
					$building_name_value = "";
				}
				
				if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
				{
					$styleDetail = '';				
					if(isset($arrPBLanguages[$language[$i]['language_id']]['building_name']))
						$building_name_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['building_name']);
				?>
					<tr class="row01">
						<td align="left" valign="top" width="22%" class="txtbo">
							<?php echo $lableField;?>					</td>
			
						<td width="78%" align="left" valign="top">
							&nbsp;<?php echo htmlspecialchars($building_name_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
			
					</tr>
			<?php }}?>
				<?php 
				for($i=0;$i<count($language);$i++) {
				$styleDetail = '';
				$lableField = 'Address1:';
				$poll_booth_address1_value = $cmn->readValueDetail($objPollBooth->poll_booth_address1);
				
				if($language[$i]['language_id']!=1)
				{				
					$lableField = '&nbsp;';
					$poll_booth_address1_value = "";
				}
				
				if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
				{
					$styleDetail = '';				
					if(isset($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address1']))
						$poll_booth_address1_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address1']);
				?>
					<tr class="row01">
						<td align="left" valign="top" width="22%" class="txtbo">
							<?php echo $lableField;?>					</td>
			
						<td width="78%" align="left" valign="top">
							&nbsp;<?php echo htmlspecialchars($poll_booth_address1_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
			
					</tr>
			<?php }}?>
				<?php 
				for($i=0;$i<count($language);$i++) {
				$styleDetail = '';
				$lableField = 'Address2:';
				$poll_booth_address2_value = $cmn->readValueDetail($objPollBooth->poll_booth_address2);
				
				if($language[$i]['language_id']!=1)
				{				
					$lableField = '&nbsp;';
					$poll_booth_address2_value = "";
				}
				
				if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
				{
					$styleDetail = '';				
					if(isset($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address2']))
						$poll_booth_address2_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['poll_booth_address2']);
				?>
					<tr class="row01">
						<td align="left" valign="top" width="22%" class="txtbo">
							<?php echo $lableField;?>					</td>
			
						<td width="78%" align="left" valign="top">
							&nbsp;<?php echo htmlspecialchars($poll_booth_address2_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
			
					</tr>
			<?php }}?>
			<?php 
				for($i=0;$i<count($language);$i++) {
				$styleDetail = '';
				$lableField = 'City:';
				$poll_booth_city_value = $cmn->readValueDetail($objPollBooth->poll_booth_city);
				
				if($language[$i]['language_id']!=1)
				{				
					$lableField = '&nbsp;';
					$poll_booth_city_value = "";
				}
				
				if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
				{
					$styleDetail = '';				
					if(isset($arrPBLanguages[$language[$i]['language_id']]['poll_booth_city']))
						$poll_booth_city_value = $cmn->readValueDetail($arrPBLanguages[$language[$i]['language_id']]['poll_booth_city']);
				?>
					<tr class="row01">
						<td align="left" valign="top" width="22%" class="txtbo">
							<?php echo $lableField;?>					</td>
			
						<td width="78%" align="left" valign="top">
							&nbsp;<?php echo htmlspecialchars($poll_booth_city_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
			
					</tr>
			<?php }}?>
				<tr class="row01">
					<td align="left" valign="top" width="18%" class="txtbo">Zip Code:&nbsp;</td>
					<td align="left" valign="top"><?php echo $objPollBooth->poll_booth_zipcode;?>&nbsp;
					</td>
				</tr>
				<tr class="row02">
					<td align="left" valign="top" width="18%" class="txtbo">Phone No.:&nbsp;</td>
					<td align="left" valign="top"><?php echo $objPollBooth->poll_booth_phone;?>&nbsp;
					</td>
				</tr>
				<tr class="row01">
					<td align="left" valign="top" width="18%" class="txtbo">Fax No.:&nbsp;</td>
					<td align="left" valign="top"><?php echo $objPollBooth->poll_booth_fax;?>&nbsp;
					</td>
				</tr>
				<tr class="row02">
					<td align="left" valign="top" width="18%" class="txtbo">URL:&nbsp;</td>
					<td align="left" valign="top"><?php echo $objPollBooth->url;?>&nbsp;
					</td>
				</tr>				
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">Active:</td>
					<td align="left" valign="top">			
						<?php ($objPollBooth->poll_booth_active==1) ? print 'Yes' : '' ?>
						<?php ($objPollBooth->poll_booth_active!=1) ? print 'No' : '' ?>
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