<?php 
header('Content-Type: application/x-msexcel; name=voterdetail.xls');
header('Content-Disposition: inline;filename=voterdetail.xls');
header("Content-Transfer-Encoding: binary ");
require_once 'include/general_includes.php';
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$objEncDec = new encdec();
$objTopClient = new topclientreport();
$aSelectedFields= $objTopClient->selectedfield(2);
$aFileds = $objTopClient->fetchFields();

if(count($aSelectedFields)>0)
{
	$fields='rpt_reg_id,client_id,voter_email,voter_state_id,voter_zipcode,voting_date,state_name,voter_reg_source,';
	for($i=0;$i<count($aSelectedFields);$i++)
	{
		$fields .="field_".$aSelectedFields[$i]['field_id'].",";
	}
}
else
{
	$fields='rpt_reg_id,client_id,voter_email,voter_state_id,voter_zipcode,voting_date,state_name,voter_reg_source,';	
}

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
$condition ='';
if($frmdate && $todate=='')
{
	$condition .= " and voting_date>=".$frmdate;
}	
else if($todate && $frmdate=='')
{
	$condition .= " and voting_date<= ".$todate;
}	
else if($todate!='' && $frmdate!='')
	$condition .= " and voting_date between '".$frmdate."' and '".$todate."'";
	
if(isset($_REQUEST['txtsearchname']))
{
	if (trim($_REQUEST['txtsearchname'])!="")
	for($i=0;$i<count($aFileds);$i++) { 
		if($i==0)
		$condition .= ' and ';
		$condition .= " voter_reg_source like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' or ";
		$condition .= " voter_zipcode like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' or ";
		$condition .= " voter_email like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' or ";
		$condition .= " state_name like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' or ";
		$condition .= 'field_'.$aFileds[$i]['field_id']." like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'";
		if($i<count($aFileds)-1)
			$condition .=" || ";
		}
}	 

$objTopClient->pagingType ="registantrpt";
$objpaging->strorderby = "voter_email";
$objpaging->strorder = "desc";

if(isset($_REQUEST['resRec']) && $_REQUEST['resRec'] != "")
{
	$recLimit = explode("-",$_REQUEST['resRec']);
	
	$limit = " Limit ".($recLimit[0] - 1).", 10000";
	
	$voterdetail = $objpaging->setPageDetailsSpecial($objTopClient,"voter_registration_report.php",-1,$condition,'','',$limit,$fields);
}	
else
	$voterdetail = $objpaging->setPageDetails($objTopClient,"voter_registration_report.php",-1,$condition,'','','',$fields);
	
$definedColSpan=9;
//print "<pre>";
//print_r($voterdetail);

	
$objExcelWriter = new excelwriter();
// start the file
$objExcelWriter->xlsBOF();
// these will be used for keeping things in order.
$col = 0;
$row = 0;
// This tells us that we are on the first row
$first = true;
$str1 ='Voter Email^^^Voter State^^^Voter Zip Code^^^Voter Registration Date^^^Registration Source^^^';
for($y=0;$y<count($aSelectedFields);$y++)
{ 
	$str1.=$aSelectedFields[$y]['field_caption']."^^^"; 
}
$str1.="###";

if(count($voterdetail)>0)
{
	for ($i=0;$i<count($voterdetail);$i++)
	{
		$str1.=$voterdetail[$i]['voter_email']."^^^".$voterdetail[$i]['state_name']."^^^".$voterdetail[$i]['voter_zipcode']."^^^".$voterdetail[$i]['voting_date']."^^^".$voterdetail[$i]['voter_reg_source']."^^^";
		for($y=0;$y<count($aSelectedFields);$y++)
        {
			$str1.=$voterdetail[$i]['field_'.$aSelectedFields[$y]['field_id']]."^^^";
		}$str1.="###";	
	}

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