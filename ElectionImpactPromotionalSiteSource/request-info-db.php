<?php
	defined('PAGE_EXECUTE') or die( 'Restricted access.' );
	
	if(isset($_POST['Submit'])){
		
		include_once ADMIN_PANEL_PATH . 'class/clsvalidation.php';
		
		$objvalidation = new validation();
		
		$objvalidation->add_validation("first_name", "first name", "req");
		$objvalidation->add_validation("last_name", "last name", "req");
		$objvalidation->add_validation("organization", "organization", "req");
		$objvalidation->add_validation("email", "email", "req");
		$objvalidation->add_validation("email", "email", "email");
		
		if ($objvalidation->validate())
		{
			$title			= $cmn->getval(trim($cmn->read_value($_POST['title'],'')));
			$first_name		= $cmn->getval(trim($cmn->read_value($_POST['first_name'],'')));
			$last_name		= $cmn->getval(trim($cmn->read_value($_POST['last_name'],'')));
			$organization	= $cmn->getval(trim($cmn->read_value($_POST['organization'],'')));
			$email			= $cmn->getval(trim($cmn->read_value($_POST['email'],'')));
			$phone			= $cmn->getval(trim($cmn->read_value($_POST['phone'],'')));
			
			require_once ADMIN_PANEL_PATH.'class/request.class.php';
			
			//create object of main entity...
			$obj = new request();
	
			$obj->title			= $title;
			$obj->first_name	= $first_name;
			$obj->last_name		= $last_name;
			$obj->organization	= $organization;
			$obj->email			= $email;
			$obj->phone			= $phone;

			//Code to add record.
			$obj->add();
			
			//send mail
			include_once ADMIN_PANEL_PATH . 'class/clssite-config.php';
			$objsite_config = new site_config();
			
			$strsubject = 'New request received.';

			$arcontact_replace = array(
										'##admin_name##'
										, '##title##'
										, '##first_name##'
										, '##last_name##'
										, '##organization##'
										, '##email##'
										, '##phone##'
										
									);
			$arcontact_replace_with = array(
											$cmn->getval($objsite_config->admin_name)
											, $title
											, $first_name
											, $last_name
											, $organization
											, $email
											, $phone
										);
																
			$strmessage = $cmn->get_file_content('template/request-info-template.html', $arcontact_replace, $arcontact_replace_with);
			
			$to = 'salesconsultant@votenet.com';
			$cc = 'mtuteur@votenet.com; spurohit@votenet.com';
			$bcc = 'pranav@outsourcing2india.com';
			
			$cmn->sendTransactionalMailWithCcBcc($to, $strsubject, $strmessage, $cc, $bcc);
			
			//$cmn->send_mail($objsite_config->admin_email, $strsubject, $strmessage, $cmn->getval($objsite_config->admin_name), $cmn->getval($objsite_config->from_email), $cmn->getval($objsite_config->from_name), $cc, '', $bcc);
			
			$arcontact_replace = array(
										'##first_name##'
										, '##last_name##'										
									);
			$arcontact_replace_with = array(
											$first_name
											, $last_name
										);
										
			$cussubject	= 'Thank you for your request.';
			$cusmessage	= $cmn->get_file_content('template/request-info-customer-template.html', $arcontact_replace, $arcontact_replace_with);
			
			$cmn->sendTransactionalMail($email, $cussubject, $cusmessage);
			
			//$cmn->send_mail($email, $cussubject, $cusmessage, $first_name.' '.$last_name , $cmn->getval($objsite_config->from_email), $cmn->getval($objsite_config->from_name));
			
			$msg->send_msg(SITE_URL."request-info/","",42);
			
			exit();
			//end send mail
		}
	}