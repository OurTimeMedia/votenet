<?php
require_once 'include/general_includes.php';
	
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$objPollBooth = new poll_booth();
require_once 'poll_booth_address_db.php';
$condition = "";

if(isset($_REQUEST['txtsearchname']))
{
	if (trim($_REQUEST['txtsearchname'])!="")
		$condition .= " AND ( s.state_code like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 	
							|| s.state_name  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| pba.poll_booth_country  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| pba.official_title  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| pba.building_name   like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| pba.poll_booth_address1   like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| pba.poll_booth_address2   like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| pba.poll_booth_city   like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
							|| pba.poll_booth_zipcode   like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%')";
							
}

$objpaging->strorderby = "s.state_code";
$objpaging->strorder = "asc";
$arr = $objpaging->setPageDetails($objPollBooth,"poll_booth_address_list.php",PAGESIZE,$condition);
$extraJs = array("poll_booth_address.js");
$aAccess = $cmn->getAccess("poll_booth_address_list.php", "poll_booth_address_list", 11);	

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
                  <div class="fleft">State Voter Registration Office Locations</div>
                  <div class="fright"> 
				  	<?php print $cmn->getAdminMenuLink("poll_booth_address_addedit.php","poll_booth_address_addedit","Create","","add_new.png");?> 
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
                                    <td width="40%" valign="middle"><input type="button" class="btn" value="Search" name="btnsearch" id="btnsearch" onClick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript:document.frm.submit();"/>&nbsp;&nbsp;<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript: window.location.href='poll_booth_address_list.php';"/></td>
                                    <td width="37%" valign="middle" align="right">&nbsp;</a></td>
						</tr>
						</table>
					  </td>
					</tr>
                      <tr bgcolor="#a9cdf5" class="txtbo">
                        <td width="15%" align="left" nowrap="nowrap"><strong>State Code</strong>
                            <?php $objpaging->_sortImages("state_code", $cmn->getCurrentPageName()); ?></td>
						<td width="15%" align="left" nowrap="nowrap"><strong>State Name</strong>
                            <?php $objpaging->_sortImages("state_name", $cmn->getCurrentPageName()); ?></td>	
						<td width="22%" align="left" nowrap="nowrap"><strong>Official Title</strong>
                            <?php $objpaging->_sortImages("official_title", $cmn->getCurrentPageName()); ?></td>
						<td width="30%" align="left" nowrap="nowrap"><strong>Address</strong></td>
						<td width="10%" align="center"><strong>Active</strong>
                            <?php $objpaging->_sortImages("poll_booth_active", $cmn->getCurrentPageName()); ?></td>	
                        <?php  
							if ($aAccess[0])
							{
							?>
                        <td width="8%" align="center">Action</td>
                        <?php
							}
							?>
                      </tr>
                      <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$arpoll_booth_id[] = $arr[$i]["poll_booth_id"] ?>
                      <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                      <tr class="<?php echo $strrow_class?>">
                        <td align="left" valign="top"><?php echo $cmn->readValueDetail($arr[$i]["state_code"]);?>&nbsp;</td>  
                        <td align="left" valign="top"><?php echo $cmn->readValueDetail($arr[$i]["state_name"]);?>&nbsp;</td>  
                        <td align="left" valign="top"><?php echo $cmn->readValueDetail($arr[$i]["official_title"]);?>&nbsp;</td>                          
                        <td align="left" valign="top">
						<?php 
						if(isset($arr[$i]["building_name"]) && $arr[$i]["building_name"] != "")
							echo $cmn->readValueDetail($arr[$i]["building_name"]).'<br />';
						?>
						<?php 
						if(isset($arr[$i]["poll_booth_address1"]) && $arr[$i]["poll_booth_address1"] != "")
							echo $cmn->readValueDetail($arr[$i]["poll_booth_address1"]).'<br />';
						?>
						<?php 
						if(isset($arr[$i]["poll_booth_address2"]) && $arr[$i]["poll_booth_address2"] != "")
							echo $cmn->readValueDetail($arr[$i]["poll_booth_address2"]).'<br />';
						?>
						<?php 
						if(isset($arr[$i]["poll_booth_city"]) && $arr[$i]["poll_booth_city"] != "")
						{
							echo $cmn->readValueDetail($arr[$i]["poll_booth_city"]);
							
							if(isset($arr[$i]["poll_booth_zipcode"]) && $arr[$i]["poll_booth_zipcode"] != "")
							{
								echo " - ".$cmn->readValueDetail($arr[$i]["poll_booth_zipcode"]);
							}
						}
						else 
						{
							if(isset($arr[$i]["poll_booth_zipcode"]) && $arr[$i]["poll_booth_zipcode"] != "")
							{
								echo $cmn->readValueDetail($arr[$i]["poll_booth_zipcode"]);
							}
						}							
						?></td>                          
                        <td align="center" valign="top"><?php ($cmn->readValueDetail($arr[$i]["poll_booth_active"])==1) ? print 'Yes' : print 'No' ?>                     &nbsp;</td>
						<?php 
							if ($aAccess[0])
							{
							?>
                        <td align="center" valign="top"><a title="View" href="poll_booth_address_detail.php?poll_booth_id=<?php print $cmn->readValueDetail($arr[$i]["poll_booth_id"]); ?>" class="gray_btn_view">View</a></td>
                        <?php
							}
                            ?>
                      </tr>
                      <?php 
						}
						 if(!empty($arpoll_booth_id)) 
						 	$inactiveids = implode(",",$arpoll_booth_id); 
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