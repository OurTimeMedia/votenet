<?php
//include general base file
require_once("include/general_includes.php");

//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$user_id = 0;

//get id to display data 
if (isset($_REQUEST['election_type_id']) && trim($_REQUEST['election_type_id'])!="")
{
	$election_type_id = $_REQUEST['election_type_id'];
}	

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if (!($cmn->isRecordExists("election_type", "election_type_id", $election_type_id, $record_condition)))
		$msg->sendMsg("election_type_list.php","",46);
	//END CHECK
	
	//set all value for given id
	$objElectionType = new election_type();
	$cancel_button = "javascript: window.location.href='election_type_list.php';";
	$condition= "";
	$objElectionType->setAllValues($election_type_id,$condition);
	
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
                  <div class="fleft">Election Type Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("election_type_list.php","election_type_list","Back","","back.png",false);?>
            <?php print ($election_type_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("election_type_addedit.php","election_type_addedit","Edit","?election_type_id=".$election_type_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("election_type_delete.php","election_type_delete","Delete","?election_type_id=".$election_type_id,"delete.png",false):"";?>
          
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
					$arrLanguages = $objElectionType->fetchElectionTypeLanguage();
					$arrElectionTypeLanguages = $objElectionType->fetchElectionTypeLanguageDetail();
					
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
			$lableField = 'Election Type Name:';
			$election_type_name_value = $cmn->readValueDetail($objElectionType->election_type_name);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$election_type_name_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrElectionTypeLanguages[$language[$i]['language_id']]['election_type_name']))
					$election_type_name_value = $cmn->readValueDetail($arrElectionTypeLanguages[$language[$i]['language_id']]['election_type_name']);
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($election_type_name_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}?>		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">Active:</td>
					<td align="left" valign="top">&nbsp;<?php ($objElectionType->election_type_active==1) ? print 'Yes' : print 'No' ?>
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