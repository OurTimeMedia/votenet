<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	
	$objNotification = new notification();
	$objSendNotification = new send_notification();

	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objNotification->user_id = $userID;
	
	$objClient = new client();
	$objNotification->client_id = $objClient->fieldValue("client_id",$userID);
	$objNotification->created_by = $cmn->getSession(ADMIN_USER_ID);
	$objNotification->updated_by = $cmn->getSession(ADMIN_USER_ID);
	
	// Delete Previous Day's Notifications
	$objNotification->deleteNotification();
	
	$todaysNotification = $objNotification->fetchNotificationsCount();
	
	if($todaysNotification==0)
	{
		
		$m1 = 1;
			
		//$condition = " AND (notification_usernames like '%,".$userID."%' OR notification_usernames like '%".$userID.",%') AND CAST(notification_send_date AS DATE)>=DATE( '".currentScriptDate()."' ) ";
		
		$condition = " AND FIND_IN_SET('".$userID."', notification_usernames) AND CAST(notification_send_date AS DATE)<=DATE( '".currentScriptDate()."' ) AND DATE_SUB('".currentScriptDateOnly()."',INTERVAL 15 DAY) <= CAST(notification_send_date AS DATE) ";
		
		$arrSystemNotification = $objSendNotification->fetchSetAllAsArray("","",$condition);
		
		if(count($arrSystemNotification)>0)
		{
			for($m=0;$m<count($arrSystemNotification);$m++)
			{
				$objNotification->order = $m1;
				$objNotification->notification_id = $arrSystemNotification[$m]['notification_id'];
				$objNotification->subject = $arrSystemNotification[$m]['subject'];
				$objNotification->message = $arrSystemNotification[$m]['message'];
				$objNotification->timings = $arrSystemNotification[$m]['timings'];
				$objNotification->is_display = 1;
				$objNotification->is_admin_notification = 1;
				$objNotification->insetNotificationDtl();	
				$m1++;
			}
		}
		
		$arrNotification = $objNotification->fetchAvailableNotifications();
		$objNotification->notification_id = 0;
		for($m=0;$m<count($arrNotification);$m++)
		{
			if(array_search('0 Day',$arrNotification[$m])!='')
			{
				$objNotification->order = $m1;
				$objNotification->subject = $objNotification->subject(array_search('0 Day',$arrNotification[$m]),0,$arrNotification[$m]['contest_title']);
				$objNotification->message = $objNotification->msg(array_search('0 Day',$arrNotification[$m]),0,$arrNotification[$m]['contest_title']);
				$objNotification->timings = $arrNotification[$m]['timings'];
				$objNotification->is_display = 1;
				$objNotification->is_admin_notification = 0;
				$objNotification->insetNotificationDtl();
				
				$m1++;
			}
		}
	
		for($m=0;$m<count($arrNotification);$m++)
		{	
			if(array_search('1 Day',$arrNotification[$m])!='')
			{
				$objNotification->order = $m1;
				$objNotification->subject = $objNotification->subject(array_search('1 Day',$arrNotification[$m]),1,$arrNotification[$m]['contest_title']);
				$objNotification->message = $objNotification->msg(array_search('1 Day',$arrNotification[$m]),1,$arrNotification[$m]['contest_title']);
				$objNotification->timings = $arrNotification[$m]['timings'];
				$objNotification->is_display = 1;
				$objNotification->is_admin_notification = 0;
				$objNotification->insetNotificationDtl();
				
				$m1++;
			}
		}
			
		for($m=0;$m<count($arrNotification);$m++)
		{
			if(array_search('2 Day',$arrNotification[$m])!='')
			{
				$objNotification->order = $m1;
				$objNotification->subject = $objNotification->subject(array_search('2 Day',$arrNotification[$m]),2,$arrNotification[$m]['contest_title']);
				$objNotification->message = $objNotification->msg(array_search('2 Day',$arrNotification[$m]),2,$arrNotification[$m]['contest_title']);
				$objNotification->timings = $arrNotification[$m]['timings'];
				$objNotification->is_display = 1;
				$objNotification->is_admin_notification = 0;
				$objNotification->insetNotificationDtl();
				
				$m1++;
			}
		}
			
		for($m=0;$m<count($arrNotification);$m++)
		{
			if(array_search('3 Day',$arrNotification[$m])!='')
			{
				$objNotification->order = $m1;
				$objNotification->subject = $objNotification->subject(array_search('3 Day',$arrNotification[$m]),3,$arrNotification[$m]['contest_title']);
				$objNotification->message = $objNotification->msg(array_search('3 Day',$arrNotification[$m]),3,$arrNotification[$m]['contest_title']);
				$objNotification->timings = $arrNotification[$m]['timings'];
				$objNotification->is_display = 1;
				$objNotification->is_admin_notification = 0;
				$objNotification->insetNotificationDtl();
				
				$m1++;
			}
  		}
	
	
	}	
	
	$objNotification = new notification();
	$objSendNotification = new send_notification();
	$objEncDec = new encdec();
	$objpaging = new paging();
	
	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objNotification->user_id = $userID;
	
	$objContestAdmin = new client();
	$user_id = $cmn->getSession(ADMIN_USER_ID);
	$client_id = $objContestAdmin->fieldValue("client_id",$user_id);

	$condition = "";
	if(isset($_REQUEST['txtsearchname']))
	{
		if (trim($_REQUEST['txtsearchname'])!="")
			$condition .= " AND ( DATE_FORMAT(CAST(timings AS DATE),'%M %d, %Y at %h:%i %p') like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'	
								|| subject like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
								|| message like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
						)";
	}
	
	if(isset($_REQUEST['txtdatefrom']) || isset($_REQUEST['txtdateto']))
	{
		if (trim($_REQUEST['txtdatefrom'])!="" || trim($_REQUEST['txtdateto'])!="")
		{
			if(trim($_REQUEST['txtdatefrom'])!="" && trim($_REQUEST['txtdateto'])!="")
			{
				$condition .= " and (timings >=  date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdatefrom'])."', '%m/%d/%Y' ) , '%Y-%m-%d' ) AND timings <= date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdateto'])."', '%m/%d/%Y' ) , '%Y-%m-%d 23:59:59' ) ) ";
			 }
				 
			 if(trim($_REQUEST['txtdatefrom'])!="" && trim($_REQUEST['txtdateto'])=="")
			 {
				$fromDate = $cmn->dateTimeFormatMonth($cmn->setVal($_REQUEST['txtdatefrom']),'%Y-%m-%d');
				$condition .= " and timings >= date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdatefrom'])."', '%m/%d/%Y' ) , '%Y-%m-%d' ) ";
			 }
					 
			 if(trim($_REQUEST['txtdatefrom'])=="" && trim($_REQUEST['txtdateto'])!="")
			 {
				$condition .= " and timings <= date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdateto'])."', '%m/%d/%Y' ) , '%Y-%m-%d 23:59:59' ) ";
	 		}
	 	}
	}
	
	$objpaging->strorderby = "`order`";
	$objpaging->strorder = "asc";
	
	$arr = $objpaging->setPageDetails($objNotification,"notifications_list.php",PAGESIZE,$condition);
	
	$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css");
	
	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top.php";
?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(function()
{					   
	// Dialog Link
	jQuery('#dialog_link').click(function(){
	jQuery('#dialog').dialog();
		return false;
	});			
});
</script>
<script type="text/javascript">
jQuery(function() 
{
	jQuery("#txtdateto").datepicker();
}); 

jQuery(function() 
{
	jQuery("#txtdatefrom").datepicker();
}); 
</script>

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
                  <div class="fleft">Notifications</div>
                 
                  <div class="fright">&nbsp;</div>
                  
                </div>
              </div>
            </div>

            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
								<form id="frm" name="frm" method="post">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">                
                  <tr>
                    <td><div class="white">                        
						  <table cellpadding="5" cellspacing="0" border="0" class="border-none" width="100%" style="clear:both;" >
							<tr class="row02">
                              <td width="100%" align="left"><table width="100%" class="listtab-rt-bro" cellspacing="0" cellpadding="5">
                                <tbody>
                                  <tr>
									  <td width="8%" valign="middle" align="left"><strong>Keyword:</strong></td>
									  <td width="17%" valign="middle" align="left"><input type="text" class="input-small" name="txtsearchname" id="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" /></td>
											  
									  <td valign="middle" align="left" width="8%"><strong>From Date:</strong></td>
									   <td width="20%" valign="middle" align="left"><input  class="input_small" type="text" name="txtdatefrom" id="txtdatefrom" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtdatefrom'],""));?>" maxlength="50" readonly="readonly"/>&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();" alt="Calender" title="Calender"></td>
									  <td valign="middle" align="left" width="8%"><strong>To Date:</strong></td>
									  <td valign="middle" align="left"><input  class="input_small" type="text" name="txtdateto" id="txtdateto" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtdateto'],""));?>" maxlength="50" readonly="readonly"/>&nbsp;<img src="<?php echo SERVER_CLIENT_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();" alt="Calender" title="Calender"></td>
									<td valign="middle" align="left"><input type="submit" class="btn" value="Search" name="btnsearch" id="btnsearch" onclick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; " />
										&nbsp;
										<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear"  onclick="javascript: window.location.href='notifications_list.php';" />
										</td> 
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
						  <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                          <tr bgcolor="#a9cdf5" class="txtbo">
                            <td width="30%" align="left" nowrap="nowrap"><strong>Noification Date</strong><?php $objpaging->_sortImages("timings", $cmn->getCurrentPageName()); ?></td>                           
                            <td width="60%" align="left"><strong>Message</strong><?php $objpaging->_sortImages("message", $cmn->getCurrentPageName()); ?></td>
                            <td width="10%" align="center" class="listtab-rt-bro-user"><strong>Action</strong></td>
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                           
                            <td align="left"><?PHP echo $cmn->dateTimeFormat($arr[$i]['timings'],"%M %d, %Y"); ?></td>
                            <td align="left"><?PHP echo html_entity_decode(htmlentities($arr[$i]['message'])); ?></td>
                            <td align="center" class="listtab-rt-bro-user"><a title="View" href="notifications_delete.php?system_notification_id=<?php print $objEncDec->encrypt($cmn->readValueDetail($arr[$i]["system_notification_id"])); ?>" class="gray_btn_view">Delete</a></td>
                          </tr>
                          <?php 
						}
						 if(!empty($aruser_id)) 
						 	$inactiveids = implode(",",$aruser_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="3" align="center">No record found.</td>
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