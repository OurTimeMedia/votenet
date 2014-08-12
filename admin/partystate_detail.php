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
	if (!($cmn->isRecordExists("party_state", "state_id", $state_id, $record_condition)))
		$msg->sendMsg("partystate_list.php","",46);
	//END CHECK
	$objStateparty = new party_state();
	$cancel_button = "javascript: window.location.href='partystate_list.php';";
	$condition= "and es.state_id= ".$state_id;
	$partydata=$objStateparty->fetchAllAsArray($condition);
	$objLanguage = new language();
	$condi=" and language_isactive=1 and language_ispublish=1";
	$language=$objLanguage->fetchRecordSet("",$condi);
	$objstate = new state();
	$condition=" and state_id=".$state_id;
	$arrState = $objstate->fetchAllAsArray($state_id,$condition);
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
                  <div class="fleft">
		<?php echo $arrState[0]['state_name'];?> - Party Detail</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("partystate_list.php","partystate_list","Back","","back.png",false);?>
            <?php print ($state_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("partystate_addedit.php","partystate_addedit","Edit","?state_id=".$state_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("partystate_delete.php","partystate_delete","Delete","?state_id=".$state_id,"delete.png",false):"";?>
          
           		 </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">			 
				<tr class="row01">
					<td align="left" valign="top" class="txtbo" width="22%">
						State:
					</td>
		
					<td align="left" valign="top" width="78%">
					
						<?php echo $arrState[0]['state_code']." - ".$arrState[0]['state_name']; ?>&nbsp;
					</td>
		
				</tr>
				
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Party:
					</td>
		
					<td align="left" valign="top">
					
						<?php for($i=0;$i<count($partydata);$i++) {echo "&nbsp;-&nbsp;".$partydata[$i]['party_name']."<br>"; }?>&nbsp;
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
