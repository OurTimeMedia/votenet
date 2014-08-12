<?php
if (isset($_POST["btndelete"]))
{
	//Code to delete selected record.
	if (trim($mode) == DELETE)
	{
		if (count($_POST['rid']) == 0)
		{
			$msg->sendMsg("registrants_list.php","Registrant ",9);
			exit();
		}
		else
		{	
			$objRegistrant->checkedids = $objEncDec->decrypt($_POST['rid']);

			$objRegistrant->delete();
			$msg->sendMsg("registrants_list.php","Registrant ",5);
			exit();			
		}
	}
}
?>