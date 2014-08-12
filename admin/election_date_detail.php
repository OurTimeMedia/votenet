<?php
//include general base file
require_once("include/general_includes.php");

//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$user_id = 0;

//get id to display data 
if (isset($_REQUEST['election_date_id']) && trim($_REQUEST['election_date_id'])!="")
{
	$election_date_id = $_REQUEST['election_date_id'];
}	

//CHECK FOR RECORED EXISTS
$record_condition = "";	
if (!($cmn->isRecordExists("election_date", "election_date_id", $election_date_id, $record_condition)))
	$msg->sendMsg("election_date_list.php","",46);
//END CHECK

//set all value for given id
$objElectionDate = new election_date();
$cancel_button = "javascript: window.location.href='election_date_list.php';";
$condition= "";
$objElectionDate->setAllValues($election_date_id,$condition);

//fetch langauge detail
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
                  <div class="fleft">Election Date Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("election_date_list.php","state_list","Back","","back.png",false);?>
            <?php print ($election_date_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("election_date_addedit.php","state_addedit","Edit","?election_date_id=".$election_date_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("election_date_delete.php","state_delete","Delete","?election_date_id=".$election_date_id,"delete.png",false):"";?>
          
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
					$arrLanguages = $objElectionDate->fetchElectionDateLanguage();
					$arrElectionDateLanguages = $objElectionDate->fetchElectionDateLanguageDetail();
					
					for($i=0;$i<count($language);$i++) { 
					if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1){
					?>
					<img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />
					<?php }} ?>
					</td>
		
				</tr>
			 <tr class="row01">
				<td align="left" valign="top" width="18%" class="txtbo">Election Type:&nbsp;<span class="compulsory">*</span>&nbsp;</td>
				<td align="left" valign="top"><?php echo $objElectionDate->election_type_name;?>&nbsp;</td>
			 </tr>
			<tr class="row01">
				<td align="left" valign="top" width="18%" class="txtbo">State:&nbsp;<span class="compulsory">*</span>&nbsp;</td>
				<td align="left" valign="top"><?php echo $objElectionDate->state_code;?> - <?php echo $objElectionDate->state_name;?>&nbsp;</td>
			</tr>
			<tr class="row01">
				<td align="left" valign="top" width="18%" class="txtbo">Election Date:&nbsp;<span class="compulsory">*</span>&nbsp;</td>
				<td align="left" valign="top"><?php echo $cmn->convertFormtDate($objElectionDate->election_date,"m/d/Y");?>&nbsp;</td>
			</tr>			
			<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'Description:';
			$Description_value = $cmn->readValueDetail($objElectionDate->election_description);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$Description_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrElectionDateLanguages[$language[$i]['language_id']]['election_description']))
					$Description_value = $cmn->readValueDetail($arrElectionDateLanguages[$language[$i]['language_id']]['election_description']);
					
				if($Description_value != "" || $language[$i]['language_id']==1)
				{		
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($Description_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}} ?>
		<tr class="row01">
				<td align="left" valign="top" width="18%" class="txtbo">Registration Deadline Date:&nbsp;<span class="compulsory">*</span>&nbsp;</td>
				<td align="left" valign="top"><?php echo $cmn->convertFormtDate($objElectionDate->reg_deadline_date,"m/d/Y");?>&nbsp;</td>
		</tr>
		<?php 
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'Registration Deadline Description:';
			$sfn_value = $cmn->readValueDetail($objElectionDate->reg_deadline_description);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$sfn_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrElectionDateLanguages[$language[$i]['language_id']]['reg_deadline_description']))
					$sfn_value = $cmn->readValueDetail($arrElectionDateLanguages[$language[$i]['language_id']]['reg_deadline_description']);
				
				if($sfn_value != "" || $language[$i]['language_id']==1)
				{				
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($sfn_value); if($sfn_value != "") { ?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" /><?php } ?></td>
		
				</tr>
			<?php }}}?>			
			</table>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
