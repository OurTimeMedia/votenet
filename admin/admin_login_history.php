<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objAdminLoginHistory = new adminhistory();
		
	require_once 'admin_login_history_db.php';
	
	$condition = "";
	
	if(isset($_REQUEST['txtsearchname']))
	{
		if (trim($_REQUEST['txtsearchname'])!="")
			$condition .= " and (
			u.user_username like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						|| 
				concat(c.user_firstname,' ',c.user_lastname) like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
			|| ip_address  like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'
			) ";
	}
	
	$objpaging->strorderby = "login_date";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objAdminLoginHistory,"admin_login_history.php",PAGESIZE,$condition);
	
	$extraJs = array("admin_login_history.js");
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
                  <div class="fleft">System Admin Login History</div>
                  <div class="fright"> &nbsp; </div>
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
                            <td colspan="5" align="left"><table width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" /></td>
                                    <td width="74%" valign="middle"><input type="submit" onclick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript: search_record(this.form);" class="btn" value="Search" name="btnsearch" id="btnsearch" title="Search"/>&nbsp;&nbsp;<input type="button" title="Clear" onclick="javascript: window.location.href='admin_login_history.php';" class="btn" value="Clear" name="btnclear" id="btnclear"/></td>
                                      
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
                          <tr bgcolor="#a9cdf5" class="txtbo">
                            <td><input type="checkbox" name="main" id="main" onclick="checkall(this.form)" /></td>
                            <td width="12%" align="left" nowrap="nowrap"><strong>System Admin User name</strong></a><?php $objpaging->_sortImages("u.user_username", $cmn->getCurrentPageName()); ?></td>
                            <td  width="26%" align="left"><strong>Client Name</strong><?php $objpaging->_sortImages("c.user_firstname, c.user_lastname", $cmn->getCurrentPageName()); ?></td>
                            <td width="26%" align="left"><strong>Login Date Time</strong><?php $objpaging->_sortImages("login_date", $cmn->getCurrentPageName()); ?></td>
                            <td width="21%" align="left"><strong>IP Address</strong><?php $objpaging->_sortImages("ip_address", $cmn->getCurrentPageName()); ?></td>
                           
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$aruser_id[] = $arr[$i]["user_id"] ?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                            <td align="left" valign="top" ><input type="checkbox" onclick="checkOne(this.form)" name="deletedids[]" value="<?php print $cmn->getVal($arr[$i]["admin_login_history_id"]); ?>" />
                            </td>
                            <td align="left"><?php print $cmn->readValueDetail($arr[$i]["user_username"]); ?></td>
                            <td align="left"><?php print $cmn->readValueDetail($arr[$i]["user_firstname"])." " .$cmn->getVal($arr[$i]["user_lastname"]); ?></td>
                            <td align="left"><?php $dt = explode(" ",$arr[$i]["login_date"]); print $cmn->dateTimeFormat($cmn->readValueDetail($dt[0]),'%m/%d/%Y')." ".$dt[1]; ?></td>
                            <td align="left">&nbsp;<?php print $cmn->readValueDetail($arr[$i]["ip_address"]); ?></td>
                            
                          </tr>
                          <?php 
						}
						 if(!empty($aruser_id)) 
						 	$inactiveids = implode(",",$aruser_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="5" align="center">No record found.</td>
                          </tr>
                          <?php } else { ?>
                          <tr >
                            <td align="left" valign="top" ><input type="button" name="btndelete" class="btn" value="Delete" title="Delete" onclick="javascript: setaction('delete','contest_admin_db.php');"/>
                              <input type="hidden" name="inactiveids" value="<?php print $inactiveids; ?>" />
                              <input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $strmode; ?>"/>
                            </td>
                            <td align="left" valign="top" colspan="4">&nbsp;</td>
                          </tr>
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
