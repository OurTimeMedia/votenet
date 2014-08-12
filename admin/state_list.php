<?php
require_once 'include/general_includes.php';
	
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$objstate = new state();
require_once 'state_db.php';
$condition = "";

if(isset($_REQUEST['txtsearchname']))
{
	if (trim($_REQUEST['txtsearchname'])!="")
		$condition .= " AND ( state_code like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 	
							|| state_name like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| state_secretary_fname  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| state_secretary_mname  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| state_secretary_lname  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| state_address1  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| state_address2  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| state_city  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| zipcode like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| hotlineno  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| email like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%')";
							
}
	
$objpaging->strorderby = DB_PREFIX."state.state_code";
$objpaging->strorder = "ASC";
$arr = $objpaging->setPageDetails($objstate,"state_list.php",PAGESIZE,$condition);
$extraJs = array("state_list.js");
$aAccess = $cmn->getAccess("state_list.php", "state_list", 11);	

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
                  <div class="fleft">States</div>
                  <div class="fright"> 
				  	<?php //print $cmn->getAdminMenuLink("state_addedit.php","state_addedit","Create","","add_new.png");?> 
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
					  <td <?php if ($aAccess[0]) { ?> colspan="8"<?php } else { ?> colspan="7"<?php } ?> class="row2">	
						<table width="100%" cellspacing="0" cellpadding="0">                                
						 <tr>                                   
						  <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>"/></td>
                                    <td width="40%" valign="middle"><input type="button" class="btn" value="Search" name="btnsearch" id="btnsearch" onClick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript:document.frm.submit();"/>&nbsp;&nbsp;<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript: window.location.href='state_list.php';"/></td>
                                    <td width="37%" valign="middle" align="right">&nbsp;</a></td>
						</tr>
						</table>
					  </td>
					</tr>	
                      <tr bgcolor="#a9cdf5" class="txtbo">
                        <td width="5%" align="left" nowrap="nowrap"><strong>State Code</strong>
                            <?php $objpaging->_sortImages("state_code", $cmn->getCurrentPageName()); ?></td>
                        <td  width="6%" align="left"><strong>State Name</strong>
                            <?php $objpaging->_sortImages("state_name", $cmn->getCurrentPageName()); ?></td>
                        <td width="11%" align="left"><strong>Secretary Name</strong>
                            <?php $objpaging->_sortImages("state_secretary_fname", $cmn->getCurrentPageName()); ?></td>
                        <td width="23%" align="left"><strong>Secretary Address</strong></td>
                        <td width="10%" align="left"><strong>Hotline</strong></td>
                        <td width="12%" align="left"><strong>E-mail</strong>
                            <?php $objpaging->_sortImages("email", $cmn->getCurrentPageName()); ?></td>
                        <td width="4%" align="center"><strong>Active</strong>
                            <?php $objpaging->_sortImages("state_active", $cmn->getCurrentPageName()); ?></td>
                        <?php  
							if ($aAccess[0])
							{
							?>
                        <td width="7%" align="center">Action</td>
                        <?php
							}
							?>
                      </tr>
                      <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$arstate_id[] = $arr[$i]["state_id"] ?>
                      <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                      <tr class="<?php echo $strrow_class?>">
                        <td align="left"  valign="top"><?php 
							if ($aAccess[0])
							{
							?>
                            <a title="<?php print $cmn->readValueDetail($arr[$i]["state_code"]); ?>" href="state_detail.php?state_id=<?php print $cmn->readValueDetail($arr[$i]["state_id"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["state_code"]); ?></a>
                            <?php
							} 
							else 
							{
								print $cmn->readValueDetail($arr[$i]["state_name"]);
							}
							?>                        &nbsp;</td>
                        <td align="left" valign="top"><?php print $cmn->readValueDetail($arr[$i]["state_name"]); ?>&nbsp;</td>
                        <td align="left" valign="top"><?php print $cmn->readValueDetail($arr[$i]["state_secretary_fname"])." ".$cmn->readValueDetail($arr[$i]["state_secretary_lname"]); ?>&nbsp;</td>
                        <td align="left" valign="top"><?php print $cmn->readValueDetail($arr[$i]["state_address1"])."<br>".$cmn->readValueDetail($arr[$i]["state_address2"])." ".$cmn->readValueDetail($arr[$i]["state_city"])."<br>".$cmn->readValueDetail($arr[$i]["zipcode"]); ?>&nbsp;</td>
                        <td align="left" valign="top"><?php print $cmn->readValueDetail($arr[$i]["hotlineno"]); ?>&nbsp;</td>
                        <td align="left" valign="top"><a title="<?php print $cmn->readValueDetail($arr[$i]["email"]); ?>" href="mailto:<?php print $cmn->readValueDetail($arr[$i]["email"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["email"]); ?></a>&nbsp;</td>
                        <td width="4%" align="center"><?php ($cmn->readValueDetail($arr[$i]["state_active"])==1) ? print 'Yes' : print 'No' ?>                     &nbsp;   </td>
                        <?php 
							if ($aAccess[0])
							{
							?>
                        <td align="center" valign="top"><a title="View" href="state_detail.php?state_id=<?php print $cmn->readValueDetail($arr[$i]["state_id"]); ?>" class="gray_btn_view">View</a></td>
                        <?php
							}
                            ?>
                      </tr>
                      <?php 
						}
						 if(!empty($arstate_id)) 
						 	$inactiveids = implode(",",$arstate_id); 
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