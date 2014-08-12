<?php
	defined('PAGE_EXECUTE') or die( 'Restricted access.' );

	if ( isset($_POST['btnsubmit'])){

		$objvalidation = new validation();

		$objvalidation->add_validation("txtadmin_name", "admin name", "req");
		$objvalidation->add_validation("txtadmin_email", "admin email", "req");
		$objvalidation->add_validation("txtadmin_email", "admin email", "email");
		$objvalidation->add_validation("txtfrom_name", "from name", "req");
		$objvalidation->add_validation("txtfrom_email", "from email", "req");
		$objvalidation->add_validation("txtfrom_email", "from email", "email");
		$objvalidation->add_validation("txtsales_email", "sales email", "email");
		
		/* $objvalidation->add_validation("txtstreet", "street", "req");
		$objvalidation->add_validation("txttown", "town", "req");
		$objvalidation->add_validation("txtstate", "state", "req");
		$objvalidation->add_validation("txtzipcode", "zipcode", "req");
		$objvalidation->add_validation("txtphone", "phone number", "req");
        $objvalidation->add_validation("txtfax", "fax number", "req"); */

		if($objvalidation->validate()){

			//Code to assign value of control to all property of object.
			$objsite_config->site_config_id = (int) $site_config_id;
			$objsite_config->admin_name = $cmn->setval(trim($cmn->read_value($_POST['txtadmin_name'],'')));
			$objsite_config->admin_email = $cmn->setval(trim($cmn->read_value($_POST['txtadmin_email'],'')));
			$objsite_config->from_name = $cmn->setval(trim($cmn->read_value($_POST['txtfrom_name'],'')));
			$objsite_config->from_email = $cmn->setval(trim($cmn->read_value($_POST['txtfrom_email'],'')));
			
			$objsite_config->sales_email	= $cmn->setval(trim($cmn->read_value($_POST['txtsales_email'],'')));
			$objsite_config->Copy			= $cmn->setval(trim($cmn->read_value($_POST['txtCopy'],'')));
			
			$objsite_config->street	= $cmn->setval(trim($cmn->read_value($_POST['txtstreet'],'')));
			$objsite_config->town	= $cmn->setval(trim($cmn->read_value($_POST['txttown'],'')));
			$objsite_config->state	= $cmn->setval(trim($cmn->read_value($_POST['txtstate'],'')));
			$objsite_config->zipcode= $cmn->setval(trim($cmn->read_value($_POST['txtzipcode'],'')));
			$objsite_config->phone	= $cmn->setval(trim($cmn->read_value($_POST['txtphone'],'')));
			$objsite_config->fax	= $cmn->setval(trim($cmn->read_value($_POST['txtfax'],'')));
			
			$objsite_config->facebook_url	= $cmn->setval(trim($cmn->read_value($_POST['facebook_url'],'')));
			$objsite_config->twitter_url	= $cmn->setval(trim($cmn->read_value($_POST['twitter_url'],'')));
			$objsite_config->blog_url		= $cmn->setval(trim($cmn->read_value($_POST['blog_url'],'')));
			
			//Code to edit record
			if ($strmode == 'edit' && intval($site_config_id) > 0)
			{
				$objsite_config->update();
				$msg->send_msg('site-config.php','Site config ',4);
			}

		}
	}
?>