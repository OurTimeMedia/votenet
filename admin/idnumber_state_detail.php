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
	if (!($cmn->isRecordExists("idnumber_state", "state_id", $state_id, $record_condition)))
		$msg->sendMsg("idnumber_state_list.php","",46);
	//END CHECK

	$objidnumber = new idnumber_state();
	$cancel_button = "javascript: window.location.href='idnumber_state_list.php';";
	//$condition= "";
	//$objidnumber->setAllValues($state_id,$condition);
	$condition= "and es.state_id= ".$state_id;
	$idnumberdata=$objidnumber->fetchAllAsArray($condition);
	
	$objstate = new state();
	$condition=" and state_id=".$state_id;
	$arrState = $objstate->fetchAllAsArray($state_id,$condition);
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
                  <div class="fleft"><?php echo $arrState[0]['state_name'];?> - ID Number Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("idnumber_state_list.php","idnumber_state_list","Back","","back.png",false);?>
            <?php print ($state_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("idnumber_state_addedit.php","idnumber_state_addedit","Edit","?state_id=".$state_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("idnumber_state_delete.php","idnumber_state_delete","Delete","?state_id=".$state_id,"delete.png",false):"";?>
          
           		 </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">			 
				<tr class="row02">
					<td align="left" valign="top" class="txtbo" width="22%">
						State:
					</td>
		
					<td align="left" valign="top" width="78%">
					
						<?php echo $arrState[0]['state_code']." - ".$arrState[0]['state_name']; ?>&nbsp;
					</td>
		
				</tr>
				
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						ID Number:
					</td>
		
					<td align="left" valign="top">
					<?php for($i=0;$i<count($idnumberdata);$i++) {echo "&nbsp;-&nbsp;".$idnumberdata[$i]['id_number_name']."<br>"; }?>&nbsp;
						<?php //echo $objidnumber->id_number_name; ?>&nbsp;
					</td>
		
				</tr>
				<?php 
			$objidnumber->state_id = $state_id;
			$arrLanguages = $objidnumber->fetchIdNumberNoteLanguage();
			$arrIdNumberLanguages = $objidnumber->fetchIdNumberLanguageDetail();
			
			$state_idnumber_note_text = "";
			
			for($i=0;$i<count($language);$i++) {
			$styleDetail = '';
			$lableField = 'Note:';
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$state_idnumber_note_text = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages))
			{
				$styleDetail = '';				
				if(isset($arrIdNumberLanguages[$language[$i]['language_id']]['state_idnumber_note_text']))
					$state_idnumber_note_text = $cmn->readValueDetail($arrIdNumberLanguages[$language[$i]['language_id']]['state_idnumber_note_text']);
			?>
				<tr class="row02">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($state_idnumber_note_text);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }} ?>
		
			</table>
            </div>
          </div>
        </div>
      </div>
    </div>
 </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
