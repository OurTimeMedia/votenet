<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	
	$language_id = 0;
		
	if (isset($_REQUEST['language_id']) && trim($_REQUEST['language_id'])!="")
	{
		$language_id = $_REQUEST['language_id'];
		$entityID = $_REQUEST['language_id'];
	}
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if (!($cmn->isRecordExists("language", "language_id", $language_id, $record_condition)))
		$msg->sendMsg("language_list.php","",46);
		  
	//END CHECK

	$objLanguage = new language();

	$cancel_button = "javascript: window.location.href='language_list.php';";
	
	$objLanguage->setAllValues($language_id);
	
	$objResource = new resource();
	$resourceArray = $objResource->fetchAllAsArray();
	
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
                  <div class="fleft">Language Detail</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("language_list.php","language_list","Back","","back.png",false);?>
            <?php print $cmn->getAdminMenuLink("language_addedit.php","language_addedit","Edit","?hdnlanguage_id=".$language_id,"edit.png",false);?>
            <?php print $cmn->getAdminMenuLink("language_delete.php","language_delete","Delete","?language_id=".$language_id,"delete.png",false);?>
           			</div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

				<tr class="row01" >
			<td align="left" valign="top" width="15%" class="txtbo">
				Language Name:
			</td>

			<td align="left" valign="top">
				&nbsp;<?php echo htmlspecialchars($objLanguage->language_name); ?>
			</td>

		</tr>
        
        <tr class="row01" >
			<td align="left" valign="top" width="15%" class="txtbo">
				Language Code:
			</td>

			<td align="left" valign="top">
				&nbsp;<?php echo htmlspecialchars($objLanguage->language_code); ?>
			</td>

		</tr>
        
        <tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Image:
			</td>

			<td align="left" valign="top">
			
			&nbsp;<img src='<?php echo SERVER_HOST ?>common/files/image.php/<?php echo $objLanguage->language_icon?>?width=16&amp;height=16&amp;cropratio=1:1&amp;image=/files/languages/<?php echo $objLanguage->language_icon?>' alt='<?php echo htmlspecialchars($objLanguage->language_name); ?>'  title='<?php echo htmlspecialchars($objLanguage->language_name); ?>'   />
				
			</td>

		</tr>
        
        <tr class="row01" >
			<td align="left" valign="top" width="15%" class="txtbo">
				Language Order:
			</td>

			<td align="left" valign="top">
				&nbsp;<?php echo htmlspecialchars($objLanguage->language_order); ?>
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Active:
			</td>

			<td align="left" valign="top">
			&nbsp;<?php ($objLanguage->language_isactive==1) ? print 'Yes' : print 'No' ?>
			</td>
		</tr>
        
        <tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Publish:
			</td>

			<td align="left" valign="top">
			&nbsp;<?php ($objLanguage->language_ispublish==1) ? print 'Yes' : print 'No' ?>
			</td>
		</tr>
        
         <tr class="row01">
        	<td class="txtbo" colspan="2">&nbsp;</td>
        </tr>
        <tr class="blue_title">
			<td align="left" valign="top" class="blue_title_rt" colspan="2">
				Language Configuration Section mock-up for Language : <?php echo htmlspecialchars($objLanguage->language_name); ?>
			</td>
		</tr>
       
        
        <?PHP
		   if(is_array($resourceArray))
		   {
		   		for($i=0;$i<count($resourceArray);$i++)
				{
					$resDtl = $objLanguage->fetchLanguageResourceRel($resourceArray[$i]["resource_id"],$objLanguage->language_id);
					?>
                    <tr class="row01">
                        <td align="left" valign="top" class="txtbo">
                            <?PHP echo ucwords(strtolower($resourceArray[$i]["resource_text"])); ?>:
                        </td>
            
                        <td align="left" valign="top">
                        &nbsp;<?php echo html_entity_decode($resDtl["resource_text"]); ?>
                        </td>
                	</tr>
		<?PHP	}
		   }
		?>

			</table>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
