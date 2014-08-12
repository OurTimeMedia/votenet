<?php
//include base file
require_once 'include/general_includes.php';
	
//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

//create class object
$objpaging = new paging();
$objElectionDate = new election_date();

// include file for DB related operations
require_once 'election_date_db.php';
$condition = "";

//fetch election date data
if(isset($_REQUEST['txtsearchname']))
{
	if (trim($_REQUEST['txtsearchname'])!="")
		$condition .= " AND ( ed.election_description like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 	
							|| ed.reg_deadline_description like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| s.state_code  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| s.state_name  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| et.election_type_name  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%')";
							
}
if(isset($_REQUEST['txtedate']))
{
	if (trim($_REQUEST['txtedate'])!="")
		$condition .= " AND ( ed.election_date = date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtedate'])."', '%m/%d/%Y' ) , '%Y-%m-%d' )  	
							|| ed.reg_deadline_date = date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtedate'])."', '%m/%d/%Y' ) , '%Y-%m-%d' ))";
							
}

$objpaging->strorderby = "ed.election_date_id";
$objpaging->strorder = "desc";
$arr = $objpaging->setPageDetails($objElectionDate,"election_date_list.php",PAGESIZE,$condition);
//END

//include css file
$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css");

//include js file
$extraJs = array("election_date_list.js");

//get access details	
$aAccess = $cmn->getAccess("election_date_list.php", "election_date_list", 5);	

include SERVER_ADMIN_ROOT."include/header.php";
include SERVER_ADMIN_ROOT."include/top.php";
?>
<script type="text/javascript">
$(function() 
{
	$("#txtedate").datepicker();
}); 
</script>
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
									<div class="fleft">Election Dates</div>
									<div class="fright"> 
										<?php print $cmn->getAdminMenuLink("election_date_addedit.php","state_addedit","Create","","add_new.png");?> 
									</div>
								</div>
							</div>
						</div>
						<div class="blue_title_cont">
							<form id="frm" name="frm" method="post">
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td>
										<div>
                    <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;">
					<tr>
					  <td <?php if ($aAccess[0]) { ?> colspan="5"<?php } else { ?> colspan="4"<?php } ?> class="row2">	
						<table width="100%" cellspacing="0" cellpadding="0">                                
						 <tr>                                   
						  <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="15%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>"/></td>
						<td width="5%" valign="middle" align="left"><strong>Date:</strong></td>
                                    <td width="20%" valign="middle"><input  class="input_text_date" type="text" name="txtedate" id="txtedate" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtedate'],""));?>" maxlength="50" readonly="readonly"/>&nbsp;<img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtedate').focus();" alt="Calender" title="Calender"></td>			
                                    <td width="40%" valign="middle"><input type="button" class="btn" value="Search" name="btnsearch" id="btnsearch" onClick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript:document.frm.submit();"/>&nbsp;&nbsp;<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript: window.location.href='election_date_list.php';"/></td>
                                    <td width="15%" valign="middle" align="right">&nbsp;</a></td>
						</tr>
						</table>
					  </td>
					</tr>
                      <tr bgcolor="#a9cdf5" class="txtbo">
						<td width="20%" align="left" nowrap="nowrap"><strong>Election Type</strong>
							<?php $objpaging->_sortImages("election_type_name", $cmn->getCurrentPageName()); ?></td>
                        <td width="20%" align="left" nowrap="nowrap"><strong>State</strong>
                            <?php $objpaging->_sortImages("state_code", $cmn->getCurrentPageName()); ?></td>
                        <td  width="25%" align="left"><strong>Election Date</strong>
                            <?php $objpaging->_sortImages("election_date", $cmn->getCurrentPageName()); ?></td>
                        <td width="25%" align="left"><strong>Registration Deadline Date</strong>
                            <?php $objpaging->_sortImages("reg_deadline_date", $cmn->getCurrentPageName()); ?></td>
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
							$arelection_date_id[] = $arr[$i]["election_date_id"] ?>
                      <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                      <tr class="<?php echo $strrow_class?>">
                        <td align="left"><?php 
							if ($aAccess[0])
							{
							?>
                            <a title="<?php print $cmn->readValueDetail($arr[$i]["election_type_name"]); ?>" href="election_date_detail.php?election_date_id=<?php print $cmn->readValueDetail($arr[$i]["election_date_id"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["election_type_name"]); ?></a>
                            <?php
							} 
							else 
							{
								print $cmn->readValueDetail($arr[$i]["election_type_name"]);
							}
							?>                        &nbsp;</td>
                        <td align="left"><?php print $cmn->readValueDetail($arr[$i]["state_code"]); ?> - <?php print $cmn->readValueDetail($arr[$i]["state_name"]); ?>&nbsp;</td>
                        <td align="left"><?php print $cmn->readValueDetail($arr[$i]["election_date"]); ?>&nbsp;</td>
                        <td align="left"><?php print $cmn->readValueDetail($arr[$i]["reg_deadline_date"]); ?>&nbsp;</td>
                        <?php 
							if ($aAccess[0])
							{
							?>
                        <td align="center"><a title="View" href="election_date_detail.php?election_date_id=<?php print $cmn->readValueDetail($arr[$i]["election_date_id"]); ?>" class="gray_btn_view">View</a></td>
                        <?php
							}
                            ?>
                      </tr>
                      <?php 
						}
						 if(!empty($arelection_date_id)) 
						 	$inactiveids = implode(",",$arelection_date_id); 
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