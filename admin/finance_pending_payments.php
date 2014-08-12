<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objFinancePendingPayment = new finance_pending_payment();
	
	$condition = "";
	
	$objpaging->strorderby = "payment_date";
	$objpaging->strorder = "desc";
	
	$condition = "";
	
	if(isset($_REQUEST['txtsearchname']) )
	{
		if (trim($_REQUEST['txtsearchname'])!="" )
		{
			$txtsearchname = trim($_REQUEST['txtsearchname']);
		
			$condition .= " and (u.user_username like '%".$cmn->setVal($txtsearchname)."%' 
				|| u.user_firstname like '%".$cmn->setVal($txtsearchname)."%' 
				|| u.user_lastname like '%".$cmn->setVal($txtsearchname)."%'
				|| concat(u.user_firstname,' ',u.user_lastname) like '%".$cmn->setVal($txtsearchname)."%'
				|| u.user_email like '%".$cmn->setVal($txtsearchname)."%'
				|| p.plan_title like '%".$cmn->setVal($txtsearchname)."%'
				|| (TO_DAYS( '".currentScriptDate()."' ) - TO_DAYS( u.created_date )) = '".$cmn->setVal($txtsearchname)."') ";
		}
		
	}
		 
		$arr = $objpaging->setPageDetails($objFinancePendingPayment,"finance_pending_payments.php",PAGESIZE,$condition);
	

	$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css");
	$extraJs = array("finance_make_payment.js","jquery-ui-1.8.4.custom.min.js");

	$aAccess = $cmn->getAccess("finance_make_payment.php", "finance_make_payment", 10);	
	$bAccess = $cmn->getAccess("finance_cancel_payments.php", "finance_cancel_payments", 10);	
	
	$colsAccess = 8;
	
	
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
	
	$objContestPlan = new plan();
	
?>

<script type="text/javascript">
$(function() 
{
	$("#txtdatefrom").datepicker();
}); 
</script>

<script type="text/javascript">
$(function() 
{
	$("#txtdateto").datepicker();
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
                  <div class="fleft">&nbsp;Pending Payments</div>
                  <div class="fright">&nbsp;</div>
                </div>
              </div>
            </div>
           
            <div class="blue_title_cont">
            <form id="frm" name="frm" method="post">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
              	
                <tr>
                  <td width="100%"><div style="width:100%;">
                      
                        <table cellpadding="0" cellspacing="0" border="0" class="listtab_range" width="100%" style="clear:both;">
                          <tr>
                           <td colspan="<?PHP echo $colsAccess; ?>" align="left">
                             <table width="100%" cellspacing="0" cellpadding="0">
                               <tbody>
                                 <tr>
                                   <td width="100%" valign="middle" align="left"><strong>Keyword:</strong>&nbsp;&nbsp;<input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" onclick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; return search_record(this.form);" class="btn" value="Search" name="btnsearch" id="btnsearch"/>&nbsp;&nbsp;<input type="button" title="Search" onclick="javascript: window.location.href='finance_pending_payments.php';" class="btn" value="Clear" name="btnclear" id="btnclear"/></td>
                                  </tr>
                               </tbody>
                            </table></td>
                        </tr>
                          <tr bgcolor="#a9cdf5" class="txtbo">
                            <td width="10%" align="left" nowrap="nowrap"><strong>Username</strong><?php $objpaging->_sortImages("user_username", $cmn->getCurrentPageName()); ?></td>
                            <td  width="14%" align="left"><strong>Client Name</strong><?php $objpaging->_sortImages("user_firstname", $cmn->getCurrentPageName()); ?></td>
                            <td width="6%" align="right"><strong>Amount</strong><?php $objpaging->_sortImages("amount", $cmn->getCurrentPageName()); ?></td>
                            <td width="12%" align="left"><strong>Email</strong><?php $objpaging->_sortImages("user_email", $cmn->getCurrentPageName()); ?></td>
                            <td width="10%" align="left"><strong>Plan</strong><?php $objpaging->_sortImages("plan_title", $cmn->getCurrentPageName()); ?></td>
                            <td width="9%" align="right"><strong>Pending Days</strong><?php $objpaging->_sortImages("pending", $cmn->getCurrentPageName()); ?></td>
                            <?php 
							if ($aAccess[0])
							{
							?>
                            <td width="6%" align="left"><strong>Make Payment</strong></td>
                            <?PHP } ?>
                            <?php 
							if ($bAccess[0])
							{
							?>
                            <td width="7%" align="left"><strong>Cancel Payment</strong></td>
                            <?PHP } ?>
                          </tr>
                          <?php 
						  
						for ($i=0;$i<count($arr);$i++)
						{
							?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                          	
                            <td width="10%" align="left" nowrap="nowrap">&nbsp;<?php print $cmn->readValueDetail($arr[$i]["user_username"]); ?></a></td>
                            <td  width="14%" align="left">&nbsp;<?php print $cmn->readValueDetail($arr[$i]["user_firstname"])." ".$cmn->readValueDetail($arr[$i]["user_lastname"]); ?></td>
                            <td width="6%" align="right">&nbsp;<?php print "$".$cmn->readValueDetail($arr[$i]["amount"]); ?></td>
                            <td width="12%" align="left">&nbsp;<a href="mailto:<?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?>" title="<?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?>" alt="<?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?></a></td>
                            <td width="10%" align="left">&nbsp;<?php print $cmn->readValueDetail($arr[$i]['plan_title']); ?></td>
                            <td width="9%" align="right">&nbsp;<?php print $arr[$i]["pending"]; ?></td>
                            <?php 
							if ($aAccess[0])
							{
							?>
                            <td width="6%" align="left"><a href="<?PHP echo SERVER_ADMIN_HOST; ?>finance_make_payment.php?hdnclient_payment_id=<?PHP echo $arr[$i]["client_payment_id"]; ?>" title="Make Payment">Make</a></td>
                            <?PHP } ?>
                             <?php 
							if ($bAccess[0])
							{
							?>
                            <td width="7%" align="left"><a href="<?PHP echo SERVER_ADMIN_HOST; ?>finance_cancel_payments.php?client_payment_id=<?PHP echo $arr[$i]["client_payment_id"]; ?>" title="Cancel Payment">Cancel</a></td>
                           <?PHP } ?>
                          </tr>
                          <?php 
						}
						 if(!empty($arclient_payment_id)) 
						 	$inactiveids = implode(",",$arclient_payment_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="<?php echo $colsAccess ?>" align="center">No record found.</td>
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