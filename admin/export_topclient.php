<?php 
header('Content-Type: application/x-msexcel; name=topclient.xls');
header('Content-Disposition: inline;filename=topclient.xls');
header("Content-Transfer-Encoding: binary ");
require_once 'include/general_includes.php';

$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$objTopClient = new topclientreport();


if(isset($_POST['txtdatefrom']) && $_POST['txtdatefrom']!='')
{
	$fromdate=explode("/",$_POST['txtdatefrom']);
	$frmdate=$fromdate[2]."-".$fromdate[0]."-".$fromdate[1];
}
else
	$frmdate='';
if(isset($_POST['txtdateto']) && $_POST['txtdateto']!='' )
{
	$dateto=explode("/",$_POST['txtdateto']);
	$todate=$dateto[2]."-".$dateto[0]."-".$dateto[1];
}
else
	$todate='';
	
$orderby="";	
$clientdata=$objTopClient->topclientdetail($frmdate,$todate,$orderby);

$objExcelWriter = new excelwriter();
// start the file
$objExcelWriter->xlsBOF();
// these will be used for keeping things in order.
$col = 0;
$row = 0;
// This tells us that we are on the first row
$first = true;
$str1 = "Client Name^^^Total Registration###";
	
if(count($clientdata)>0 && is_array($clientdata) && $clientdata[0]['client_name']!='')
{
	for ($i=0;$i<count($clientdata);$i++)
	{
		 
		$str1.= $cmn->readValueDetail($clientdata[$i]['client_name']);
		$str1.="^^^".$cmn->readValueDetail($clientdata[$i]['tot_cnt'])."###";
	}
}
$str1 = substr($str1,0,-3);

$aTest = explode('###', $str1);
for ($i=0; $i<count($aTest); $i++)
{
	$aItems = explode('^^^', $aTest[$i]);
	// go through the data
    foreach($aItems as $value)
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