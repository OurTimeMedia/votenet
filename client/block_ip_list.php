<?php
	
	require_once 'include/general_includes.php';
	//$strmode = '';	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	$objpaging = new paging();
	
	$objSecurityBlockIP = new security_block_ip();

	require_once SERVER_CLIENT_ROOT.'block_ip_db.php';
	
	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objClient = new client();
	$client_id = $objClient->fieldValue("client_id",$userID);

	$condition = " AND ".DB_PREFIX."block_ipaddress.client_id='".$client_id."'";
	$objpaging->strorderby = "ipaddress";
	$objpaging->strorder = "desc";
	
	if(isset($_REQUEST['txtsearchname']))
	{
		if (trim($_REQUEST['txtsearchname'])!="")
			$condition .= " and (".DB_PREFIX."block_ipaddress.ipaddress like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						|| ".DB_PREFIX."block_ipaddress.reason like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						|| ".DB_PREFIX."user.user_username like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'
						|| DATE_FORMAT(CAST(".DB_PREFIX."block_ipaddress.created_date AS DATE),'%m/%d/%Y') like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' )";
	}
	$arr = $objpaging->setPageDetailsNew($objSecurityBlockIP,"block_ip_list.php",PAGESIZE,$condition);
	
	$extraJs = array("security.js");
	
	$aAccess = $cmn->getAccessClient("block_ip_detail.php", "block_ip_detail" , 4);		
	
	$objUser = new user();
?>
<?php
	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top.php";
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
                  <div class="fleft">Block IP Addresses</div>
                 
                  <div class="fright"> <?php print $cmn->getMenuLink("block_ip_addedit.php","block_ip_addedit","Create","","add_new.png");?> </div>
                  
                </div>
              </div>
            </div>
           
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
            <form id="frm" name="frm" method="post" >
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td width="100%"><div class="white">
                            <table cellpadding="5" cellspacing="0" border="0" class="border-none" width="100%" style="clear:both;" >
							<tr class="row02">
                              <td width="100%" align="left"><table width="100%" class="listtab-rt-bro" cellspacing="0" cellpadding="5">
                                <tbody>
                                  <tr>
                                    <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" /></td>
                                    <td width="74%" valign="middle"><input type="submit" onClick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript: search_record(this.form);" class="btn" value="Search" title="Search" alt="Search" name="btnsearch" id="btnsearch"/>
                                      &nbsp;&nbsp;
                                      <input type="button" class="btn" title="Clear" alt="Clear" value="Clear" name="btnclear" id="btnclear" onclick="javascript: window.location.href='block_ip_list.php';"/></td>
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
						  <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                            <tr bgcolor="#a6caf4" class="txtbo">                         
                            <td width="25%" align="left" nowrap="nowrap"><strong>IP Address</strong></a><?php $objpaging->_sortImages("ipaddress", $cmn->getCurrentPageName()); ?></td>
                            <td width="25%" align="left" nowrap="nowrap"><strong>Blocked By</strong></a><?php $objpaging->_sortImages("user_username", $cmn->getCurrentPageName()); ?></td>
                            <td width="25%" align="left" nowrap="nowrap"><strong>Blocked Date</strong></a><?php $objpaging->_sortImages("created_date", $cmn->getCurrentPageName()); ?></td>
                            <?php 
							if ($aAccess[0])
							{
							?>
                            <td width="25%" align="center" class="listtab-rt-bro-user"><strong>Action</strong></td>
                            
                            <?php
                            
							}
							?>
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{  $arblock_ipaddress_id[] = $arr[$i]["block_ipaddress_id"];
						 if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                            <td align="left"><?php 
							if ($aAccess[0])
							{
							?>
                            <a title="<?php print $cmn->readValueDetail($arr[$i]["ipaddress"]); ?>" href="block_ip_detail.php?block_ipaddress_id=<?php print $objEncDec->encrypt($cmn->readValueDetail($arr[$i]["block_ipaddress_id"])); ?>"><?php print $cmn->readValueDetail($arr[$i]["ipaddress"]); ?></a>
                            
                            <?php
							} 
							else 
							{
								print $cmn->getVal($arr[$i]["ipaddress"]);
							}
							?></td>
                            <td align="left"><?php print $cmn->getVal($arr[$i]["user_username"]); ?></td>
                            <td align="left"><?php $dt = explode(" ",$arr[$i]["created_date"]); print $cmn->dateTimeFormat(htmlspecialchars($dt[0]),'%m/%d/%Y'); ?></td>
                            <?php 
							if ($aAccess[0])
							{
							?>
                            <td align="center" class="listtab-rt-bro-user"><a title="View" href="block_ip_detail.php?block_ipaddress_id=<?php print $objEncDec->encrypt($cmn->readValueDetail($arr[$i]["block_ipaddress_id"])); ?>" class="gray_btn_view">View</a></td>
                            <?php
							}
                            ?>
                          </tr>
                          <?php 
						} ?>
						<?PHP if(!empty($arblock_ipaddress_id)) 
						 	$inactiveids = implode(",",$arblock_ipaddress_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="<?php echo $aAccess[1] ?>" align="center" class="listtab-rt-bro-user">No record found.</td>
                          </tr>
                          <?php } else { $inactiveids = implode(",",$arblock_ipaddress_id); ?>
                       	  
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
              </table></td>
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
        </div>
      </div>
    </div>
  </div>
</div>
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>
</body>
</html>