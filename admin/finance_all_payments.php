<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objFinanceMakePayment = new finance_make_payment();
		
	//require_once SERVER_ADMIN_ROOT.'finance_make_payment_db.php';
	
	$condition = "";
	$objpaging->strorderby = "payment_date";
	$objpaging->strorder = "desc";
	
	
	if(isset($_REQUEST['txtsearchname']) || isset($_REQUEST['txtdatefrom']) || isset($_REQUEST['txtdateto']) || isset($_REQUEST['txtcdatefrom']) || isset($_REQUEST['txtcdateto']))
	{
		if (trim($_REQUEST['txtsearchname'])!="")
		{
			$txtsearchname = trim($_REQUEST['txtsearchname']);
			$condition .= " and (ur.user_username like '%".$cmn->setVal($txtsearchname)."%' 
			|| ur.user_firstname like '%".$cmn->setVal($txtsearchname)."%' 
			|| ur.user_lastname like '%".$cmn->setVal($txtsearchname)."%'
			|| concat(ur.user_firstname,' ',ur.user_lastname) like '%".$cmn->setVal($txtsearchname)."%'
			|| ur.user_email like '%".$cmn->setVal($txtsearchname)."%'
			|| cp.payment_date like '%".$cmn->setVal($txtsearchname)."%'
			|| cpd.plan_title like '%".$cmn->setVal($txtsearchname)."%'
			|| p.payment_type like '%".$cmn->setVal($txtsearchname)."%') ";
		}
		
		if(trim($_REQUEST['txtdatefrom'])!="" && trim($_REQUEST['txtdateto'])!="")
		{
			$condition .= " and (cp.payment_date >=  date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdatefrom'])."', '%m/%d/%Y' ) , '%Y-%m-%d' ) AND cp.payment_date <= date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdateto'])."', '%m/%d/%Y' ) , '%Y-%m-%d 23:59:59' ) ) ";
		}
	 
		if(trim($_REQUEST['txtdatefrom'])!="" && trim($_REQUEST['txtdateto'])=="")
		{
			$fromDate = $cmn->dateTimeFormatMonth($cmn->setVal($_REQUEST['txtdatefrom']),'%Y-%m-%d');
			$condition .= " and cp.payment_date >= date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdatefrom'])."', '%m/%d/%Y' ) , '%Y-%m-%d' ) ";
			//$condition .= " and cp.payment_date like '%".$fromDate."%' ";
		}
		 
		if(trim($_REQUEST['txtdatefrom'])=="" && trim($_REQUEST['txtdateto'])!="")
		{
			$condition .= " and cp.payment_date <= date_format( str_to_date( '".$cmn->setVal($_REQUEST['txtdateto'])."', '%m/%d/%Y' ) , '%Y-%m-%d 23:59:59' ) ";
		}
	}
	else	
		$condition='';
		$arr = $objpaging->setPageDetailsNew($objFinanceMakePayment,"finance_all_payments.php",PAGESIZE,$condition);
	//	print "<pre>";
	//	print_r($arr);
	$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css");
	$extraJs = array("finance_make_payment.js","jquery-ui-1.8.4.custom.min.js");
	$aAccess=$cmn->getAccess("finance_all_payments.php", "finance_all_payments",4);	
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
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

$(function() 
{
	$("#txtcdatefrom").datepicker();
}); 
</script>

<script type="text/javascript">
$(function() 
{
	$("#txtcdateto").datepicker();
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
                  <div class="fleft">&nbsp;All Payments</div>
                  <div class="fright"><?PHP print $cmn->getAdminMenuLink("all_payment_export.php","all_payment_export","Export Detail","","excel.png",false); ?></div>
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
                           <td colspan="7" align="left">
                             <table width="100%" cellspacing="0" cellpadding="0" class="searchForm">
                               <tbody>
                                 <tr>
                                   <td align="left" class="first"><strong>Payment Date From:</strong></td>
                                    <td valign="middle" align="left"><input  class="input_text_date" type="text" name="txtdatefrom" id="txtdatefrom" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtdatefrom'],""));?>" maxlength="50" readonly="readonly"/>&nbsp;<img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();" alt="Calender" title="Calender">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>To:</strong>&nbsp;&nbsp;&nbsp;&nbsp;<input  class="input_text_date" type="text" name="txtdateto" id="txtdateto" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtdateto'],""));?>" maxlength="50" readonly="readonly"/>&nbsp;<img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();" alt="Calender" title="Calender"></td>
                                   
                                    <td valign="middle" align="left" class="first"><strong>Keyword:</strong></td>
                                   <td valign="middle"  align="left" colspan="4" ><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" onclick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1; return search_record_daily(this.form);" class="btn" value="Search" name="btnsearch" id="btnsearch"/>&nbsp;&nbsp;<input type="button" title="Search" onclick="javascript: window.location.href='finance_all_payments.php';" class="btn" value="Clear" name="btnclear" id="btnclear"/></td>
                                  </tr>
                                  
                               </tbody>
                            </table></td>
                        </tr>
                          <tr bgcolor="#a9cdf5" class="txtbo">
                         
                            <td width="7%" align="left" nowrap="nowrap"><strong>Username</strong><br />
                            <?php $objpaging->_sortImages("user_username", $cmn->getCurrentPageName()); ?></td>
                            <td  width="7%" align="left"><strong>Client Name</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php $objpaging->_sortImages("user_firstname", $cmn->getCurrentPageName()); ?></td>
                            <td width="6%" align="right"><strong>Amount</strong><br />
                            <?php $objpaging->_sortImages("amount", $cmn->getCurrentPageName()); ?></td>
                            
                            <td width="10%" align="left"><strong>Email</strong><?php $objpaging->_sortImages("user_email", $cmn->getCurrentPageName()); ?></td>
                            <td width="9%" align="left"><strong> Plan</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php $objpaging->_sortImages("plan_title", $cmn->getCurrentPageName()); ?></td>
                           
                            <td width="8%" align="left"><strong>Payment Date</strong><?php $objpaging->_sortImages("payment_date", $cmn->getCurrentPageName()); ?></td>
                           
                            <td width="8%" align="left"><strong>Payment Status</strong><br />
                            <?php //$objpaging->_sortImages("payment_iscancel", $cmn->getCurrentPageName()); ?></td>
                         
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{
							
							?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                          	
                           <td width="7%" align="left" nowrap="nowrap">&nbsp;<?php print $cmn->readValueDetail($arr[$i]["user_username"]); ?></a></td>
                           <td  width="7%" align="left">&nbsp;<?php print $cmn->readValueDetail($arr[$i]["user_firstname"])." ".$cmn->readValueDetail($arr[$i]["user_lastname"]); ?></td>
                           <td width="6%" align="right">&nbsp;<?php print "$".$cmn->readValueDetail($arr[$i]["amount"]); ?></td>
                          
                           <td width="10%" align="left">&nbsp;<a href="mailto:<?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?>" alt="<?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?>" title="<?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["user_email"]); ?></a></td>
                           <td width="9%" align="left">&nbsp;<?php print $cmn->readValueDetail($arr[$i]['plan_title']); ?></td>
                          
                           <td width="8%" align="left">&nbsp;<?php $dt = explode(" ",$arr[$i]["payment_date"]); print $cmn->dateTimeFormat($cmn->readValueDetail($dt[0]),'%m/%d/%Y'); ?></td>
                           
                          
                          
                            <td width="8%" align="left">&nbsp;<?php if($arr[$i]["payment_status"]==1) print "Paid"; else if($arr[$i]["payment_status"]==0) print "pending";else if($arr[$i]["payment_status"]==2) print "Cancle"; ?></td>
                          </tr>
                          <?php 
						}
						 if(!empty($arclient_payment_id)) 
						 	$inactiveids = implode(",",$arclient_payment_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="12" align="center">No record found.</td>
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