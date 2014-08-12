<?php 
header('Content-Type: application/x-msexcel; name=allpayments.xls');
header('Content-Disposition: inline;filename=allpayments.xls');
header("Content-Transfer-Encoding: binary ");

require_once 'include/general_includes.php';
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$objFinanceMakePayment = new finance_make_payment();
	
$condition = "";
$objpaging->strorderby = "payment_date";
$objpaging->strorder = "desc";

$arr = array();
$i = 0;
$resSet = $objFinanceMakePayment->fetchRecordSetNew('','','payment_date desc');
while($res = mysql_fetch_assoc($resSet))
{
	$arr[$i] = $res;
	$i++;
}

$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css");
$extraJs = array("finance_make_payment.js","jquery-ui-1.8.4.custom.min.js");

$aAccess = $cmn->getAccess("finance_all_payments.php", "finance_all_payments", 4);	

$objExcelWriter = new excelwriter();

// start the file
$objExcelWriter->xlsBOF();

// these will be used for keeping things in order.
$col = 0;
$row = 0;

// This tells us that we are on the first row
$first = true;

$str1 = "Username,Client Name,Amount,Email,Plan Title,Expiry Date,Payment Status###";

for ($i=0;$i<count($arr);$i++)
{
	if($arr[$i]["payment_status"]==2) { $statusc = "Cancle"; } else if($arr[$i]["payment_status"]==1) { $statusc = "Paid"; } else {$statusc = "Pending";}
	if($arr[$i]["transaction_id"]=="" || $arr[$i]["transaction_id"]==0) { $trid = "N/A"; } else { $trid = $cmn->readValueDetail($arr[$i]["transaction_id"]); }
   	$str1.= $cmn->readValueDetail($arr[$i]["user_username"]).",".$cmn->readValueDetail($arr[$i]["user_firstname"])." ".$cmn->readValueDetail($arr[$i]["user_lastname"]).",$".number_format($cmn->readValueDetail($arr[$i]["amount"]),2).",".$cmn->readValueDetail($arr[$i]["user_email"]).",".$cmn->readValueDetail($arr[$i]['plan_title']).",".$cmn->dateTimeFormat($cmn->readValueDetail($arr[$i]['expiry_date']),'%m/%d/%Y').",".$statusc."###";
	//echo $str1;exit;
}
$str1 = substr($str1,0,-3);

$aTest = explode('###', $str1);

for ($i=0; $i<count($aTest); $i++)
{
	$aItems = explode(',', $aTest[$i]);
	// go through the data
    foreach( $aItems as $value )
    {
        // write it out
        $objExcelWriter->xlsWriteLabel( $row, $col, $value );
        $col++;
    }
    // reset col and goto next row
    $col = 0;
    $row++;	
}
$objExcelWriter->xlsEOF();
exit();

?>