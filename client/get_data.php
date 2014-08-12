<?php
require_once 'include/general_includes.php';
$objClient = new client();
$objAPI = new api();



// set output header
	header("Content-type: text/xml");
	
	$api_version = "1.0";
	$api_key = "";
 	$state_name = '';
	$state_code = "";
	$reg_source = ""; 
	$regdateTo="";
	$regdateFrom="";
	$page=1;
	$per_page_rec=500;
	$txtsearchname = "";	
	$dateformate =0;
	if(isset($_REQUEST["api_key"]))
		$api_key = trim($_REQUEST['api_key']);
	if(isset($_REQUEST["state_name"]))
		$state_name = trim($_REQUEST['state_name']);
	if(isset($_REQUEST["state_code"]) && $_REQUEST['state_code']!='0')
		$state_code = trim($_REQUEST['state_code']);	
	if(isset($_REQUEST["reg_source"]) && $_REQUEST["reg_source"]!='0')
		$reg_source = trim($_REQUEST['reg_source']);	
	if(isset($_REQUEST["regdateTo"]))
		$regdateTo = trim($_REQUEST['regdateTo']);	
	if(isset($_REQUEST["regdateFrom"]))
		$regdateFrom = trim($_REQUEST['regdateFrom']);			
	if(isset($_REQUEST['page']))
		$page = trim($_REQUEST['page']);
	if(isset($_REQUEST["per_page_rec"]))
		$per_page_rec = trim($_REQUEST['per_page_rec']);
	if(isset($_REQUEST['searchname']))	
	$searchname = $_REQUEST['searchname'];
	//$ref
$referrer = "";
if(!empty($_SERVER['HTTP_REFERER']))
		$referrer = trim($_SERVER['HTTP_REFERER']);
if(!empty($_REQUEST["HTTP_REFFERER"]) && $referrer == "")
		$referrer = trim($_REQUEST['HTTP_REFFERER']);
 	
//fetch client id on bases of api key		
$client_id=$objClient->fetchclientidapi($api_key);
if($client_id>0)
{$condition='';
	$fields = $objAPI->clientfield($client_id);
	$aFields=$objAPI->clientfieldwihtouthearder($client_id);
	//fetch all voter details
	if(isset($_REQUEST['searchname']))
{
	$searchname = $_REQUEST['searchname'];
	if (trim($_REQUEST['searchname'])!="")
	{
		$condition .= " and voter_reg_source like '%".$searchname."%' or ";
		$condition .= " voter_zipcode like '%".$searchname."%' or ";
		$condition .= " voter_email like '%".$searchname."%' or ";
		$condition .= " state_name like '%".$searchname."%' or ";
		for($i=0;$i<count($aFields);$i++) { 
	
		$condition .= 'field_'.$aFields[$i]['field_id']." like '%".$searchname."%'";
		if($i<count($aFields)-1)
			$condition .=" || ";
		}
}	}
	
	if($state_name!='')
	$condition .=" and state_name like '%".trim($state_name)."%'";
	if($state_code!='')
	$condition .=" and state_code='".trim($state_code)."'";
	if($reg_source!='')
	$condition .=" and voter_reg_source like '%".trim($reg_source)."%'";
	if($regdateFrom!='' && $regdateTo=='')
	{
		$date=date("Y-m-d",strtotime($regdateFrom));
		if($date=="1970-01-01")
			$dateformate=1;
		else
			$condition .= " and voting_date>='".$date."'";
	}
	else if($regdateTo!='' && $regdateFrom=='')
	{
		$date=date("Y-m-d",strtotime($regdateTo));
		if($date=="1970-01-01")
			$dateformate=1;
		else	
			$condition .= " and voting_date<= '".$date."'";
	}
	else if($regdateTo!='' && $regdateFrom!='')
	{
		$date=date("Y-m-d",strtotime($regdateFrom));
		$date1=date("Y-m-d",strtotime($regdateTo));
		if($date=="1970-01-01" || $date1=="1970-01-01")
			$dateformate=1;
		else
			$condition .= " and voting_date >= '".$regdateFrom."' and  voting_date<= '".$regdateTo."'";
	}
	if($page>0)
	{
		$start=(($page*$per_page_rec)-$per_page_rec);
		if($per_page_rec>0 && $per_page_rec<($start+500))
			$endlimit=$per_page_rec;
		else
			$endlimit=500;
		$limit = " limit ".$start.", ".$endlimit;
	}
	//$condition .=" and voter_reg_source like '%Gadget%'";
	//echo $condition;
	$voterdetaildata = $objAPI->voterdetail($client_id,$condition,$limit);
	if(isset($voterdetaildata['voterdata']) && count($voterdetaildata['voterdata'])>0 )
	$voterdetail=$voterdetaildata['voterdata'];
	else
		$voterdetail=array();
	
	//
	$fields_string='';
	foreach($_REQUEST as $key=>$value) { if($value !=''){$fields_string .= $key.'='.$value.'&';} }
	$data=$objAPI->insertentry($referrer,$fields_string,$client_id);
}
	//XML generation
	$doc = new DOMDocument();
	$doc->formatOutput = true;
	$EIResponse = $doc->createElement("EIResponse");
	$doc->appendChild($EIResponse);
	if($dateformate==1)
	{
		$Error = $doc->createElement("Error");
		$Error->appendChild($doc->createTextNode("Date Format is incorrect."));
		$EIResponse->appendChild($Error);
		echo $doc->saveXML();
		exit;
	}
	if(isset($voterdetaildata['voterdata']))
	{
		$Ver = $doc->createElement("Ver");
		$Ver->appendChild($doc->createTextNode($api_version));
		$EIResponse->appendChild($Ver);
		$nototaldata = $doc->createElement("nototaldata");
		$nototaldata->appendChild($doc->createTextNode($voterdetaildata['noofrecord']));
		$EIResponse->appendChild($nototaldata);
		$per_page_recn = $doc->createElement("per_page_rec");
		$per_page_recn->appendChild($doc->createTextNode($per_page_rec));
		$EIResponse->appendChild($per_page_recn);
		$pagen = $doc->createElement("page");
		$pagen->appendChild($doc->createTextNode($page));
		$EIResponse->appendChild($pagen);
	}
	if(empty($api_key))
	{
		$Error = $doc->createElement("Error");
		$Error->appendChild($doc->createTextNode("Required parameter missing: api_key"));
		$EIResponse->appendChild($Error);
		echo $doc->saveXML();
		exit;
	}
	else{
if($client_id>0)
{
	if(count($voterdetail)>0)
	{
	$captionlist = $doc->createElement("captionlist");
	for($y=0;$y<count($fields);$y++)
        {
			$fieldcap = $objAPI->stringreplace($fields[$y]['field_caption']);
			$capdata = $doc->createElement($fieldcap);
			for($a=0;$a<count($fields[$y]['sub']);$a++)
			{
				$fieldcap = $objAPI->stringreplace($fields[$y]['sub'][$a]['field_caption']);
				$capdata1 = $doc->createElement($fieldcap);
				$val= $fields[$y]['sub'][$a]['field_caption']; 
				$capdata1->appendChild($doc->createTextNode($val));
				$capdata->appendChild($capdata1);
			}
			$captionlist->appendChild($capdata);
		}
	$EIResponse->appendChild($captionlist);
	// if either of API key or method is missing in request then give error
	//Start voter detail 
	$VoterList = $doc->createElement("VoterList");
	for($i=0;$i<count($voterdetail);$i++)
	{	
		//start registration node
		$Registrant = $doc->createElement("Registrant");
		//searching fields
				$fieldcap = $objAPI->stringreplace('emailid');
				$val= $voterdetail[$i]['voter_email']; 
				$regidata2 = $doc->createElement($fieldcap);
				$regidata2->appendChild($doc->createTextNode($val));
				$Registrant->appendChild($regidata2);
	
				$fieldcap = $objAPI->stringreplace('state_name');
				$val= $voterdetail[$i]['state_name']; 
				$regidata2 = $doc->createElement($fieldcap);
				$regidata2->appendChild($doc->createTextNode($val));
				$Registrant->appendChild($regidata2);
				
				$fieldcap = $objAPI->stringreplace('zipcode');
				$val= $voterdetail[$i]['voter_zipcode']; 
				$regidata2 = $doc->createElement($fieldcap);
				$regidata2->appendChild($doc->createTextNode($val));
				$Registrant->appendChild($regidata2);
				
				$fieldcap = $objAPI->stringreplace('voting_date');
				$val= $voterdetail[$i]['voting_date']; 
				$regidata2 = $doc->createElement($fieldcap);
				$regidata2->appendChild($doc->createTextNode($val));
				$Registrant->appendChild($regidata2);
				
				$fieldcap = $objAPI->stringreplace('registration_source');
				$val= $voterdetail[$i]['voter_reg_source']; 
				$regidata2 = $doc->createElement($fieldcap);
				$regidata2->appendChild($doc->createTextNode($val));
				$Registrant->appendChild($regidata2);
		//	
        for($y=0;$y<count($fields);$y++)
        { 
			//Main header
			$fieldcap = $objAPI->stringreplace($fields[$y]['field_caption']);
			$regidata = $doc->createElement($fieldcap);
			
			for($a=0;$a<count($fields[$y]['sub']);$a++)
			{
				//sub field nodes
				$fieldcap = $objAPI->stringreplace($fields[$y]['sub'][$a]['field_caption']);
				$val= $voterdetail[$i][$fields[$y]['sub'][$a]['field_id']]; 
				$regidata1 = $doc->createElement($fieldcap);
				$regidata1->appendChild($doc->createTextNode($val));
				$regidata->appendChild($regidata1);
			}
			$Registrant->appendChild($regidata);
		}
		$VoterList->appendChild($Registrant);
	}
	}
	else
{
	$Norecord = $doc->createElement("Norecord");
	$Norecord->appendChild($doc->createTextNode("No record Found."));
	$EIResponse->appendChild($Norecord);
	echo $doc->saveXML();
	exit;
}
}
else
{
	$Error = $doc->createElement("Error");
	$Error->appendChild($doc->createTextNode("Chek your API Key: API Key is incorrect."));
	$EIResponse->appendChild($Error);
	echo $doc->saveXML();
	exit;
}
}
	$EIResponse->appendChild($VoterList);
	echo $doc->saveXML();
?>