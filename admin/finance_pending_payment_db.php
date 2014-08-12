<?php
	//Code to delete selected record.
	if (isset($_POST["btncancel"]))
	{	
		$objvalidation = new validation();

		$objvalidation->addValidation("txtpayment_cancel_remark", "Cancel Payment Remark", "req");
		
		if($objvalidation->validate())
		{
			//Code to cancel selected record.
			if (trim($mode) == CANCEL)
			{
				if (count($_POST['client_payment_id']) == 0)
				{
					$msg->sendMsg("finance_pending_payments.php","Pending Payment ",9);
					exit();
				}
				else
				{
					$objFinancePendingPayment->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
					$objFinancePendingPayment->checkedids = $_POST['client_payment_id'];
					$objFinancePendingPayment->payment_cancel_remark = $_POST['txtpayment_cancel_remark'];
					$objFinancePendingPayment->cancelPayment();
					
					$msg->sendMsg("finance_pending_payments.php","Payment ",79);
					exit();			
				}
			}
		}
	}
?>