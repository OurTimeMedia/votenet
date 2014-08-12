<?php
	
	require_once 'include/general_includes.php';
	//$strmode = '';	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objSecurityBlockIP = new security_block_ip();

	require_once SERVER_ADMIN_ROOT.'security_block_ip_db.php';
	
	$condition = " AND ".DB_PREFIX."block_ipaddress.client_id='0'";
	
	$objpaging->strorderby = "ipaddress";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objSecurityBlockIP,"security_block_ip_list.php",PAGESIZE,$condition);
	
	$extraJs = array("security.js");
	
	$objUser = new user();
?>
<?php
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
                  <div class="fleft">Blocked IP Address</div>
                 
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("security_block_ip_addedit.php","security_block_ip_addedit","Add","","add_new.png");?> </div>
                   <div class="fright"> 
                   <?php 
                   		print $cmn->getAdminMenuLink("security_list.php","security_list","Back","","back.png",false); 
                   		
                   ?>
                  
                   </div>
                </div>
              </div>
            </div>
           
            <div class="blue_title_cont">
            <form id="frm" name="frm" method="post">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td width="100%"><div style="width:100%;">
                      
                        <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;">
                          
                          <tr bgcolor="#a9cdf5" class="txtbo">
                         
                            <td width="92%" align="left" nowrap="nowrap"><strong>IP Address</strong></a><?php $objpaging->_sortImages("ipaddress", $cmn->getCurrentPageName()); ?></td>
                            <td width="8%" align="left"><strong>Unblock</strong></td>
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{  $arblock_ipaddress_id[] = $arr[$i]["block_ipaddress_id"];
						 if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                            <td align="left"><?php print $cmn->getVal($arr[$i]["ipaddress"]); ?></td>
                            <td align="left">&nbsp;<input type="checkbox" name="unblockids[]" value="<?php print trim($arr[$i]['block_ipaddress_id']); ?>" /></td>
                          </tr>
                          <?php 
						} ?>
						<?PHP if(!empty($arblock_ipaddress_id)) 
						 	$inactiveids = implode(",",$arblock_ipaddress_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="5" align="center">No record found.</td>
                          </tr>
                          <?php } else { $inactiveids = implode(",",$arblock_ipaddress_id); ?>
                       	  <tr>
                        	<td>&nbsp;</td>
                        	<td align="center" valign="top"><input title="Unblock" type="button" name="btnunblock" class="btn" value="Unblock" onclick="javascript: setaction('unblock','security_block_ip_db.php');"/>
                      		</td>
                          </tr>
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