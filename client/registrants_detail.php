<?php
require_once 'include/general_includes.php';
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$objEncDec = new encdec();
$objpaging = new paging();
$objState = new state();

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$objEncDec = new encdec();	

$rid = 0;
	
if (isset($_REQUEST['rid']) && trim($_REQUEST['rid'])!="")
{
	$rid = $objEncDec->decrypt($_REQUEST['rid']);	
}

//CHECK FOR RECORED EXISTS
$record_condition = "";	

if (!($cmn->isRecordExistsReport("rpt_registration", "rpt_reg_id", $rid, $record_condition)))
	$msg->sendMsg("registrants_list.php","",46);
	  
//END CHECK
$cancel_button = "javascript: window.location.href='registrants_list.php';";

$objRegistrant = new registrantreport();
$objRegistrant->client_id = $client_id;
$entryDetailArr = $objRegistrant->setAllValues($rid);

include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";

$objFieldReport = new field();
$objFieldReport->language_id = 1;
$objFieldReport->client_id = $client_id;
$condition = " AND field_mapping_id='1' ";
$fieldList = $objFieldReport->fetchAllFieldReport($client_id, $condition);

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
                  <div class="fleft">Registrant Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getClientMenuLink("registrants_list.php","registrants_list","Back","","back.png",false);?>
                  <?php //print $cmn->getClientMenuLink("registrant_delete.php","registrant_delete","Delete","?rid=".$objEncDec->encrypt($rid),"delete.png",false); ?>
				  </div>
                </div>
              </div>
            </div>
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
								 <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">
								 <?php 
								 $submission_detail = "";
								 for($i=0;$i<count($fieldList);$i++){ 
								 
								 $field_id = $fieldList[$i]["rpt_field_id"];								 
								 $field_caption = $cmn->readValueDetail($fieldList[$i]["field_caption"]);

								 $condSub = " AND field_mapping_id <> '1' AND field_header_field = '".$field_id."' ";
								 $fieldListSub = $objFieldReport->fetchAllFieldReport($client_id, $condSub);
								 
								 $header_detail = '<tr class="row1" style="bgcolor:#a9cdf5;">
										<td align="left" valign="top" class="listtab-rt-bro-user" colspan="2">
											<strong>'.$field_caption.'</strong>
										</td></tr>';	
								
								$field_detail = "";
								for($is=0;$is<count($fieldListSub);$is++){
								 $field_id = $fieldListSub[$is]["rpt_field_id"];
								 $field_mapping_id = $fieldListSub[$is]["field_mapping_id"];
								 $field_caption = $cmn->readValueDetail($fieldListSub[$is]["field_caption"]);
								
								 $field_value = $cmn->readValueDetail($entryDetailArr['field_'.$field_id]);
								 
								 if($field_mapping_id == 3 && $field_value != "")
									$field_value = "Yes";
								 
									 if(trim($field_value) != "")
									 {
										if($field_mapping_id == 7)
										{
											$objeligibility_state= new eligibility_state();
											$eligibility_criteria=$objeligibility_state->fetchstatewiseAsArray($entryDetailArr['voter_state_id'],1);
											
											$selectedCriterias = explode("|^|", $field_value);
											$selectedCriteriaArr = Array();
											foreach($selectedCriterias as $sckey=>$scval)
											{
												$selectedCriteria = array();
												$selectedCriteria = explode("_", $scval);
												$selectedCriteriaArr[] = $selectedCriteria[0];
											}
											
											$selected_field_options = array();
											for($j=0; $j<count($eligibility_criteria); $j++)
											{												
												$field_option_id = $eligibility_criteria[$j]["eligibility_criteria_id"];
												
												if(in_array($field_option_id, $selectedCriteriaArr))
													$selected_field_options[] = $eligibility_criteria[$j]["eligibility_criteria"];
											}
											
											$selected_field_option = implode("<br>",$selected_field_options);
											
											$field_detail.= '<tr class="row4">
												<td align="left" valign="top" width="20%" class="left-none">
													<strong>'.$field_caption.'</strong>
												</td>		
												<td align="left" valign="top" class="listtab-rt-bro-user">
													'.$selected_field_option.'&nbsp;
												</td>		
												</tr>';											
										}
										else if($field_mapping_id == 10)
										{
											$field_detail.= '<tr class="row4">
												<td align="left" valign="top" width="20%" class="left-none">
													<strong>'.$field_caption.'</strong>
												</td>		
												<td align="left" valign="top" class="listtab-rt-bro-user">******************</td></tr>';									
										}
										else
										{
											$field_detail.= '<tr class="row4">
												<td align="left" valign="top" width="20%" class="left-none">
													<strong>'.$field_caption.'</strong>
												</td>		
												<td align="left" valign="top" class="listtab-rt-bro-user">
													&nbsp;'.$field_value.'
												</td></tr>';	
										}		
									}
									else
									{
										$field_detail.= '<tr class="row4">
												<td align="left" valign="top" width="20%" class="left-none">
													<strong>'.$field_caption.'</strong>
												</td>		
												<td align="left" valign="top" class="listtab-rt-bro-user">
													&nbsp;
												</td></tr>';	
									}
								}
								
								if($field_detail != "")
									$submission_detail.=$header_detail.$field_detail;
								
								} 
								echo $submission_detail;
								?>	
								</table>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
 	</div>
</div>
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>
</body>
</html>