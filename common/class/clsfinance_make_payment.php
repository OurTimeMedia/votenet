<?php
class finance_make_payment extends common
{
	//Property
	var $client_payment_id;
	var $client_id;
	var $plan_id;
	var $amount;
	var $payment_type_id;
	var $payment_type;
	var $payment_description;
	var $transaction_type;
	var $transaction_id;
	var $cc_type;
	var $cc_number;
	var $cc_expiry;
	var $cc_cvv_no;
	var $bill_name;
	var $bill_address1;
	var $bill_address2;
	var $bill_city;
	var $bill_state;
	var $bill_country_id;
	var $payment_iscancel;
	var $payment_cancel_remark;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	
	//Method
	function finance_make_payment( ) {
		$this->client_payment_id=0;
		$this->client_id=0;
		$this->plan_id=0;
		$this->amount=0.0;
		$this->payment_type_id=0;
		$this->payment_type="";
		$this->payment_description="";
		$this->transaction_type=1;
		$this->transaction_id="";
		$this->cc_type="";
		$this->cc_number="";
		$this->cc_expiry="";
		$this->cc_cvv_no="";
		$this->bill_name="";
		$this->bill_address1="";
		$this->bill_address2="";
		$this->bill_city="";
		$this->bill_state="";
		$this->bill_country_id=0;
		$this->payment_iscancel=0;
		$this->payment_cancel_remark="";
		$this->created_by = 1;
		$this->updated_by = 1;
	}
	
	
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="client_payment_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and client_payment_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."client_payment  WHERE 1=1 " . $condition . $order;
		//echo $strquery;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve recordset of table
	function fetchRecordSetNew($id="",$condition="",$order="client_payment_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and client_payment_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
	 $strquery = "SELECT * FROM ".DB_PREFIX."user ur, ".DB_PREFIX."client cl, ".DB_PREFIX."client_payment cp, ".DB_PREFIX."payment_type p, ".DB_PREFIX."plan cpd  WHERE 1 = 1 AND cp.client_id=cl.client_id AND ur.client_id=cl.client_id  ".$condition . " GROUP BY cp.client_payment_id " . $order;
	 
	 //AND cp.payment_type_id=p.payment_type_id
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchClients($intid = NULL, $stralphabet = NULL,$condition = "",$order = "client_name")
	{
		$arrlist  =  array();
		
		$i  =  0;
		$condition  .= " and ur.client_id = cl.client_id and cl.client_id=cn.client_id ";  
		$and  =  $condition;
		if(!is_null($intid) && trim($intid) !=  "") $and .=  " AND ur.user_id  =  " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet) !=  "")	$and .=  " AND ur.user_id like '" . $stralphabet . "%'";
	 
		$sQuery="select * from ".DB_PREFIX."client 	
		left join ".DB_PREFIX."user on ".DB_PREFIX."user.client_id=".DB_PREFIX."client.client_id
		left join ".DB_PREFIX."plan on ".DB_PREFIX."plan.plan_id=".DB_PREFIX."client.plan_id group by ".DB_PREFIX."client.client_id";
	
		$rs  =  $this->runquery($sQuery);
		while($artf_user =  mysql_fetch_assoc($rs))
		{
			$arrlist[$i]["user_id"]  =  $artf_user["user_id"];
			$arrlist[$i]["client_id"]  =  $artf_user["client_id"];
			$arrlist[$i]["user_type_id"]  =  $artf_user["user_type_id"];
			$arrlist[$i]["user_username"]  =  $artf_user["user_username"];
			$arrlist[$i]["user_firstname"]  =  $artf_user["user_firstname"];
			$arrlist[$i]["user_lastname"]  =  $artf_user["user_lastname"];
			$arrlist[$i]["user_email"]  =  $artf_user["user_email"];
			$i++;
		}
		return $arrlist;
	}
	
	function fetchPaymentTypeId($payment_type)
	{
		$sQuery = "SELECT payment_type_id FROM ".DB_PREFIX."payment_type  WHERE 1 = 1 AND payment_type='".$payment_type."'";
		$rs  =  $this->runquery($sQuery);
		$res = mysql_fetch_assoc($rs);
		return $res['payment_type_id'];
	}
	

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="client_payment_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND client_payment_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND client_payment_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."client_payment WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_payment= mysql_fetch_array($rs))
		{
			$arrlist[$i]["client_payment_id"] = $artf_payment["client_payment_id"];
			$arrlist[$i]["client_id"] = $artf_payment["client_id"];
			
			$arrlist[$i]["amount"] = $artf_payment["amount"];
			
			$arrlist[$i]["payment_type_id"] = $artf_payment["payment_type_id"];
			$arrlist[$i]["payment_description"] = $artf_payment["payment_description"];
			
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_payment= mysql_fetch_array($rs))
		{
			$this->client_payment_id = $artf_payment["client_payment_id"];
			$this->client_id = $artf_payment["client_id"];
			
			$this->amount = $artf_payment["amount"];
			
			$this->payment_type_id = $artf_payment["payment_type_id"];
			$this->payment_description = $artf_payment["payment_description"];
			
		}
	}

	//Function to get particular field value
	function fieldValue($field="client_payment_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}
		
	function fetchClientIDByPlanId($plan_id)
	{
		$sQuery = "SELECT client_id from ".DB_PREFIX."plan WHERE plan_id='".$plan_id."'";
		$rs  =  $this->runquery($sQuery);
		$res = mysql_fetch_assoc($rs);
		return $res;
	}
	
	function fetchPaymentTypes()
	{
		 $sQuery = "SELECT payment_type,payment_type_id FROM ".DB_PREFIX."payment_type  WHERE 1 = 1 order by payment_type_id";
		$rs  =  $this->runquery($sQuery);
		$aPayment = array();
		$i = 0;
		while($artf_payment= mysql_fetch_array($rs))
		{
			$aPayment[$i]["payment_type"] = $artf_payment["payment_type"];
			$aPayment[$i]["payment_type_id"] = $artf_payment["payment_type_id"];
			$i++;
		}
		return $aPayment;
	}
	
	function financeMakePayment()
	{
		$strquery="INSERT INTO ".DB_PREFIX."client_payment 
					
					(client_id,  
						amount, payment_date, 
						payment_status,
						payment_type_id, payment_description,
						created_by, created_date, 
						updated_by, updated_date) 
					
					values('".$this->client_id."',
							
							'".$this->amount."',
							'".currentScriptDate()."',
							'1',
							'".$this->payment_type_id."',
							'".$this->payment_description."',
							'".$this->created_by."',
							'".currentScriptDate()."',
							'".$this->updated_by."',
							'".currentScriptDate()."')";
		
		mysql_query($strquery) or die(mysql_error());
		$this->client_payment_id = mysql_insert_id();
		return mysql_insert_id();
	}
	
	function financeUpdatePayment()
	{
		$strQuery="UPDATE ".DB_PREFIX."client_payment SET
					amount = '".$this->amount."', payment_date = '".currentScriptDate()."',
					payment_type_id = '".$this->payment_type_id."',
					payment_description = '".$this->payment_description."',
					payment_status = '1',
					updated_by = '".$this->updated_by."', updated_date = '".currentScriptDate()."'
				  WHERE client_payment_id = '".$this->client_payment_id."'";
//echo $strQuery;exit;
		mysql_query($strQuery) or die(mysql_error());
	}
}
?>