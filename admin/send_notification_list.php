<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objSendNotification = new send_notification();
		
	require_once SERVER_ADMIN_ROOT.'send_notification_db.php';
	
	$condition = " AND notification_send_date >= '".currentScriptDate()."' ";
	
	$objpaging->strorderby = "notification_send_date";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objSendNotification,"send_notification_list.php",PAGESIZE,$condition);
	
	$extraJs = array("send_notification.js");

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
                  <div class="fleft">&nbsp;Pending Notifications</div>
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("send_notification_addedit.php","send_notification_addedit","Create","","add_new.png");?> </div>
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
                         
                            <td width="27%" align="left" nowrap="nowrap"><strong>Title/Subject Line</strong></a><?php $objpaging->_sortImages("notification_title", $cmn->getCurrentPageName()); ?></td>
                            <td  width="16%" align="left"><strong>Message Type</strong><?php $objpaging->_sortImages("notification_type", $cmn->getCurrentPageName()); ?></td>
                            <td width="14%" align="left"><strong>User Type</strong><?php $objpaging->_sortImages("notification_user_type", $cmn->getCurrentPageName()); ?></td>
                            <td width="16%" align="left"><strong>User Names</strong><?php $objpaging->_sortImages("notification_usernames", $cmn->getCurrentPageName()); ?></td>
                            <td width="18%" align="left"><strong>Send Date</strong><?php $objpaging->_sortImages("notification_send_date", $cmn->getCurrentPageName()); ?></td>
                           <td width="9%" align="center"><input type="checkbox" name="main" id="main" onclick="checkall(this.form)" /></td>
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$arsend_notification_id[] = $arr[$i]["notification_id"] ?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                          
                            <td align="left" valign="top"><?php print htmlspecialchars($arr[$i]["notification_title"]); ?></td>
                            <td align="left" valign="top"><?php if($cmn->getVal($arr[$i]["notification_type"]==0)) { print "Email"; }
												else if($cmn->getVal($arr[$i]["notification_type"]==1)) { print "Dashboard-header"; }
												else if($cmn->getVal($arr[$i]["notification_type"]==2)) { print "Email / Dashboard-header"; }
											 ?></td>
                            <?php $notification_user_type = explode(",",$cmn->getVal($arr[$i]["notification_user_type"])); 
							  	  $user_type = '';
								  for($k=0;$k<count($notification_user_type);$k++)
								  {
								  	if($notification_user_type[$k]==2)
									{ $ut = "System Admin"; }
									else if($notification_user_type[$k]==3)
									{ $ut = "Super Contest Admin"; }
									else if($notification_user_type[$k]==4)
									{ $ut = "Contest Admin"; }
									else if($notification_user_type[$k]==5)
									{ $ut = "Entrant User"; }
									else if($notification_user_type[$k]==6)
									{ $ut = "Judge User"; }
								  	$user_type.= $ut.", ";
								  }
								  $user_type = substr($user_type,0,-2);
							?>
                            <td align="left" valign="top"><?php print $user_type; ?></td>
                            <?PHP 
							$aUserName = explode(",",$arr[$i]["notification_usernames"]);
							$sUserId = '';
							for($j=0;$j<count($aUserName);$j++) {
								$sUserId.= $objSendNotification->getUserNames($aUserName[$j]).",";
							} $sUserId = substr($sUserId,0,-1); ?>
                            <td align="left" valign="top"><?php print htmlspecialchars($sUserId); ?></td>
                            <td align="left" valign="top"><?php $dt = explode(" ",$cmn->getVal($arr[$i]["notification_send_date"])); print $cmn->dateTimeFormat(htmlspecialchars($dt[0]),'%m/%d/%Y')." ".$dt[1]; ?></td>
	                        <td align="center" valign="top">&nbsp;<input type="checkbox" name="deletedids[]" value="<?php print trim($arr[$i]['notification_id']); ?>" /></td>
                          </tr>
                          <?php 
						} ?>
						
						<?PHP if(!empty($arsend_notification_id)) 
						 	$inactiveids = implode(",",$arsend_notification_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="6" align="center">No record found.</td>
                          </tr>
                          <?php } else { ?>
          					   <tr >
                        	<td align="left" colspan="5">&nbsp;</td>
                            <td align="center" valign="top" ><input type="submit" name="btndelete" class="btn" value="Delete" onclick="return setaction('delete','send_notification_db.php');"/>
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