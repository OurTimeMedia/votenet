<?php
require_once 'include/general_includes.php';
	
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$objparty = new party();
require_once 'party_db.php';
$condition = "";

if(isset($_REQUEST['txtsearchname']))
{
	if (trim($_REQUEST['txtsearchname'])!="")
		$condition .= " AND ( party_name like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%')";
							
}

$objpaging->strorderby = DB_PREFIX."party.party_name";
$objpaging->strorder = "asc";
$arr = $objpaging->setPageDetails($objparty,"party_list.php",PAGESIZE,$condition);
$extraJs = array("party_list.js");
$aAccess = $cmn->getAccess("party_list.php", "party_list", 5);	

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
                  <div class="fleft">Parties</div>
                  <div class="fright"> 
				  	<?php print $cmn->getAdminMenuLink("party_addedit.php","party_addedit","Create","","add_new.png");?> 
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
					  <td <?php if ($aAccess[0]) { ?> colspan="3"<?php } else { ?> colspan="2"<?php } ?> class="row2">	
						<table width="100%" cellspacing="0" cellpadding="0">                                
						 <tr>                                   
						  <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>"/></td>
                                    <td width="40%" valign="middle"><input type="button" class="btn" value="Search" name="btnsearch" id="btnsearch" onClick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript:document.frm.submit();"/>&nbsp;&nbsp;<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript: window.location.href='party_list.php';"/></td>
                                    <td width="37%" valign="middle" align="right">&nbsp;</a></td>
						</tr>
						</table>
					  </td>
					</tr>
                      <tr bgcolor="#a9cdf5" class="txtbo">
                        <td  width="60%" align="left"><strong>Party Name</strong>
                            <?php $objpaging->_sortImages("party_name", $cmn->getCurrentPageName()); ?></td>
                        <td width="20%" align="center"><strong>Active</strong>
                            <?php $objpaging->_sortImages("party_active", $cmn->getCurrentPageName()); ?></td>
                        <?php  
							if ($aAccess[0])
							{
							?>
                        <td width="20%" align="center">Action</td>
                        <?php
							}
							?>
                      </tr>
                      <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$arparty_id[] = $arr[$i]["party_id"] ?>
                      <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                      <tr class="<?php echo $strrow_class?>">
                        <td align="left"><?php 
							if ($aAccess[0])
							{
							?>
                            <a title="<?php print $cmn->readValueDetail($arr[$i]["party_name"]); ?>" href="party_detail.php?party_id=<?php print $cmn->readValueDetail($arr[$i]["party_id"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["party_name"]); ?></a>
                            <?php
							} 
							else 
							{
								print $cmn->readValueDetail($arr[$i]["party_name"]);
							}
							?>                        &nbsp;</td>
                        <td width="4%" align="center"><?php ($cmn->readValueDetail($arr[$i]["party_active"])==1) ? print 'Yes' : print 'No' ?>                     &nbsp;   </td>
                        <?php 
							if ($aAccess[0])
							{
							?>
                        <td align="center"><a title="View" href="party_detail.php?party_id=<?php print $cmn->readValueDetail($arr[$i]["party_id"]); ?>" class="gray_btn_view">View</a></td>
                        <?php
							}
                            ?>
                      </tr>
                      <?php 
						}
						 if(!empty($arparty_id)) 
						 	$inactiveids = implode(",",$arparty_id); 
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