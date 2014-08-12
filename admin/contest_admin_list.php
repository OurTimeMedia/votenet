<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objClientAdmin = new client();
		
	require_once 'contest_admin_db.php';
	
	$condition = " AND ".DB_PREFIX."user.user_type_id = '".$objClientAdmin->user_type_id."'";
	if(isset($_REQUEST['txtsearchname']))
	{
		if (trim($_REQUEST['txtsearchname'])!="")
			$condition .= " and (".DB_PREFIX."user.user_username like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						|| ".DB_PREFIX."user.user_designation like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						|| concat(".DB_PREFIX."user.user_firstname,' ',".DB_PREFIX."user.user_lastname) like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						|| ".DB_PREFIX."user.user_email like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' )";
	}
	$objpaging->strorderby = DB_PREFIX."user.user_id";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objClientAdmin,"client_admin_list.php",PAGESIZE,$condition);
	
	$extraJs = array("client_admin.js");

	$aAccess = $cmn->getAccess("client_admin_detail.php", "client_admin_detail", 11);	
	
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
                  <div class="fleft">Contest Admins</div>
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("contest_admin_addedit.php","contest_admin_addedit","Create","","add_new.png");?> </div>
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
                            <td colspan="<?php echo $aAccess[1] ?>" align="left"><table width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" /></td>
                                    <td width="74%" valign="middle"><input type="submit" onclick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript: search_record(this.form);" class="btn" title="Search" value="Search" name="btnsearch" id="btnsearch"/>&nbsp;&nbsp;<input type="button" title="Clear" onclick="javascript: window.location.href='client_admin_list.php';" class="btn" value="Clear" name="btnclear" id="btnclear"/></td>
                                      
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
                          <tr bgcolor="#a9cdf5" class="txtbo">
                            <td width="12%" align="left" nowrap="nowrap"><strong>Username</strong></a><?php $objpaging->_sortImages("user_username", $cmn->getCurrentPageName()); ?></td>
                            <td  width="26%" align="left"><strong>First Name</strong><?php $objpaging->_sortImages("user_firstname", $cmn->getCurrentPageName()); ?></td>
                            <td width="26%" align="left"><strong>Last Name</strong><?php $objpaging->_sortImages("user_lastname", $cmn->getCurrentPageName()); ?></td>
                            <td width="21%" align="left"><strong>Company</strong><?php $objpaging->_sortImages("user_designation", $cmn->getCurrentPageName()); ?></td>
                            <td width="22%" align="left"><strong>E-mail</strong><?php $objpaging->_sortImages("user_email", $cmn->getCurrentPageName()); ?></td>
                            <td width="17%" align="center"><strong>Active Contests</strong></td>
                            <td width="17%" align="center"><strong>Inactive Contests</strong></td>
                            <td width="17%" align="center"><strong>Completed Contests</strong></td>
                             <td width="10%" align="center"><strong>Allow Credit</strong><?php $objpaging->_sortImages("allow_credit", $cmn->getCurrentPageName()); ?></td>
                             <td width="10%" align="center"><strong>Active</strong><?php $objpaging->_sortImages("user_isactive", $cmn->getCurrentPageName()); ?></td>
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
							$aruser_id[] = $arr[$i]["user_id"] ?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                         
                            <td align="left">
                            
                            <?php 
							if ($aAccess[0])
							{
							?>
                            <a title="<?php print $cmn->readValueDetail($arr[$i]["user_username"]); ?>" href="client_admin_detail.php?user_id=<?php print $cmn->readValueDetail($arr[$i]["user_id"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["user_username"]); ?></a>
                            
                            <?php
							} 
							else 
							{
								print $cmn->readValueDetail($arr[$i]["user_username"]);
							}
							?>
                            
                            </td>
                            <td align="left"><?php print $cmn->readValueDetail($arr[$i]["user_firstname"]); ?></td>
                            <td align="left"><?php print $cmn->readValueDetail($arr[$i]["user_lastname"]); ?></td>
                            <td align="left">&nbsp;<?php print $cmn->readValueDetail($arr[$i]["user_company"]); ?></td>
                            <td align="left"><a title="<?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?>" href="mailto:<?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?></a></td>
                            <td align="center">&nbsp;<?php print $objClientAdmin->getContestCountByClientId($arr[$i]["user_id"],1); ?></td>
                            <td align="center">&nbsp;<?php print $objClientAdmin->getContestCountByClientId($arr[$i]["user_id"],0); ?></td>
                            <td align="center">&nbsp;<?php print $objClientAdmin->getContestCountByClientId($arr[$i]["user_id"],2); ?></td>
                             <td width="10%" align="center">
                             <?php ($cmn->readValueDetail($arr[$i]["allow_credit"])==1) ? print 'Yes' : print 'No' ?>
                             </td>
                             <td width="10%" align="center">
                             <?php ($cmn->readValueDetail($arr[$i]["user_isactive"])==1) ? print 'Yes' : print 'No' ?>
                             </td>
                            
                            <?php 
							if ($aAccess[0])
							{
							?>
                            <td align="center"><a title="View" href="client_admin_detail.php?user_id=<?php print $cmn->readValueDetail($arr[$i]["user_id"]); ?>" class="gray_btn_view">View</a></td>
                            <?php
							}
                            ?>
                            
                          </tr>
                          <?php 
						}
						 if(!empty($aruser_id)) 
						 	$inactiveids = implode(",",$aruser_id); 
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
