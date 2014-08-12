<?php 
	header('Content-Type: application/x-msexcel; name=datereport.xls');
	header('Content-Disposition: inline;filename=datereport.xls');
	header("Content-Transfer-Encoding: binary ");
	//include base file
require_once 'include/general_includes.php';
	
//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	//create class obj	
$objpaging = new paging();
$objTopClient = new topclientreport();

//check registration date for searching criteria
if(isset($_POST['txtdatefrom']) && $_POST['txtdatefrom']!='')
{
	$txtdatefrom=$_POST['txtdatefrom'];
	$fromdate=explode("/",$_POST['txtdatefrom']);
	$frmdate=$fromdate[2]."-".$fromdate[0]."-".$fromdate[1];
}
else
{
	$frmdate='';
	$txtdatefrom='';
}
if(isset($_POST['txtdateto']) && $_POST['txtdateto']!='')
{
	$txtdateto=$_POST['txtdateto'];
	$dateto=explode("/",$_POST['txtdateto']);
	$todate=$dateto[2]."-".$dateto[0]."-".$dateto[1];
}
else
{
	$todate='';
	$txtdateto='';
}
//END
//Fetch registration source data
$sourcedata=$objTopClient->topresourcedetail($frmdate,$todate);
arsort($sourcedata[0]);

//Date wise registration source data for graph
$datedata=$objTopClient->datewisedetail($frmdate,$todate,'');
	$objExcelWriter = new excelwriter();
	// start the file
	$objExcelWriter->xlsBOF();
	// these will be used for keeping things in order.
	$col = 0;
	$row = 0;
	// This tells us that we are on the first row
	$first = true;
	$str1 = "Dates^^^Facebook Registration^^^Gadget Registration^^^Website Registration###";
	for ($i=0;$i<count($datedata);$i++)
	{
		$str1.= $cmn->readValueDetail($datedata[$i]['reg_date'])."^^^".$cmn->readValueDetail($datedata[$i]['tot_cnt_facebook'])."^^^".$cmn->readValueDetail($datedata[$i]['tot_cnt_gadget'])."^^^".$cmn->readValueDetail($datedata[$i]['tot_cnt_website'])."###";
	//echo $str1;exit;
	}
	
$str1 = substr($str1,0,-3);
//echo $str1."<br><Br>";
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