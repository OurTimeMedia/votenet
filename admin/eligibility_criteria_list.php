<?php
require_once 'include/general_includes.php';
	
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$objEligCrit = new eligibility_criteria();
require_once 'eligibility_criteria_db.php';
$condition = "";
$isForAllState = "";

if(isset($_REQUEST['txtsearchname']))
{
	if (trim($_REQUEST['txtsearchname'])!="")
		$condition .= " AND ( eligibility_criteria like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%')";
							
}

if(isset($_REQUEST['selForAllState']))
{
	$isForAllState = $_REQUEST['selForAllState'];
	if (trim($_REQUEST['selForAllState'])!="")
		$condition .= " AND ( for_all_state  = '".$cmn->setVal(trim($_REQUEST['selForAllState']))."')";
							
}


$objpaging->strorderby = DB_PREFIX."eligibility_criteria.eligibility_criteria_id";
$objpaging->strorder = "desc";
$arr = $objpaging->setPageDetails($objEligCrit,"eligibility_criteria_list.php",PAGESIZE,$condition);
$extraJs = array("eligibility_criteria_list.js");
$aAccess = $cmn->getAccess("eligibility_criteria_list.php", "eligibility_criteria_list", 11);	

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
                  <div class="fleft">Eligibility Criterias</div>
                  <div class="fright"> 
				  	<?php print $cmn->getAdminMenuLink("eligibility_criteria_addedit.php","eligibility_criteria_addedit","Create","","add_new.png");?> 
				  </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
            <form id="frm" name="frm" method="post">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td><div>
                    <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;">
					<tr>
					  <td <?php if ($aAccess[0]) { ?> colspan="4"<?php } else { ?> colspan="3"<?php } ?> class="row2">	
						<table width="100%" cellspacing="0" cellpadding="0">                                
						 <tr>                                   
						  <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="15%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>"/></td>
							<td width="9%" valign="middle" align="left"><strong>For All State:</strong></td>
                                    <td width="10%" valign="middle">
									<select id="selForAllState" name="selForAllState">
										<option value="">- Select -</option>
										<option value="1" <?php if($isForAllState == "1") { echo "selected";}?>>Yes</option>
										<option value="0" <?php if($isForAllState == "0") { echo "selected";}?>>No</option>
									</select>
									</td>
									
                                    <td width="24%" valign="middle"><input type="button" class="btn" value="Search" name="btnsearch" id="btnsearch" onClick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript:document.frm.submit();"/>&nbsp;&nbsp;<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript: window.location.href='eligibility_criteria_list.php';"/></td>
                                    <td width="37%" valign="middle" align="right">&nbsp;</a></td>
						</tr>
						</table>
					  </td>
					</tr>	
                      <tr bgcolor="#a9cdf5" class="txtbo">
                        <td width="60%" align="left" nowrap="nowrap"><strong>Eligibility Criteria</strong>
                            <?php $objpaging->_sortImages("eligibility_criteria", $cmn->getCurrentPageName()); ?></td>
				<td width="20%" align="left" nowrap="nowrap"><strong>For All State</strong>
                            <?php $objpaging->_sortImages("for_all_state", $cmn->getCurrentPageName()); ?></td>
                        <td width="20%" align="center"><strong>Active</strong>
                            <?php $objpaging->_sortImages("eligibility_active", $cmn->getCurrentPageName()); ?></td>
                        <?php  
							if ($aAccess[0])
							{
							?>
                        <td width="10%" align="center">Action</td>
                        <?php
							}
							?>
                      </tr>
                      <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$areligibility_criteria_id[] = $arr[$i]["eligibility_criteria_id"] ?>
                      <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                      <tr class="<?php echo $strrow_class?>">
                        <td align="left" valign="top"><?php 
							if ($aAccess[0])
							{
							?>
                            <a title="<?php print $cmn->readValueDetail($arr[$i]["eligibility_criteria"]); ?>" href="eligibility_criteria_detail.php?eligibility_criteria_id=<?php print $cmn->readValueDetail($arr[$i]["eligibility_criteria_id"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["eligibility_criteria"]); ?></a>
                            <?php
							} 
							else 
							{
								print $cmn->readValueDetail($arr[$i]["eligibility_criteria"]);
							}
							?>                        &nbsp;</td>   
<td align="center" valign="top"><?php ($cmn->readValueDetail($arr[$i]["for_all_state"])==1) ? print 'Yes' : print 'No' ?>                     &nbsp;   </td>							
                        <td align="center" valign="top"><?php ($cmn->readValueDetail($arr[$i]["eligibility_active"])==1) ? print 'Yes' : print 'No' ?>                     &nbsp;   </td>
                        <?php 
							if ($aAccess[0])
							{
							?>
                        <td align="center" valign="top"><a title="View" href="eligibility_criteria_detail.php?eligibility_criteria_id=<?php print $cmn->readValueDetail($arr[$i]["eligibility_criteria_id"]); ?>" class="gray_btn_view">View</a></td>
                        <?php
							}
                            ?>
                      </tr>
                      <?php 
						}
						 if(!empty($areligibility_criteria_id)) 
						 	$inactiveids = implode(",",$areligibility_criteria_id); 
						 if (count($arr)==0){ ?>
                      <tr>
                        <td colspan="<?php echo $aAccess[1] ?>" align="center">No record found.</td>
                      </tr>
                      <?php } else { ?>
                      <input type="hidden" name="inactiveids" value="<?php print $inactiveids; ?>" />
                      <input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $strmode; ?>"/>
                      <?php } ?>
                    </table>
                  </div>
                    <div class="fclear"></div></td>
                </tr>
                <tr>
                  <td><div id="pager"><?php print $objpaging->drawPanel("panel1"); ?></div></td>
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