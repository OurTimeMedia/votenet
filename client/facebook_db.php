<?php
if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		$objFBClient->client_id = $clientID;
		$objFBClient->delete();
		$msg->sendMsg("facebook.php","Facebook Application ",5);
		exit();
	}
}
?>