<?php 
	header('Content-Type: application/x-msexcel; name=RegistrationSourceReport.xls');
	header('Content-Disposition: inline;filename=RegistrationSourceReport.xls');
	header("Content-Transfer-Encoding: binary ");
	require_once 'include/general_includes.php';
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objpaging = new paging();
	$userID = $cmn->getSession(ADMIN_USER_ID);
	
	$objClient = new client();
	$client_id = $objClient->fieldValue("client_id",$userID);

	$objTopClient = new topclientreport();
	$objEncDec = new encdec();
	$objpaging = new paging();
	//print_r($_POST);
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
	if(isset($_POST['txtdateto']) && $_POST['txtdateto']!='' )
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
		
	$sourcedata=$objTopClient->topresourcedetail($frmdate,$todate,$client_id);
		
	$objExcelWriter = new excelwriter();
	// start the file
	$objExcelWriter->xlsBOF();
	// these will be used for keeping things in order.
	$col = 0;
	$row = 0;
	// This tells us that we are on the first row
	$first = true;
	$str1 = "Registration Source^^^Total Registration###";
	
	 $keys= array_keys($sourcedata[0]);
	 
	for ($i=0;$i<count($sourcedata[0]);$i++)
	{
		if($keys[$i]=='tot_cnt_api')
		{
			$str1.="API";
		}
		else if($keys[$i]=='tot_cnt_gadget')
		{
			$str1.="Gadget";
		}
		else if($keys[$i]=='tot_cnt_facebook')
		{
			$str1.="Facebook";
		}
		else if($keys[$i]=='tot_cnt_website')
		{
			$str1.="Website";
		}
		
		if($sourcedata[0][$keys[$i]]>0)
			$str1.="^^^".$sourcedata[0][$keys[$i]]."###";
		else 
			$str1.="^^^0###";		
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