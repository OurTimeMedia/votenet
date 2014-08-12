<?php
	//include base file
	require_once 'include/general_includes.php';
	
	//check admin login authentication
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	//create class objects
	$objpaging = new paging();
	$objSystemAdmin = new user();
	
	// include file for DB related operations
	require_once 'system_admin_db.php';
	
	//fetch admin data
	$condition = " AND (".DB_PREFIX."user.user_type_id = '".USER_TYPE_SYSTEM_ADMIN."' || ".DB_PREFIX."user.user_type_id = '".USER_TYPE_SUPER_SYSTEM_ADMIN."')";
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
	$arr = $objpaging->setPageDetails($objSystemAdmin,"system_admin_list.php",PAGESIZE,$condition);
	///
	
	//call js files
	$extraJs = array("system_admin.js");

	//get access details	
	$aAccess = $cmn->getAccess("system_admin_detail.php", "system_admin_detail" , 7);		
	
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
                  <div class="fleft">System Admins</div>
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("system_admin_addedit.php","system_admin_addedit","Create","","add_new.png");?> </div>
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
                            <td colspan="<?php echo $aAccess[1] ?>" align="left">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print $cmn->readValue($_REQUEST['txtsearchname'],"");?>" /></td>
                                    <td width="74%" valign="middle"><input type="submit" onclick="javascript: search_record(this.form);" class="btn" title="Search" value="Search" name="btnsearch" id="btnsearch"/>&nbsp;&nbsp;<input type="button" title="Clear" onclick="javascript: window.location.href='system_admin_list.php';" class="btn" value="Clear" name="btnclear" id="btnclear"/></td>
                                      
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
                          <tr bgcolor="#a9cdf5" class="txtbo">
                            <!--<td>&nbsp;</td>-->
                            <td width="12%" align="left" nowrap="nowrap"><strong>Username</strong></a><?php $objpaging->_sortImages("user_username", $cmn->getCurrentPageName()); ?></td>
                            <td  width="14%" align="left"><strong>First Name</strong><?php $objpaging->_sortImages("user_firstname", $cmn->getCurrentPageName()); ?></td>
                            <td width="14%" align="left"><strong>Last Name</strong><?php $objpaging->_sortImages("user_lastname", $cmn->getCurrentPageName()); ?></td>
                            <td width="15%" align="left"><strong>Designation</strong><?php $objpaging->_sortImages("user_designation", $cmn->getCurrentPageName()); ?></td>
                            <td width="22%" align="left"><strong>E-mail</strong><?php $objpaging->_sortImages("user_email", $cmn->getCurrentPageName()); ?></td>
                            <td width="17%" align="center"><strong>Phone</strong><?php $objpaging->_sortImages("user_phone", $cmn->getCurrentPageName()); ?></td>
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
                            
                            <a href="system_admin_detail.php?user_id=<?php print htmlspecialchars($arr[$i]["user_id"]); ?>" title="<?php print htmlspecialchars($arr[$i]["user_username"]); ?>"><?php print htmlspecialchars($arr[$i]["user_username"]); ?></a>
                            
                            <?php 
							} 
                            else 
                            {
                            	print htmlspecialchars($arr[$i]["user_username"]);
                            }
                            
                            ?>
                            
                            </td>
                            <td align="left"><?php print htmlspecialchars($arr[$i]["user_firstname"]); ?></td>
                            <td align="left"><?php print htmlspecialchars($arr[$i]["user_lastname"]); ?></td>
                            <td align="left">&nbsp;<?php print htmlspecialchars($arr[$i]["user_designation"]); ?></td>
                            <td align="left"><a href="mailto:<?php print htmlspecialchars($arr[$i]["user_email"]); ?>" title="<?php print htmlspecialchars($arr[$i]["user_email"]); ?>"><?php print htmlspecialchars($arr[$i]["user_email"]); ?></a></td>
                            <td align="center">&nbsp;<?php print htmlspecialchars($arr[$i]["user_phone"]); ?></td>
                           
                            <?php 
							if ($aAccess[0])
							{
							?>
							 <td align="center">
                            <a href="system_admin_detail.php?user_id=<?php print htmlspecialchars($arr[$i]["user_id"]); ?>" class="gray_btn_view" title="View">View</a>
                            </td>
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
                            <td colspan="<?php echo $aAccess[1]?>" align="center">No record found.</td>
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
