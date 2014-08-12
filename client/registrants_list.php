<?php
require_once 'include/general_includes.php';

// check if user is logged in.
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$objEncDec = new encdec();
$objpaging = new paging();
$objState = new state();

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id", $userID);

$state_id = 0;

if (isset($_REQUEST['selState']) && $_REQUEST['selState'] != "")
  $state_id = $_REQUEST['selState'];

$definedColSpan = 7;

$objRegistrant = new registrantreport();
$objRegistrant->client_id = $client_id;

$condition = '';
$objpaging->strorderby = "rr.rpt_reg_id";
$objpaging->strorder = "desc";

$condition.= " AND rr.client_id = '" . $objRegistrant->client_id . "' ";

if (isset($_REQUEST['txtdatefrom'])) {
  if (trim($_REQUEST['txtdatefrom']) != "")
    $condition .= " AND DATE(rr.voting_date) >= date_format( str_to_date( '" . $cmn->setVal($_REQUEST['txtdatefrom']) . "', '%m/%d/%Y' ) , '%Y-%m-%d' )";
}

if (isset($_REQUEST['txtdateto'])) {
  if (trim($_REQUEST['txtdateto']) != "")
    $condition .= " AND DATE(rr.voting_date) <= date_format( str_to_date( '" . $cmn->setVal($_REQUEST['txtdateto']) . "', '%m/%d/%Y' ) , '%Y-%m-%d' )";
}

if (isset($_REQUEST['selState'])) {
  if (trim($_REQUEST['selState']) != "")
    $condition .= " AND rr.voter_state_id = '" . $_REQUEST['selState'] . "'";
}

$objRegistrant->pagingType = "cReports";
$arr = $objpaging->setPageDetails($objRegistrant, "registrants_list.php", PAGESIZE, $condition);

// include extra css and js
$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css", "calendar.css");
$extraJs = array("jquery-ui-timepicker-addon.min.js");

$arrState = $objState->fetchAllAsArray();

$aAccess = $cmn->getAccessClient("registrants_detail.php", "registrants_detail" , 8);		
$aAccess1 = $cmn->getAccessClient("registrants_detail_export.php", "registrants_detail_export" , 8);		
?>
<?php
include SERVER_CLIENT_ROOT . "include/header.php";
include SERVER_CLIENT_ROOT . "include/top.php";
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
                  <div class="fleft">Registrants</div>
                  <div class="fright"></div>
                </div>
              </div>
            </div>
            <div class="content-box">
              <div class="content-left-shadow">
                <div class="content-right-shadow">
                  <div class="content-box-lt">
                    <div class="content-box-rt">
                      <div class="blue_title_cont">
                        <form id="frm" name="frm" method="post">
                          <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td><div class="white">
                                  <table cellpadding="0" cellspacing="0" border="0" class="border-none" width="100%" style="clear:both;" >
                                    <tr>
                                      <td colspan="9" align="left">
                                        <table width="100%" class="listtab-rt-bro" cellspacing="0" cellpadding="5">
                                          <tbody>
                                            <tr>
                                              <td width="10%" align="left" valign="middle"><strong>Date From</strong></td>
                                              <td width="15%" valign="middle" align="left">
                                                <input type="text" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtdatefrom'], "")); ?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom" readonly="readonly"/>
                                                &nbsp;<img src="<?php echo SERVER_CLIENT_HOST ?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">
                                              </td>
                                              <td width="7%" align="left" valign="middle"><strong>Date To</strong></td>
                                              <td width="15%" valign="middle"><input type="text" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtdateto'], "")); ?>" class="reprot-input" name="txtdateto" id="txtdateto" readonly="readonly"/>
                                                &nbsp;<img src="<?php echo SERVER_CLIENT_HOST ?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();"></td>
                                              <td width="20%" height="40" valign="middle"><label>
                                                  <select name="selState" id="selState" onchange="document.frm.submit();">
                                                    <option value="">All State</option>
                                                    <?php for ($i = 0; $i < count($arrState); $i++) { ?>
                                                      <option value="<?php echo $arrState[$i]['state_id']; ?>" <?php
                                                    if ($arrState[$i]['state_id'] == $state_id) {
                                                      echo "selected";
                                                    }
                                                      ?>><?php echo $arrState[$i]['state_code']; ?> - <?php echo $arrState[$i]['state_name']; ?></option>
                                                            <?php } ?>
                                                  </select>
                                                </label>
                                              </td>
                                              <td width="27%" align="left">
                                                <input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch" onclick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; "/>
                                                &nbsp;<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='registrants_list.php';"/></td> 
                                            </tr>
                                            <tr><Td colspan="6" align="right" valign="middle"><input type="button" class="btn" value="Export to Excel" name="btnclear" id="exprot-btn" onclick="javascript:document.frm.action='registrants_list_export.php';document.frm.submit(); document.frm.action='';"></td></tr>

                                          </tbody>
                                        </table></td>
                                    </tr>
                                  </table>
                                  <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                                    <tr bgcolor="#a6caf4" class="txtbo">
                                      <td width="20%" align="left" nowrap="nowrap"><strong>Voter Email</strong><?php $objpaging->_sortImages("voter_email", $cmn->getCurrentPageName()); ?></td>
                                      <td width="20%" align="left"><strong>Voter State</strong><?php $objpaging->_sortImages("state_name", $cmn->getCurrentPageName()); ?></td>
                                      <td width="20%" align="left"><strong>Voter Zip Code</strong><?php $objpaging->_sortImages("voter_zipcode", $cmn->getCurrentPageName()); ?></td>
                                      <td width="16%" align="left"><strong>Voting Date</strong><?php $objpaging->_sortImages("voting_date", $cmn->getCurrentPageName()); ?></td>
                                      <td width="9%" align="left"><strong>Registration Source</strong><?php $objpaging->_sortImages("voter_reg_source", $cmn->getCurrentPageName()); ?></td>
									  <?php if ($aAccess[0]) { ?>
                                      <td width="7%" align="center" class="listtab-rt-bro-user"><strong>Action</strong></td>
									  <?php } ?>
                                    </tr>
                                    <?PHP
                                    if (count($arr) > 0) {
                                      for ($i = 0; $i < count($arr); $i++) {
                                        if ($i % 2 == 0)
                                          $strrow_class = "row01"; else
                                          $strrow_class = "row2";
                                        ?>
                                        <tr class="<?PHP echo $strrow_class; ?>">
                                          <td align="left" valign="top"><?PHP echo $arr[$i]['voter_email']; ?></td>
                                          <td align="left" valign="top"><?PHP echo $arr[$i]['state_name']; ?></td>
                                          <td align="left" valign="top"><?PHP echo $arr[$i]['voter_zipcode']; ?></td>
                                          <td align="left" valign="top"><?PHP $dt = explode(" ", $arr[$i]['voting_date']);
                                    echo $dt[0]; ?></td>
                                          <td align="left" valign="top"><?PHP echo $arr[$i]['voter_reg_source']; ?></td>                            
                                         <?php if ($aAccess[0]) { ?>
                                          <td width="15%" align="center" class="listtab-rt-bro-user"><a href="registrants_detail.php?rid=<?php print $objEncDec->encrypt(htmlspecialchars($arr[$i]["rpt_reg_id"])); ?>" class="gray_btn_view"><strong>View</strong></a></td>
										  <?php } ?>
                                        </tr>
                                      <?PHP }
                                    } else { ?>
                                      <tr>
                                        <td colspan="<?php echo $definedColSpan ?>" align="center" class="listtab-rt-bro-user">No record found.</td>
                                      </tr>
                                    <?PHP } ?>
                                  </table>						                          
                                  <div class="fclear"></div>
                                </div></td>
                            </tr>
                            <tr>
                              <td><div id="pager"><?php print $objpaging->drawPanel("panel1"); ?></div></td>
                            </tr>
                          </table></form>
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
<script type="text/javascript">
  jQuery.noConflict();
  jQuery(document).ready(function(){
    jQuery("#txtdatefrom").datepicker();
    jQuery("#txtdateto").datepicker();
  }); 
</script>
<?php include "include/footer.php"; ?>