<?php
	require_once 'include/ajax-includes.php';
	require_once 'class/clscustomer.php';
	
	//code to assign primary key to main variable...
	$customer_id = 0;
	if(isset($_REQUEST['customer_id']) && trim($_REQUEST['customer_id'])!='')
		$customer_id = $_REQUEST['customer_id'];

	//create object of main entity...
	$objcustomer = new customer();

	if($customer_id > 0)
		$objcustomer->setallvalues($customer_id);
		
	echo json_encode($objcustomer);
	exit;