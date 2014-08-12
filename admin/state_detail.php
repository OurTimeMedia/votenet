<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	$user_id = 0;
	if (isset($_REQUEST['state_id']) && trim($_REQUEST['state_id'])!="")
	{
		$state_id = $_REQUEST['state_id'];
	}	

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if (!($cmn->isRecordExists("state", "state_id", $state_id, $record_condition)))
		$msg->sendMsg("state_list.php","",46);
	//END CHECK

	$objState = new state();
	$cancel_button = "javascript: window.location.href='state_list.php';";
	$condition= "";
	$objState->setAllValues($state_id,$condition);
	
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
                  <div class="fleft">State Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("state_list.php","state_list","Back","","back.png",false);?>
            <?php print $cmn->getAdminMenuLink("state_addedit.php","state_addedit","Edit","?state_id=".$state_id,"edit.png",false);?>
            <?php //print ($user_id!=1) ? $cmn->getAdminMenuLink("state_delete.php","state_delete","Delete","?state_id=".$state_id,"delete.png",false):"";?>
          
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
					$arrLanguages = $objState->fetchStateLanguage();
					$arrStateLanguages = $objState->fetchStateLanguageDetail();
					
					for($i=0;$i<count($language);$i++) { 
					if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1){
					?>
					<img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />
					<?php }} ?>
					</td>
		
				</tr>
			 <tr class="row01">
					<td align="left" valign="top" class="txtbo">
						State Code:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objState->state_code);?>
					</td>
		
				</tr>
			<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'State Name:';
			$state_name_value = $cmn->readValueDetail($objState->state_name);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$state_name_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrStateLanguages[$language[$i]['language_id']]['state_name']))
					$state_name_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_name']);
				
				if($state_name_value != "" || $language[$i]['language_id']==1)	{
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($state_name_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}} ?>
		<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'Secretary First Name:';
			$sfn_value = $cmn->readValueDetail($objState->state_secretary_fname);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$sfn_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrStateLanguages[$language[$i]['language_id']]['state_secretary_fname']))
					$sfn_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_secretary_fname']);
				
				if($sfn_value != "" || $language[$i]['language_id']==1)	{	
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($sfn_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}}?>
		<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'Secretary Middle Name:';
			$smn_value = $cmn->readValueDetail($objState->state_secretary_mname);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$smn_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrStateLanguages[$language[$i]['language_id']]['state_secretary_mname']))
					$smn_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_secretary_mname']);
				
				if($smn_value != "" || $language[$i]['language_id']==1)	{		
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($smn_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}}?>
		<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'Secretary Last Name:';
			$sln_value = $cmn->readValueDetail($objState->state_secretary_lname);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$sln_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrStateLanguages[$language[$i]['language_id']]['state_secretary_lname']))
					$sln_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_secretary_lname']);
				
				if($sln_value != "" || $language[$i]['language_id']==1)	{			
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($sln_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}}?>
		<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'Secretary Address:';
			$address1_value = $cmn->readValueDetail($objState->state_address1);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$address1_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrStateLanguages[$language[$i]['language_id']]['state_address1']))
					$address1_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_address1']);
				
				if($address1_value != "" || $language[$i]['language_id']==1)	{				
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($address1_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}}?>
		<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'Secretary Address2:';
			$address2_value = $cmn->readValueDetail($objState->state_address2);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$address2_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrStateLanguages[$language[$i]['language_id']]['state_address2']))
					$address2_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_address2']);
				
				if($address2_value != "" || $language[$i]['language_id']==1)	{	
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($address2_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}}?>
		<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'State City:';
			$city_value = $cmn->readValueDetail($objState->state_city);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$city_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrStateLanguages[$language[$i]['language_id']]['state_city']))
					$city_value = $cmn->readValueDetail($arrStateLanguages[$language[$i]['language_id']]['state_city']);
				
				if($city_value != "" || $language[$i]['language_id']==1)	{	
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($city_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}}?>
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Zip Code:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objState->zipcode);?>
					</td>
		
				</tr>
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Hotline No.:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objState->hotlineno);?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Toll Free:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objState->tollfree);?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Phone No.:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objState->phoneno);?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Fax No.:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objState->faxno);?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
							Email:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objState->email);?>
					</td>
		
				</tr>
				
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Active:
					</td>
		
					<td align="left" valign="top">
					
						&nbsp;<?php ($objState->state_active==1) ? print 'Yes' : print 'No' ?>
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
