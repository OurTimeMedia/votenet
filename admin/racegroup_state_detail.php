<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	$user_id = 0;
	if (isset($_REQUEST['state_id']) && trim($_REQUEST['state_id'])!="")
	{
		$state_id = $_REQUEST['state_id'];
	}	

	//CHECK FOR RECORED EXISTS
	/*$record_condition = "";	
	if (!($cmn->isRecordExists("racegroup_state", "state_id", $state_id, $record_condition)))
		$msg->sendMsg("racegroup_state_list.php","",46);*/
	//END CHECK

	$objStateRaceGroup = new racegroup_state();
	$cancel_button = "javascript: window.location.href='racegroup_state_list.php';";
	$condition= "";
	$objStateRaceGroup->setAllValues($state_id,$condition);
	
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);
	$objstate = new state();
	$condition=" and state_id=".$state_id;
	$arrState = $objstate->fetchAllAsArray($state_id,$condition);
	
	$condition= "and es.state_id= ".$state_id;
	$racegroupdata=$objStateRaceGroup->fetchAllAsArray($condition);
	
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
                  <div class="fleft"><?php echo $arrState[0]['state_name'];?> - Race Group Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("racegroup_state_list.php","racegroup_state_list","Back","","back.png",false);?>
            <?php print ($state_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("racegroup_state_addedit.php","racegroup_state_addedit","Edit","?state_id=".$state_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("racegroup_state_delete.php","racegroup_state_delete","Delete","?state_id=".$state_id,"delete.png",false):"";?>
          
           		 </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">			 
				<tr class="row01">
					<td align="left" valign="top" class="txtbo" width="22%">
						States:
					</td>
		
					<td align="left" valign="top" width="78%">
					
						<?php echo $arrState[0]['state_code']." - ".$arrState[0]['state_name']; ?>&nbsp;
					</td>
		
				</tr>
				
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Race Group:
					</td>
		
					<td align="left" valign="top">
					<?php for($i=0;$i<count($racegroupdata);$i++) {echo "&nbsp;-&nbsp;".$racegroupdata[$i]['race_group_name']."<br>"; }?>
						<?php //echo $objStateRaceGroup->race_group_name; ?>&nbsp;
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
