<?php
	$objClientAdmin->firstName = $cmn->setVal(trim($cmn->readValue($_POST["firstName"],"")));
	$objClientAdmin->lastName = $cmn->setVal(trim($cmn->readValue($_POST["lastName"],"")));
	$objClientAdmin->creditCardType = $cmn->setVal(trim($cmn->readValue($_POST["creditCardType"],"")));
	$objClientAdmin->creditCardNumber = $cmn->setVal(trim($cmn->readValue($_POST["creditCardNumber"],"")));
	$objClientAdmin->expDateMonth = $cmn->setVal(trim($cmn->readValue($_POST["expDateMonth"],"")));
	$objClientAdmin->expDateYear = $cmn->setVal(trim($cmn->readValue($_POST["expDateYear"],"")));
	$objClientAdmin->cvv2Number = $cmn->setVal(trim($cmn->readValue($_POST["cvv2Number"],"")));
	$objClientAdmin->address1 = $cmn->setVal(trim($cmn->readValue($_POST["address1"],"")));
	$objClientAdmin->address2 = $cmn->setVal(trim($cmn->readValue($_POST["address2"],"")));
	$objClientAdmin->city = $cmn->setVal(trim($cmn->readValue($_POST["city"],"")));
	$objClientAdmin->state = $cmn->setVal(trim($cmn->readValue($_POST["state"],"")));
	$objClientAdmin->zip = $cmn->setVal(trim($cmn->readValue($_POST["zip"],"")));
	$objClientAdmin->amount = $cmn->setVal(trim($cmn->readValue($_POST["amount"],""))); 
?>