<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	$user_id = 0;
	if (isset($_REQUEST['id_number_id']) && trim($_REQUEST['id_number_id'])!="")
	{
		$id_number_id = $_REQUEST['id_number_id'];
	}	

	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if (!($cmn->isRecordExists("id_number", "id_number_id", $id_number_id, $record_condition)))
		$msg->sendMsg("id_number_list.php","",46);
	//END CHECK

	$objIdNumber = new id_number();
	$cancel_button = "javascript: window.location.href='id_number_list.php';";
	$condition= "";
	$objIdNumber->setAllValues($id_number_id,$condition);
	
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
                  <div class="fleft">ID Number Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("id_number_list.php","id_number_list","Back","","back.png",false);?>
            <?php print ($id_number_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("id_number_addedit.php","id_number_addedit","Edit","?id_number_id=".$id_number_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("id_number_delete.php","id_number_delete","Delete","?id_number_id=".$id_number_id,"delete.png",false):"";?>
          
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
					$arrLanguages = $objIdNumber->fetchIdNumberLanguage();
					$arrIdNumberLanguages = $objIdNumber->fetchIdNumberLanguageDetail();
					
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
			$lableField = 'ID Number Name:';
			$id_number_name_value = $cmn->readValueDetail($objIdNumber->id_number_name);
			
			if($language[$i]['language_id']!=1)
			{				
				$lableField = '&nbsp;';
				$id_number_name_value = "";
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages) || $language[$i]['language_id']==1)
			{
				$styleDetail = '';				
				if(isset($arrIdNumberLanguages[$language[$i]['language_id']]['id_number_name']))
					$id_number_name_value = $cmn->readValueDetail($arrIdNumberLanguages[$language[$i]['language_id']]['id_number_name']);
			?>
				<tr class="row01">
					<td align="left" valign="top" width="22%" class="txtbo">
						<?php echo $lableField;?>					</td>
		
					<td width="78%" align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($id_number_name_value);?><img src="images/<?php echo $language[$i]['language_icon'];?>" style="margin-left:10px;" />					</td>
		
				</tr>
		<?php }}
		if($objIdNumber->id_number_length == 0)
						$objIdNumber->id_number_length = "";
		?>		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">Max Length:</td>
					<td align="left" valign="top">&nbsp;<?php echo $objIdNumber->id_number_length; ?>
					</td>		
				</tr>	
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">Active:</td>
					<td align="left" valign="top">&nbsp;<?php ($objIdNumber->id_number_active==1) ? print 'Yes' : print 'No' ?>
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