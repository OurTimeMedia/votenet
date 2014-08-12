<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	$objpaging = new paging();
	
	$objClientAdmin = new client();
	$user_id = $cmn->getSession(ADMIN_USER_ID);
	$client_id = $objClientAdmin->fieldValue("client_id",$user_id);
	require_once 'client_admin_db.php';
	
	$condition = " AND ".DB_PREFIX."user.user_type_id = '".USER_TYPE_CLIENT_ADMIN."' AND ".DB_PREFIX."user.client_id='".$client_id."'";
	if(isset($_REQUEST['txtsearchname']))
	{
		if (trim($_REQUEST['txtsearchname'])!="")
			$condition .= " and (".DB_PREFIX."user.user_username like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						|| ".DB_PREFIX."user.user_designation like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						|| concat(".DB_PREFIX."user.user_firstname,' ',".DB_PREFIX."user.user_lastname) like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						|| ".DB_PREFIX."user.user_email like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'
						|| ".DB_PREFIX."user.user_phone like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' )";
	}
	$objpaging->strorderby = DB_PREFIX."user.user_id";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objClientAdmin,"client_admin_list.php",PAGESIZE,$condition);
	
	$extraJs = array("client_admin.js");

	$aAccess = $cmn->getAccessClient("client_admin_detail.php", "client_admin_detail" , 7);		
	
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

                  <div class="fleft">Admin Users</div>
                  <div class="fright">
				  <?php print $cmn->getMenuLink("client_admin_addedit.php","client_admin_addedit","Create","","add_new.png");?>
				  </div>
                </div>
              </div>
            </div>
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <form id="frm" name="frm" method="post">
                  <tr>
                    <td><div class="white">
                        <table cellpadding="5" cellspacing="0" border="0" class="border-none" width="100%" style="clear:both;" >
                          <tr>
                            <td colspan="<?php echo $aAccess[1] ?>" align="left"><table width="100%" class="listtab-rt-bro" cellspacing="0" cellpadding="5">
                                <tbody>
                                  <tr>
                                    <td width="6%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="14%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" /></td>
                                    <td width="80%" valign="middle"><input type="submit" onClick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; javascript: search_record(this.form);" class="btn" value="Search" title="Search" alt="Search" name="btnsearch" id="btnsearch"/>
                                      &nbsp;&nbsp;
                                      <input type="button" class="btn" title="Clear" alt="Clear" value="Clear" name="btnclear" id="btnclear" onclick="javascript: window.location.href='client_admin_list.php';"/></td>
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
						  </table>
						  <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                          <tr bgcolor="#a6caf4" class="txtbo">
                            <td width="12%" align="left" nowrap="nowrap"><strong>Username</strong><?php $objpaging->_sortImages("user_username", $cmn->getCurrentPageName()); ?></td>
                            <td  width="14%" align="left"><strong>First Name</strong><?php $objpaging->_sortImages("user_firstname", $cmn->getCurrentPageName()); ?></td>
                            <td width="13%" align="left"><strong>Last Name</strong><?php $objpaging->_sortImages("user_lastname", $cmn->getCurrentPageName()); ?></td>
                            <td width="16%" align="left"><strong>Designation</strong><?php $objpaging->_sortImages("user_designation", $cmn->getCurrentPageName()); ?></td>
                            <td width="20%" align="left"><strong>E-mail</strong><?php $objpaging->_sortImages("user_email", $cmn->getCurrentPageName()); ?></td>
                            <td width="15%" align="center"><strong>Phone</strong><?php $objpaging->_sortImages("user_phone", $cmn->getCurrentPageName()); ?></td>
                             <?php 
							if ($aAccess[0])
							{
							?>
                            <td width="10%" align="center" class="listtab-rt-bro-user"><strong>Action</strong></td>
                            
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
                            <td width="12%" align="left">
							<?php 
							if ($aAccess[0])
							{
							?>
                            <a title="<?php print htmlspecialchars($arr[$i]["user_username"]); ?>" href="client_admin_detail.php?user_id=<?php print $objEncDec->encrypt(htmlspecialchars($arr[$i]["user_id"])); ?>"><?php print html_entity_decode(htmlentities($arr[$i]["user_username"])); ?></a>
                            
                            <?php
							} 
							else 
							{
								print htmlspecialchars($arr[$i]["user_username"]);
							}
							?></td>
                            <td  width="14%" align="left"><?php print html_entity_decode(htmlentities($arr[$i]["user_firstname"])); ?></td>
                            <td width="13%" align="left"><?php print html_entity_decode(htmlentities($arr[$i]["user_lastname"])); ?></td>
                            <td width="16%" align="left"><?php print html_entity_decode(htmlentities($arr[$i]["user_designation"])); ?></td>
                            <td width="20%" align="left"><a title="<?php print html_entity_decode(htmlentities($arr[$i]["user_email"])); ?>" href="mailto:<?php print htmlspecialchars($arr[$i]["user_email"]); ?>"><?php print html_entity_decode(htmlentities($arr[$i]["user_email"])); ?></a></td>
                            <td width="15%" align="center"><?php print html_entity_decode(htmlentities($arr[$i]["user_phone"])); ?>&nbsp;</td>
                             <?php 
							if ($aAccess[0])
							{
							?>
                            <td align="center" class="listtab-rt-bro-user"><a title="View" href="client_admin_detail.php?user_id=<?php print $objEncDec->encrypt(htmlspecialchars($arr[$i]["user_id"])); ?>" class="gray_btn_view">View</a></td>
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
                            <td colspan="<?php echo $aAccess[1] ?>" align="center" class="listtab-rt-bro-user">No record found.</td>
                          </tr>
                          <?php } else { ?>
                          
                              <input type="hidden" name="inactiveids" value="<?php print $inactiveids; ?>" />
                              <input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $strmode; ?>"/>
                          <?php } ?>
                          
                        </table>
                        <div class="fclear"></div>
                      </div></td>
                  </tr>
                  <tr>
                  	<td><div id="pager"><?php print $objpaging->drawPanel("panel1"); ?></div></td>
                  </tr>
                </form>
              </table>
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
<?php include SERVER_CLIENT_ROOT."include/footer.php";?>
</body>
</html>
