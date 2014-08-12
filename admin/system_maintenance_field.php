<?php

	$objSystemMaintenance->site_config_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnsite_config_id"],"")));

	$objSystemMaintenance->site_config_isonline = $cmn->setVal(trim($cmn->readValue($_POST["rdosite_config_isonline"],"")));
	
	$objSystemMaintenance->site_config_offline_message = $cmn->setVal(trim($cmn->readValue($_POST["txtsite_config_offline_message"],"")));
	
?>