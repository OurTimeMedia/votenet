<?php 
	defined('PAGE_EXECUTE') or die( 'Restricted access.' );
	if ( isset($_POST['btnsubmit']) ) {
		
		$objvalidation = new validation();		
		
		$objvalidation->add_validation("txtuser_name", "user name", "req");
		$objvalidation->add_validation("txtpassword", "password", "req");
		
		if( $objvalidation->validate() ) {
			$struser_name = $cmn->setval(trim($cmn->read_value($_POST["txtuser_name"],"")));
			$strpassword = $cmn->setval(trim($cmn->read_value($_POST["txtpassword"],"")));		
			if( $cmn->login_admin($struser_name,$strpassword) == 1 ){
				$redirect = 'dashboard.php';
				if ( isset($_SESSION['redirectionto']) && trim($_SESSION['redirectionto']) != '' ) {
					$redirect = trim($_SESSION['redirectionto']);
					$cmn->header_location($redirect);
					exit();
				}
				$msg->send_msg($redirect,"Login",10);
				exit();
			}
			else {
				$msg->send_msg("index.php","Login",1);
				exit();
			}
		}
	}