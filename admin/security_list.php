<?php
	require_once 'include/general_includes.php';
	$strmode = '';	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objSecurity = new security();

	$condition = "";
	$objpaging->strorderby = "login_date";
	$objpaging->strorder = "desc";

	if(isset($_REQUEST['txtsearchname']) && $_REQUEST['txtsearchname']!="")
	{	
		if (trim($_REQUEST['txtsearchname'])!="")
			$condition .= " and (ulh.loginuser_name like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
				|| ulh.login_date like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
				|| ulh.login_result like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'
				|| ulh.ip_address like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
				|| ulh.login_date like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%')";
		$arr = $objpaging->setPageDetailsNew($objSecurity,"security_list.php",PAGESIZE,$condition);
	}
	else
	{
		$arr = $objpaging->setPageDetails($objSecurity,"security_list.php",PAGESIZE,$condition);
	}
	
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
                  <div class="fleft">Monitor User Access</div>
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("security_block_user.php","security_block_user","Block User","","add_new.png");?> </div>
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("security_block_ip_list.php","security_block_ip_list","Block IP Address","","add_new.png");?> </div>
                  
                </div>
              </div>
            </div>
           
            <div class="blue_title_cont">
            <form id="frm" name="frm" method="post">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td width="100%"><div style="width:100%;">
                      
                        <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;">
                          <tr>
                            <td colspan="7" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" /></td>
                                    <td width="74%" valign="middle"><input type="submit" onclick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript: search_record(this.form);" class="btn" value="Search" name="btnsearch" id="btnsearch"/>&nbsp;&nbsp;<input type="button" title="Search" onclick="javascript: window.location.href='security_list.php';" class="btn" value="Clear" name="btnclear" id="btnclear"/></td>
                                      
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
                          <tr bgcolor="#a9cdf5" class="txtbo">
                         
                            <td width="14%" align="left" nowrap="nowrap"><strong>Login name</strong></a><?php $objpaging->_sortImages("loginuser_name", $cmn->getCurrentPageName()); ?></td>
                            <td  width="16%" align="left"><strong>Login From<?php $objpaging->_sortImages("login_page", $cmn->getCurrentPageName()); ?></strong></td>
                            <td  width="17%" align="left"><strong>User Type<?php $objpaging->_sortImages("user_type_name", $cmn->getCurrentPageName()); ?></strong></td>
                            <td width="18%" align="left"><strong>Date</strong><?php $objpaging->_sortImages("login_date", $cmn->getCurrentPageName()); ?></td>
                            <td width="17%" align="left"><strong>IP Address</strong><?php $objpaging->_sortImages("ip_address", $cmn->getCurrentPageName()); ?></td>
                           <td width="16%" align="left"><strong>Login Result</strong><?php $objpaging->_sortImages("login_result", $cmn->getCurrentPageName()); ?></td>
                          </tr>
                          <?php 
							for ($i=0;$i<count($arr);$i++)
							{ 
							  $usertype = $objUser->fetchAllAsArray($arr[$i]["user_id"]);
							  $aruser_login_history_id[] = $arr[$i]["user_login_history_id"] ?>
							  <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                              <tr class="<?php echo $strrow_class?>">
                                <td align="left"><?php print htmlspecialchars($arr[$i]["loginuser_name"]); ?></td>
                                <td align="left"><?php if($cmn->getVal($arr[$i]["login_page"])==1) print "System Admin Panel"; else if($cmn->getVal($arr[$i]["login_page"])==2) print "Contest Admin Panel"; else if($cmn->getVal($arr[$i]["login_page"])==3) print "Entrant Area"; else if($cmn->getVal($arr[$i]["login_page"])==4) print "Judge Area"; ?></td>
                            <?PHP if(!empty($usertype)) { ?>
                                    <td align="left"><?php print $cmn->getVal($objUser->getUserTypeDtl($usertype[0]["user_type_id"]));?></td>
                            <?PHP } else { ?>
                                    <td align="left">&nbsp;</td>
                                <?PHP } ?>
                                <td align="left"><?php $dt = explode(" ",$cmn->getVal($arr[$i]["login_date"])); print $cmn->dateTimeFormat(htmlspecialchars($dt[0]),'%m/%d/%Y')." ".$dt[1]; ?></td>
                                <td align="left"><?php print $cmn->getVal($arr[$i]["ip_address"]); ?></td>
                                <td width="2%" align="left"><?php print htmlspecialchars($arr[$i]["login_result"]); ?></td>
                          </tr>
                              <?php 
                            }
							if(!empty($aruser_login_history_id)) 
								$inactiveids = implode(",",$aruser_login_history_id); 
							if (count($arr)==0){ ?>
                              <tr>
                                <td colspan="5" align="center">No record found.</td>
                              </tr>
                            <?php } else { ?>
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