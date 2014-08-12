<?php

class finance_daily_cash_sales extends common
{
	var $pagingType;

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
		$strquery = "SELECT distinct(cp.client_payment_id),ur.user_username,ur.user_firstname,ur.user_lastname,ur.user_email,cp.amount,cp.payment_date,cp.transaction_type,cp.transaction_id,p.payment_type,cpd.plan_title, (TO_DAYS('".currentScriptDate()."')-TO_DAYS(ct.register_date)) as pending,ct.client_id, ct.register_date FROM ".DB_PREFIX."user ur, ".DB_PREFIX."client cl, ".DB_PREFIX."client_payment cp, ".DB_PREFIX."client ct, ".DB_PREFIX."payment_type p, ".DB_PREFIX."plan cpd  WHERE 1 = 1 AND cp.client_id=cl.client_id AND ur.client_id=cl.client_id AND cp.client_id=ct.client_id AND cp.payment_type_id=p.payment_type_id AND cpd.plan_id=ct.plan_id AND p.payment_type='Credit Card' AND p.payment_type_id=cp.payment_type_id ".$condition . " GROUP BY cp.client_payment_id  " . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
}
?>