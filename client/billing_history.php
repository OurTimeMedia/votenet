<?php	

	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objBillingHistory = new billing_history();
	
	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objClient = new client();
	$client_id = $objClient->fieldValue("client_id",$userID);

	//require_once 'billing_history_db.php';

	$condition = " AND cp.client_id='".$client_id."'";
	$objpaging->strorderby = "payment_date";
	$objpaging->strorder = "desc";

	if(isset($_REQUEST['txtsearchname']))
	{
		$txtsearchname = trim($_REQUEST['txtsearchname']);
			
		if(strtolower($txtsearchname) == "online")
		{
			$txtsearchname = 1;
			$condition .= " and cp.transaction_type = '".$txtsearchname."' ";
		}
		else if(strtolower($txtsearchname) == "offline")
		{	
			$txtsearchname = 2;
			$condition .= " and cp.transaction_type = '".$txtsearchname."' ";
		}
		else
		{
			$condition .= " and (ur.user_username like '%".$cmn->setVal($txtsearchname)."%' 
				|| ur.user_firstname like '%".$cmn->setVal($txtsearchname)."%' 
				|| ur.user_lastname like '%".$cmn->setVal($txtsearchname)."%'
				|| concat(ur.user_firstname,' ',ur.user_lastname) like '%".$cmn->setVal($txtsearchname)."%'
				|| ur.user_email like '%".$cmn->setVal($txtsearchname)."%'
				|| ct.contest_title like '%".$cmn->setVal($txtsearchname)."%'
				|| cpd.contest_plan_title like '%".$cmn->setVal($txtsearchname)."%'
				|| p.payment_type like '%".$cmn->setVal($txtsearchname)."%'
				|| cp.transaction_type = '".$cmn->setVal($txtsearchname)."'
				|| DATE_FORMAT(CAST(cp.payment_date AS DATE),'%m/%d/%Y') like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' 
				|| DATE_FORMAT(CAST(ct.winner_announce_date AS DATE),'%m/%d/%Y') like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%')";
		}
	}
	$arr = $objpaging->setPageDetailsNew($objBillingHistory,"billing_history.php",PAGESIZE,$condition);

	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top.php";
?>

<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
          <div class="user_tab_mn">
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">Billing History</div>
                  <div class="fright"></div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <form id="frm" name="frm" method="post">
                  <tr>
                    <td><div class="">
                        <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                          <tr>
                            <td colspan="9" align="left"><table width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" class="input-small" name="txtsearchname"/></td>
                                    <td width="74%" valign="middle"><input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch" onclick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; document.frm.submit();"/>
                                      &nbsp;&nbsp;
                                      <input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript: window.location.href='billing_history.php';"/></td>
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
                          <tr bgcolor="#a9cdf5" class="txtbo">
                            <td width="14%" align="left" nowrap="nowrap"><strong>Contest Name</strong><?php $objpaging->_sortImages("contest_title", $cmn->getCurrentPageName()); ?></td>
                            <td width="7%" align="left"><strong>Amount</strong><?php $objpaging->_sortImages("amount", $cmn->getCurrentPageName()); ?></td>
                            <td width="11%" align="left"><strong>Contest Plan</strong><?php $objpaging->_sortImages("contest_plan_title", $cmn->getCurrentPageName()); ?></td>
                            <td width="10%" align="left"><strong>Contest Date</strong><?php $objpaging->_sortImages("winner_announce_date", $cmn->getCurrentPageName()); ?></td>
                            <td width="8%" align="left"><strong>Status</strong></td>
                            <td width="11%" align="left"><strong>Payment Date</strong><?php $objpaging->_sortImages("payment_date", $cmn->getCurrentPageName()); ?></td>
                            <td width="13%" align="left"><strong>Transaction Type</strong><?php $objpaging->_sortImages("transaction_type", $cmn->getCurrentPageName()); ?></td>
                            <td width="11%" align="left"><strong>Transaction ID</strong><?php $objpaging->_sortImages("transaction_id", $cmn->getCurrentPageName()); ?></td>
                            <td width="15%" align="left"><strong>Transaction Details</strong><?php $objpaging->_sortImages("payment_description", $cmn->getCurrentPageName()); ?></td>
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{
							$sAllPaymentDtl = $objBillingHistory->fetchAllPaymentDetails($arr[$i]["contest_payment_id"]);
							if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";
							$fColor = "";
							if($sAllPaymentDtl["payment_status"]==0) { $fColor = "color:red;"; }
						?>
                          <tr class="<?php echo $strrow_class;?>" style="<?PHP echo $fColor;?>">
                            <td align="left"><?php print $cmn->readValueDetail($sAllPaymentDtl["contest_title"]); ?></td>
                            <td align="left"><?php print "$".$sAllPaymentDtl["amount"]; ?></td>
                            <td align="left"><?php print $cmn->readValueDetail($sAllPaymentDtl['contest_plan_title']); ?></td>
                            <td align="left"><?php $dt = explode(" ",$sAllPaymentDtl["winner_announce_date"]); print $cmn->dateTimeFormat($cmn->readValueDetail($dt[0]),'%m/%d/%Y'); ?></td>
                            <td align="left"><?php if($sAllPaymentDtl["payment_status"]==0) { print "Unpaid"; } else { print "Paid"; } ?></td>
                            <td align="left"><?php if($sAllPaymentDtl["payment_date"]!="" ) { $dt = explode(" ",$sAllPaymentDtl["payment_date"]); print $cmn->dateTimeFormat($cmn->readValueDetail($dt[0]),'%m/%d/%Y'); } else { print "N/A";} ?></td>
                            <td align="left"><?php if($sAllPaymentDtl["transaction_type"]==1) print "Online"; else if($sAllPaymentDtl["transaction_type"]==2) print "Offline"; ?></td>
                            <td align="left"><?php if($sAllPaymentDtl["transaction_id"]!="") { print $cmn->readValueDetail($sAllPaymentDtl["transaction_id"]); } else { print "N/A"; } ?></td>
                            <td align="left"><?php if($sAllPaymentDtl["payment_description"]!="") { print $sAllPaymentDtl["payment_description"]; } else { print "N/A"; } ?></td>
                          </tr>
                           <?php 
						}
						 if(!empty($arcontest_payment_id)) 
						 	$inactiveids = implode(",",$arcontest_payment_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="12" align="center">No record found.</td>
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
<?php include SERVER_CLIENT_ROOT."include/footer.php";?>
</body>
</html>