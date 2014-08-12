<?php
class client_payment extends client
{

	var $client_id;
	var $amount;
	var $plan_id;
	var $payment_date;
	var $payment_type_id;
	var $payment_description;
	var $transaction_type;
	var $transaction_id;
	var $cc_type;
	var $cc_number;
	var $cc_expiry;
	var $cc_expiry_month;
	var $cc_expiry_year;
	var $cc_cvv_no;
	var $bill_name;
	var $bill_address1;
	var $bill_address2;
	var $bill_city;
	var $bill_state;
	var $bill_country_id;
	var $payment_iscancel;
	var $payment_cancel_remark;
	var $pagingType;
	
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;

	var $checkedids;
	var $uncheckedids;
	var $approve_terms_cond;
	
	function client_payment()
	{
		$this->contest_id = 0;
		$this->client_id = 0;
		$this->amount = 0;
		$this->plan_id = 0;
		$this->payment_date = "0000-00-00 00:00:00";
		$this->payment_type_id = 0;
		$this->payment_description = "";
		$this->transaction_type = 1;
		$this->transaction_id = 0;
		$this->cc_type = "";
		$this->cc_number = "";
		$this->cc_expiry = "";
		$this->cc_expiry_month = 0;
		$this->cc_expiry_year = 0;
		$this->cc_cvv_no = "";
		$this->bill_name = "";
		$this->bill_address1 = "";
		$this->bill_address2 = "";
		$this->bill_city = "";
		$this->bill_state = "";
		$this->bill_country_id = 0;
		$this->payment_iscancel = 0;
		$this->payment_cancel_remark = "";
		$this->approve_terms_cond = 0;
		$this->created_by = 1;
		$this->updated_by = 1;
	}
	
	function addPaymentDetail()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."client_payment 
					(client_id, amount, plan_id, payment_date, payment_type_id, payment_description, transaction_type, transaction_id, cc_type, cc_number, cc_expiry, cc_cvv_no, approve_terms_cond, bill_name, bill_address1, bill_address2, bill_city, bill_state, bill_country_id,bill_zipcode, payment_iscancel, payment_cancel_remark, created_by, created_date, updated_by, updated_date) 
		 	 values('".$this->client_id."','".$this->amount."','".$this->plan_id."','".currentScriptDate()."','".$this->payment_type_id."','".$this->payment_description."','".$this->transaction_type."','".$this->transaction_id."','".$this->cc_type."','".$this->cc_number."','".$this->cc_expiry."','".$this->cc_cvv_no."', '".$this->approve_terms_cond."','".$this->bill_name."','".$this->bill_address1."','".$this->bill_address2."','".$this->bill_city."','".$this->bill_state."','".$this->bill_country_id."','".$this->bill_zipcode."','".$this->payment_iscancel."','".$this->payment_cancel_remark."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			//echo $strQuery;
			mysql_query($strQuery) or die(mysql_error());
	}
	
	function plancharges()
	{
		$sql="select * from ".DB_PREFIX."plan where plan_id=".$this->plan_id;
		$res=mysql_query($sql);
		$data=mysql_fetch_assoc($res);

		$this->amount=$data['plan_amount'];
		$this->plan_id=$data['plan_id'];
		
		return 1;
	}
	
}
?>