<?php
	if ( isset($_REQUEST['btnsave']))
	{	
		$client_payment_id = intval($_REQUEST["hdnclient_payment_id"]);
		$objvalidation = new validation();
		$objvalidation->addValidation("selclient_id", "Client", "req");
		$objvalidation->addValidation("selclient_id", "Client","selone");
		$objvalidation->addValidation("txtamount", "Amount", "req");
		$objvalidation->addValidation("txtamount", "Amount", "float");
		$objvalidation->addValidation("txtamount", "Amount", "greaterthan", "", 0);
		//$objvalidation->addValidation("txtpayment_type", "Payment Type", "req");
	$objvalidation->addValidation("selpayment_type_id", "Payment Type", "req");
	$objvalidation->addValidation("selpayment_type_id", "Payment Type","selone");
		$aDfPayments = explode(",",$sPayments);
		
		/*if(!in_array($_POST["txtpayment_type"],$aDfPayments))
		{
			$objvalidation->addValidation("txtpayment_type", "Payment Type", "inarr");
		}*/
		
		//$objvalidation->addValidation("txtpayment_description", "Payment Description", "req");
	//echo $_POST['hdnmode'];
		if($objvalidation->validate())
		{
			//Code to assign value of control to all property of object.
			include_once SERVER_ADMIN_ROOT."finance_make_payment_field.php";	
			//Code to edit record.
			
			if (trim($_POST['hdnmode']) == 'add')
			{
				$objFinanceMakePayment->financeMakePayment();
				$msg->sendMsg("finance_all_payments.php","Payment ",3);
				exit();
			}
			
			if (trim($_POST['hdnmode']) == 'edit')
			{	
				$objFinanceMakePayment->financeUpdatePayment();
				$objFinanceMakePayment->setAllValues($objFinanceMakePayment->client_payment_id);
				
				$msg->sendMsg("finance_all_payments.php","Payment ",3);
				exit();
			}
		}
	}
?>