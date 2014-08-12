<?php
class finance_pending_payment extends common
{
	//Property
	var $checkedids;
	var $updated_by;
	var $payment_cancel_remark;
	var $pagingType;
	
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="payment_date")
	{
		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		 $strquery = "SELECT *,DATEDIFF(expiry_date,curdate()) as pending from ".DB_PREFIX."client_payment cp 
			left join ".DB_PREFIX."client c on c.client_id=cp.client_id
			left join ".DB_PREFIX."user u on u.client_id=cp.client_id
			left join ".DB_PREFIX."plan p on cp.plan_id=p.plan_id
		where payment_status='0' ".$condition." group by cp.client_payment_id" . $order;
		
		// echo $strquery;
		
		$rs=mysql_query($strquery);
		return $rs;
	}

	function cancelPayment()
	{
		$strquery="UPDATE ".DB_PREFIX."client_payment SET 
					payment_status='2', 
					payment_cancel_remark = '".$this->payment_cancel_remark."',
					payment_date = '".currentScriptDate()."',
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE client_payment_id='".$this->checkedids."'";
		
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>