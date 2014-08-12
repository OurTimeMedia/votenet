<?php 
	header('Content-Type: application/x-msexcel; name=regi_source.xls');
	header('Content-Disposition: inline;filename=regi_source.xls');
	header("Content-Transfer-Encoding: binary ");
	require_once 'include/general_includes.php';
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
 $objTopClient = new topclientreport();
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
	
$sourcedata=$objTopClient->topresourcedetail($frmdate,$todate);
asort($sourcedata);

	$objExcelWriter = new excelwriter();
	// start the file
	$objExcelWriter->xlsBOF();
	// these will be used for keeping things in order.
	$col = 0;
	$row = 0;
	// This tells us that we are on the first row
	$first = true;
	$str1 = "Source^^^Total Registration###";
	$keys= array_keys($sourcedata[0]);
		if(count($sourcedata)>0 && is_array($sourcedata) && $sourcedata[0][$keys[0]]!=''){
		 
	for ($i=0;$i<count($sourcedata[0]);$i++)
	{
		 if($keys[$i]=='tot_cnt_api')
		  {
			$resource="API";
		  }
		  else if($keys[$i]=='tot_cnt_gadget')
		  {
			$resource="Gadget";
		  }
		 else if($keys[$i]=='tot_cnt_facebook')
		  {
			$resource="Facebook";
		  }
		  else if($keys[$i]=='tot_cnt_website')
		  {
			$resource="Website";
		  }
											  
										
		 $str1.= $resource;
		$str1.="^^^".$cmn->readValueDetail($sourcedata[0][$keys[$i]])."###";
	//echo $str1;exit;
	}}
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