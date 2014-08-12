<?php
	require_once 'include/general-includes.php';
	//ALTER TABLE `ei_demo` ADD `request_for` VARCHAR( 10 ) NOT NULL DEFAULT 'demo'
	
	function validEmail($email)
	{
		$isValid = true;
		$atIndex = strrpos($email, "@");
	   
		if (is_bool($atIndex) && !$atIndex)
		{
		  $isValid = false;
		}
		else
		{
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
		  
			if ($localLen < 1 || $localLen > 64)
			{
			 // local part length exceeded
			 $isValid = false;
			}
			else if ($domainLen < 1 || $domainLen > 255)
			{
			 // domain part length exceeded
			 $isValid = false;
			}
			else if ($local[0] == '.' || $local[$localLen-1] == '.')
			{
			 // local part starts or ends with '.'
			 $isValid = false;
			}
			else if (preg_match('/\\.\\./', $local))
			{
			 // local part has two consecutive dots
			 $isValid = false;
			}
			else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
			{
			 // character not valid in domain part
			 $isValid = false;
			}
			else if (preg_match('/\\.\\./', $domain))
			{
			 // domain part has two consecutive dots
			 $isValid = false;
			}
			else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
			{
			 // character not valid in local part unless 
			 // local part is quoted
			 if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
			 {
				$isValid = false;
			 }
			}
		}
		
		return $isValid;
	}
		
	if(isset($_REQUEST['mode']) and $_REQUEST['mode'] == 'showVideo')
	{
		$first_name		= $cmn->getval(trim($cmn->read_value($_POST['first_name_video'],'')));
		$last_name		= $cmn->getval(trim($cmn->read_value($_POST['last_name_video'],'')));
		$organization	= $cmn->getval(trim($cmn->read_value($_POST['organization_video'],'')));
		$email			= $cmn->getval(trim($cmn->read_value($_POST['email_video'],'')));
		
		$errors			= array();
		$errors['message']	= '';
		
		if(trim($first_name) == '')
		{
			$errors['first_name_video']	= 'yes';
		}
		
		if(trim($last_name) == '')
		{
			$errors['last_name_video']	= 'yes';
		}
		
		if(trim($organization) == '')
		{
			$errors['organization_video']	= 'yes';
		}
		
		if(trim($email) == '')
		{
			$errors['email_video']	= 'yes';
		}
		
		if(trim($email) != '' and !validEmail($email))
		{
			$errors['email_video']	= 'yes';
		}
		
		if(count($errors) <= 1)
		{
			require_once ADMIN_PANEL_PATH.'class/demo.class.php';
			
			//create object of main entity...
			$obj = new demo();
	
			$obj->first_name	= $first_name;
			$obj->last_name		= $last_name;
			$obj->organization	= $organization;
			$obj->email			= $email;
			$obj->request_for	= 'video';
			
			//Code to add record.
			$obj->add();
		
			$strsubject = 'Election Impact Voter Registration Software.';

			$arcontact_replace = array(
										'##admin_name##'
										, '##first_name##'
										, '##last_name##'
										, '##organization##'
										, '##email##'
									);

			$arcontact_replace_with = array(
											$cmn->getval($objsite_config->admin_name)
											, $first_name
											, $last_name
											, $organization
											, $email
										);
		
			$strmessage = $cmn->get_file_content('template/video-template.html', $arcontact_replace, $arcontact_replace_with);
			
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
										
			$cussubject	= 'Election Impact Voter Registration Software.';
			$cusmessage	= $cmn->get_file_content('template/video-customer-template.html', $arcontact_replace, $arcontact_replace_with);
			
			$cmn->sendTransactionalMail($email, $cussubject, $cusmessage);
			
			//$cmn->send_mail($email, $cussubject, $cusmessage, $first_name.' '.$last_name , $cmn->getval($objsite_config->from_email), $cmn->getval($objsite_config->from_name));
			
			$errors['message']	= 'Thank you for contacting us about online voter registration software demo. An Election Impact sales consultant will follow-up with you shortly. You can also view video of our software <a href="#" onclick="document.getElementById(\'mask\').style.display=\'none\';document.getElementById(\'login-box\').style.display=\'none\';showvideo();">here</a>.';
		}
		
		echo json_encode($errors);
	}
	elseif(isset($_REQUEST['email']) and !isset($_REQUEST['mode']))
	{
		$first_name		= $cmn->getval(trim($cmn->read_value($_POST['first_name'],'')));
		$last_name		= $cmn->getval(trim($cmn->read_value($_POST['last_name'],'')));
		$organization	= $cmn->getval(trim($cmn->read_value($_POST['organization'],'')));
		$email			= $cmn->getval(trim($cmn->read_value($_POST['email'],'')));
		
		$errors			= array();
		$errors['message']	= '';
		
		if(trim($first_name) == '')
		{
			$errors['first_name']	= 'yes';
		}
		
		if(trim($last_name) == '')
		{
			$errors['last_name']	= 'yes';
		}
		
		if(trim($organization) == '')
		{
			$errors['organization']	= 'yes';
		}
		
		if(trim($email) == '')
		{
			$errors['email']	= 'yes';
		}
		
		if(trim($email) != '' and !validEmail($email))
		{
			$errors['email']	= 'yes';
		}
		
		if(count($errors) <= 1)
		{
			require_once ADMIN_PANEL_PATH.'class/demo.class.php';
			
			//create object of main entity...
			$obj = new demo();
	
			$obj->first_name	= $first_name;
			$obj->last_name		= $last_name;
			$obj->organization	= $organization;
			$obj->email			= $email;
			
			$obj->request_for			= 'demo';
		
			//Code to add record.
			$obj->add();
			
			$strsubject = 'Election Impact Voter Registration Software.';

			$arcontact_replace = array(
										'##admin_name##'
										, '##first_name##'
										, '##last_name##'
										, '##organization##'
										, '##email##'
									);

			$arcontact_replace_with = array(
											$cmn->getval($objsite_config->admin_name)
											, $first_name
											, $last_name
											, $organization
											, $email
										);
		
			$strmessage = $cmn->get_file_content('template/demo-template.html', $arcontact_replace, $arcontact_replace_with);
			
			$to = 'salesconsultant@votenet.com';
			$cc = 'mtuteur@votenet.com; spurohit@votenet.com';
			$bcc = 'pranav@outsourcing2india.com';
			
			$cmn->sendTransactionalMailWithCcBcc($to, $strsubject, $strmessage, $cc, $bcc);
			
			//$cmn->send_mail($objsite_config->admin_email, $strsubject, $strmessage, $cmn->getval($objsite_config->admin_name), $cmn->getval($objsite_config->from_email), $cmn->getval($objsite_config->from_name), $cc, '', $bcc);
			
			$arcontact_replace = array(
											'##first_name##'
											, '##last_name##'
											, '##link##'
										);
			$arcontact_replace_with = array(
											$first_name
											, $last_name
											, 'https://demo.electionimpact.com/'
										);
										
			$cussubject	= 'Election Impact Voter Registration Software.';
			$cusmessage	= $cmn->get_file_content('template/demo-customer-template.html', $arcontact_replace, $arcontact_replace_with);
			
			$cmn->sendTransactionalMail($email, $cussubject, $cusmessage);
			
			//$cmn->send_mail($email, $cussubject, $cusmessage, $first_name.' '.$last_name , $cmn->getval($objsite_config->from_email), $cmn->getval($objsite_config->from_name));
			
			$errors['message']	= 'Thank you for contacting us about online voter registration software demo. An Election Impact sales consultant will follow-up with you shortly. You can also view a demo of our software <a target="_blank" href="https://demo.electionimpact.com/" onclick="document.getElementById(\'mask\').style.display=\'none\';document.getElementById(\'login-box\').style.display=\'none\';">here</a>.';
		}
		
		echo json_encode($errors);
	}