<?php
class finance_detail extends common
{
	
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	
	//Function to retrieve recordset of table
	function fetchRecordSetNew($id="",$condition="",$order="entry_payment_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and entry_payment_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{	
			$ordval = explode(" ",$order);
			if($ordval[0] == "user_firstname")
			{
				$order = " concat(ur.user_firstname,' ',ur.user_lastname) ".$ordval[1];
			}
			$order = " order by " . $order;
		}
		$strquery = "SELECT distinct(ep.entry_payment_id),ep.transaction_id,ep.payment_description,ep.payment_iscancel,en.payment_status,en.entry_id,en.contest_id FROM ".DB_PREFIX."entry en, ".DB_PREFIX."entry_payment ep, ".DB_PREFIX."contest ct, ".DB_PREFIX."payment_type p,".DB_PREFIX."user ur, ".DB_PREFIX."client cl WHERE 1 = 1 AND ep.entry_id=en.entry_id AND ep.contest_id=ct.contest_id AND ep.payment_type_id=p.payment_type_id AND ur.client_id=cl.client_id AND ur.user_id=ep.user_id AND ep.client_id=cl.client_id ".$condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchAllPaymentDetails($entry_payment_id)
	{
		$sQuery = "SELECT ur.user_firstname,ur.user_lastname,ur.user_email,ep.amount,ep.payment_date,p.payment_type,ct.contest_title,en.payment_status,ep.payment_iscancel,en.entry_date,ep.transaction_id,ep.entry_payment_id FROM ".DB_PREFIX."user ur, ".DB_PREFIX."client cl, ".DB_PREFIX."entry_payment ep, ".DB_PREFIX."contest ct, ".DB_PREFIX."payment_type p,".DB_PREFIX."entry en WHERE 1 = 1 AND ep.entry_payment_id='".$entry_payment_id."' AND ep.entry_id=en.entry_id AND ep.contest_id=ct.contest_id AND ep.payment_type_id=p.payment_type_id AND ur.user_id=ep.user_id AND ur.client_id = cl.client_id AND ep.client_id=cl.client_id";
		$rs  =  $this->runquery($sQuery);
		$res = mysql_fetch_assoc($rs);
		
		return $res;
	}
	
	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSetNew($id, $condition);

		if($artf_entry= mysql_fetch_array($rs))
		{	
			$this->entry_payment_id = $artf_entry["entry_payment_id"];
			$this->entry_id = $artf_entry["entry_id"];
			$this->contest_id = $artf_entry["contest_id"];
			$this->transaction_id = $artf_entry["transaction_id"];
			$this->payment_description = $artf_entry["payment_description"];
			$this->payment_iscancel = $artf_entry["payment_iscancel"];
			$this->payment_status = $artf_entry["payment_status"];
		}
	}
	
	function update()
	{
		$strquery="UPDATE ".DB_PREFIX."entry SET 
					payment_status='".$this->payment_status."', 
					status_date='".$this->updatedDate."',
					entry_status='".$this->entry_status."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE entry_id=".$this->entry_id;
		
		mysql_query($strquery) or die(mysql_error());
	
		$strquery="UPDATE ".DB_PREFIX."entry_payment SET 
					transaction_id='".$this->transaction_id."', 
					payment_description='".$this->payment_description."', 
					payment_iscancel='".$this->payment_iscancel."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE entry_payment_id=".$this->entry_payment_id;
		
		return mysql_query($strquery) or die(mysql_error());
	}

}
?>