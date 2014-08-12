<?php
$objFinanceMakePayment->client_payment_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnclient_payment_id"],"")));

$objFinanceMakePayment->client_id = $cmn->setVal(trim($cmn->readValue($_POST["selclient_id"],"")));

$objFinanceMakePayment->amount = $cmn->setVal(trim($cmn->readValue($_POST["txtamount"],"")));

$objFinanceMakePayment->payment_type = $cmn->setVal(trim($cmn->readValue($_POST["txtpayment_type"],"")));

$objFinanceMakePayment->payment_description = $cmn->setVal(trim($cmn->readValue($_POST["txtpayment_description"],"")));

$objFinanceMakePayment->payment_type_id = $cmn->setVal(trim($cmn->readValue($_POST["selpayment_type_id"],"0")));

$objFinanceMakePayment->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
$objFinanceMakePayment->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);	
?>