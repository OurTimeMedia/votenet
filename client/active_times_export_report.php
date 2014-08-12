<?php 
	header('Content-Type: application/x-msexcel; name=activetime.xls');
	header('Content-Disposition: inline;filename=activetime.xls');
	header("Content-Transfer-Encoding: binary ");
	require_once 'include/general_includes.php';
$objTopClient = new topclientreport();
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);

$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);
//print_r($_GET);
if(isset($_POST['txtdatefrom']) &&  $_POST['txtdatefrom']!='')
{
	$txtdatefrom=$_POST['txtdatefrom'];
	$fromdate=explode("/",$_POST['txtdatefrom']);
	$frmdate=$fromdate[2]."-".$fromdate[0]."-".$fromdate[1];
}
else
{
	$frmdate="";
	$txtdatefrom='';
}
$ActiveTime=$objTopClient->mostactivetimereport($frmdate,$client_id);
arsort($ActiveTime);
//print_r($ActiveTime);
	$objExcelWriter = new excelwriter();
	// start the file
	$objExcelWriter->xlsBOF();
	// these will be used for keeping things in order.
	$col = 0;
	$row = 0;
	// This tells us that we are on the first row
	$first = true;
	$str1 = "Timings^^^Total Registration###";

	$keys= array_keys($ActiveTime[0]);
	for($i=0;$i<count($ActiveTime[0]);$i++)
	{
		if($keys[$i]!='tot_cnt')
		{
			if($keys[$i]=='cnt_mid_to_7')
			{
				$resource="Midnight To 7AM";
			}
			else if($keys[$i]=='cnt_7_to_10')
			{
				$resource="7AM to 10AM";
			}
			else if($keys[$i]=='cnt_10_to_noon')
			{
				$resource="10AM to Noon";
			}
			else if($keys[$i]=='cnt_noon_to_3')
			{
				$resource="Noon to 3PM";
			}
			else if($keys[$i]=='cnt_3_to_6')
			{
				$resource="3PM to 6PM";
			}
			else if($keys[$i]=='cnt_6_to_mid')
			{
				$resource="6PM to Midnight";
			}
			$str1.= $resource."^^^";
			if($ActiveTime[0][$keys[$i]]>0)
				$str1.= $ActiveTime[0][$keys[$i]];else $str1.=0; 
			 $str1.="###";
		}	 
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