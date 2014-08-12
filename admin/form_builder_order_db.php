<?php 
require_once("include/general_includes.php");

$action = mysql_real_escape_string($_POST['action']); 
$updateRecordsArray = $_POST['recordsArray'];

$objField = new field();
		
if ($action == "updateRecordsListings")
{	
	$listingCounter = 1;
	
	foreach ($updateRecordsArray as $recordIDValue) 
	{		
		$objField->field_id = $recordIDValue;
		$objField->field_order = $listingCounter;
		
		$objField->updateFieldOrder();
				
		$listingCounter = $listingCounter + 1;	
	}
}
?>