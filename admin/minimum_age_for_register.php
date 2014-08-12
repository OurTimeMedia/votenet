<?php
require_once 'include/general_includes.php';
	
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$objstate = new state();
$objstate1 = new state();
require_once 'minimum_age_for_register_db.php';
$condition = "";

$objpaging->strorderby = DB_PREFIX."state.state_code";
$objpaging->strorder = "ASC";
$arr = $objpaging->setPageDetails($objstate,"minimum_age_for_register.php",-1,$condition);
$extraJs = array("minimum_age_for_register.js");
$aAccess = $cmn->getAccess("minimum_age_for_register.php", "minimum_age_for_register", 4);	

include SERVER_ADMIN_ROOT."include/header.php";
include SERVER_ADMIN_ROOT."include/top.php";

$voter_age_condition = array("1"=>"Voter must be at least 18 years old by next election.", 
							"2"=>"Voter must be at least 17 years old on today.", 
							"3"=>"Voter must be at least 17 1/2 years old on today.", 
							"4"=>"Voter must be at least 16 years old on today.", 
							"5"=>"Voter must turn 18 by the", 
							"6"=>"Voter must be at least 17 years and 10 months old to register.", 
							"7"=>"Voter must turn 18 the same calender year in which you register.", 
							"8"=>"Voter must turn 18 years old within 90 days.");

$objElectionType = new election_type();
$condition_et = "election_type_active = '1'";		
$arrElectionType = $objElectionType->fetchAllAsArray($condition_et);

$objLanguage = new language();
$condi=" and language_isactive=1 and language_ispublish=1";
$language=$objLanguage->fetchRecordSet("",$condi);
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
                  <div class="fleft">Minimum Age for Register to Vote</div>
                  <div class="fright"> 
				  	<?php //print $cmn->getAdminMenuLink("state_addedit.php","state_addedit","Create","","add_new.png");?> 
				  </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
            <form id="frm" name="frm" method="post" onsubmit="return validate();">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td><div>
                    <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;">					  	
                      <tr bgcolor="#a9cdf5" class="txtbo">
                        <td width="8%" align="left" nowrap="nowrap"><strong>State Code</strong></td>
                        <td  width="12%" align="left"><strong>State Name</strong></td>                        
						<td width="40%" align="center"><strong>Age Criteria</strong></td>
						<td width="40%" align="center"><strong>Notes</strong></td>						
                      </tr>
                      <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$arstate_id[] = $arr[$i]["state_id"];
							$objstate1->state_id = $arr[$i]["state_id"];
							$arrStateLanguages = $objstate1->fetchStateLanguageDetail();
					  ?>
                      <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                      <tr class="<?php echo $strrow_class?>">
                        <td align="left"  valign="top"><?php print $cmn->readValueDetail($arr[$i]["state_code"]);?>&nbsp;</td>
                        <td align="left" valign="top"><?php print $cmn->readValueDetail($arr[$i]["state_name"]); ?>&nbsp;</td>
                        <td align="left" valign="top">
						<?php 
						$ageCriteriaArr = array();
						$selElectionType = array();
						
						if(isset($arr[$i]["state_minimum_age_criteria"]) && $arr[$i]["state_minimum_age_criteria"] !="")
							$ageCriteriaArr = explode(",",$arr[$i]["state_minimum_age_criteria"]);
						if(isset($arr[$i]["state_minimum_age_criteria_election_type"]) && $arr[$i]["state_minimum_age_criteria_election_type"] !="")
							$selElectionType = explode(",", $arr[$i]["state_minimum_age_criteria_election_type"]);	
							
						foreach($voter_age_condition as $vackey=>$vacval) { 
						if($vackey == 5) { ?>						
						<table cellpadding="0" cellspacing="0" border="0" style="clear:both;">
						<tr>
						<td align="left" valign="top" style="padding:0px;"><input type="checkbox" name="chkAgeCriteria_<?php print $arr[$i]["state_id"];?>[]" value="<?php echo $vackey;?>" onclick="showHideElectionType(this,<?php print $arr[$i]["state_id"];?>)" <?php if(in_array($vackey, $ageCriteriaArr)) { echo "checked";} ?>> <?php echo $vacval;?></td>
						<td align="left">	
						<select multiple size="3" name="selElectionType_<?php print $arr[$i]["state_id"];?>[]" id="selElectionType_<?php print $arr[$i]["state_id"];?>" <?php if(!in_array($vackey, $ageCriteriaArr)) { echo "disabled";} ?>><?php foreach($arrElectionType as $aetkey=>$aetval) { ?>
						<option value="<?php echo $aetval['election_type_id'];?>" <?php if(in_array($aetval['election_type_id'],$selElectionType)) { echo "selected";} ?>><?php echo $aetval['election_type_name'];?></option>
						<?php } ?>
						</select>
						</td></tr></table>
						<br />
						<?php } else { ?>
						<input type="checkbox" name="chkAgeCriteria_<?php print $arr[$i]["state_id"];?>[]" value="<?php echo $vackey;?>" <?php if(in_array($vackey, $ageCriteriaArr)) { echo "checked";} ?>> <?php echo $vacval;?><br />
						<?php }}  ?>
						</td>
						<td align="center" valign="top">
						<table cellpadding="0" cellspacing="0" border="0" style="clear:both;">
						<?php for($il=0;$il<count($language);$il++) { 
						if($language[$il]['language_id']==1) 						
						{
						?>
						<tr>
						<td align="left" valign="top" style="padding:0px;"><textarea cols="60" rows="1" id="txtNote_<?php print $arr[$i]["state_id"];?>" name="txtNote_<?php print $arr[$i]["state_id"];?>"><?php print $cmn->readValueDetail($arr[$i]["state_minimum_age_text"]);?></textarea>	<img src="images/<?php echo $language[$il]['language_icon']?>" style="margin-left:10px; vertical-align: top;" title="<?php echo $language[$il]['language_name']?>" /></td></tr>
						<?php } else { ?>
						<tr>
						<td align="left" valign="top" style="padding:0px;"><textarea cols="60" rows="1" id="txtNote_<?php print $arr[$i]["state_id"];?>_<?php echo $language[$il]['language_id'];?>" name="txtNote_<?php print $arr[$i]["state_id"];?>_<?php echo $language[$il]['language_id'];?>"><?php print $cmn->readValueDetail($arrStateLanguages[$language[$il]['language_id']]['state_minimum_age_text']);?></textarea>	<img src="images/<?php echo $language[$il]['language_icon']?>" style="margin-left:10px; vertical-align: top;" title="<?php echo $language[$il]['language_name']?>" /></td></tr>
						<?php }} ?>
						</table>
						</td>						
                      </tr>					  
                      <?php 
						} ?>
					<tr>
                        <td colspan="4" align="center"><input type="submit" name="btnUpdate" id="btnUpdate" value="Update" class="btn"></td>
                      </tr>	
					<?php	
						 if (count($arr)==0){ ?>
                      <tr>
                        <td colspan="4" align="center">No record found.</td>
                      </tr>
                      <?php } ?>
                    </table>
                  </div>
                    <div class="fclear"></div></td>
                </tr>                
              </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
	<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>