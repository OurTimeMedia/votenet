<?php 
require_once("include/common_includes.php");
require_once("include/general_includes.php");
require_once (COMMON_CLASS_DIR ."clselection_date.php");
require_once (COMMON_CLASS_DIR ."clspagingfront.php");
require_once (COMMON_CLASS_DIR ."clsstate.php");
$objpaging = new paging();
$cmn = new common();
set_time_limit(0);
$domain = $_REQUEST['domain'];
$objWebsite = new website();
$condition = " AND domain='".$domain."' ";
$client_id = $objWebsite->fieldValue("client_id","",$condition);
$condition = " AND  ed.election_date >= '".currentScriptDateOnly()."' ";
$objElectionDate = new election_date();

if(isset($_REQUEST["selState"]) && $_REQUEST["selState"] != "")
	$condition.= " AND s.state_id='".$_REQUEST["selState"]."' ";
	
$language_id = $cmn->getSession('voter_language_id');
	
$objpaging->strorderby = "ed.election_date";
$objpaging->strorder = "asc";
$objElectionDate->pagingType = "cReports";
$objElectionDate->language_id = $language_id;
$arr = $objpaging->setPageDetails($objElectionDate,"election_dates.php",PAGESIZE,$condition);

$objState = new state();
$objState->language_id = $language_id;
$arrState = $objState->fetchAllAsArrayFront();
?>
<style>
.listtab {
    border-left: 1px solid #73ABE7;
    font-size: 12px;
    width: 100%;
}

.txtbo {
    font-weight: bold;
    vertical-align: top;
}

.listtab td {
    border-bottom: 1px solid #73ABE7;
    border-right: 1px solid #73ABE7;
    padding: 5px;
}

#pager {
    background: none repeat scroll 0 0 #A9CDF5;
    border: 1px solid #A9CDF5;
    height: 30px;
    padding: 5px 0 5px 5px;
	font-size: 12px;
}

#pager td{
    font-size: 12px;
}
</style>
<form id="frm" method="post" name="frm">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
		<td align="left" width="100%" style="font-size:12px;" colspan="2"><b>{$LANG_SELECT_STATE_TEXT}:</b> <select name="selState" id="selState" class="from-input" onchange="this.form.submit();" style="float:none;">
								<option value="">{$LANG_SELECT_A_STATE_TEXT}</option>
							<?php for ($i=0;$i<count($arrState);$i++){ ?>
							  <option value="<?php echo $arrState[$i]['state_id'];?>" <?php if(isset($_REQUEST['selState']) && $arrState[$i]['state_id'] == $_REQUEST['selState']) { echo "selected";} ?>><?php echo $arrState[$i]['state_name'];?></option>
							<?php } ?>							
							</select></td>
	</tr>
	<tr>
	<td colspan="2">
	
<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;">
  <tr bgcolor="#a9cdf5" class="txtbo">
	<td width="20%" align="left" nowrap="nowrap"><strong>{$LANG_ELECTION_TYPE_TEXT}</strong>
		<?php $objpaging->_sortImages("election_type_name", $cmn->getCurrentPageName()); ?></td>
	<td width="20%" align="left" nowrap="nowrap"><strong>{$LANG_STATE_TEXT}</strong>
		<?php $objpaging->_sortImages("state_code", $cmn->getCurrentPageName()); ?></td>
	<td  width="25%" align="left"><strong>{$LANG_ELECTION_DATES_TEXT}</strong>
		<?php $objpaging->_sortImages("election_date", $cmn->getCurrentPageName()); ?></td>
	<td width="25%" align="left"><strong>{$LANG_REGISTRATION_DEADLINE_DATE_TEXT}</strong>
		<?php $objpaging->_sortImages("reg_deadline_date", $cmn->getCurrentPageName()); ?></td>	
  </tr>
  <?php 
	for ($i=0;$i<count($arr);$i++)
	{ 
		$arelection_date_id[] = $arr[$i]["election_date_id"] ?>
  <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
  <tr class="<?php echo $strrow_class?>">
	<td align="left"><?php print $cmn->readValueDetail($arr[$i]["election_type_name"]); ?>&nbsp;</td>
	<td align="left"><?php print $cmn->readValueDetail($arr[$i]["state_name"]); ?>&nbsp;</td>
	<td align="left"><?php echo $cmn->convertFormtDate($arr[$i]["election_date"],"m-d-Y");?>&nbsp;</td>
	<td align="left"><?php echo $cmn->convertFormtDate($arr[$i]["reg_deadline_date"],"m-d-Y");?>&nbsp;</td>	
  </tr>
  <?php 
	} 
	 if (count($arr)==0){ ?>
  <tr>
	<td colspan="4" align="center">No record found.</td>
  </tr>
  <?php } ?>
</table>

<tr>
                  <td colspan="2"><div id="pager"><?php print $objpaging->drawPanel("panel1"); ?></div></td>
                </tr>
</td>
</tr>	
</table></form>