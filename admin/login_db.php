<?php 
	if (isset($_POST["btnsubmit"]))
	{
		$objvalidation = new validation();
	
		$objvalidation->addValidation("txtuser_username", "Username", "req");
		$objvalidation->addValidation("txtpassword", "Password", "req");
		$objvalidation->addValidation("txtpassword", "Password", "password");
		
		$_SESSION["LOGIN"]["txtuser_username"] = $cmn->setVal(trim($cmn->readValue($_POST["txtuser_username"],"")));
		$_SESSION["LOGIN"]["txtpassword"] =  $cmn->setVal(trim($cmn->readValue($_POST["txtpassword"],"")));
		
		$user_username = $_SESSION["LOGIN"]["txtuser_username"];
		$pass = $_SESSION["LOGIN"]["txtpassword"];	
		
		$objUser = new user();
		$userId = $objUser->fieldValue("user_id",""," AND user_username='".$user_username."' ");
		$objSecurityBlockUser = new security_block_user();
		$chkUser = $objSecurityBlockUser->fetchAllAsArray("",""," AND user_id='".$userId."' AND client_id=0 ");
		
		$ipAddress = $cmn->getRealIpAddr();
		$objSecurityBlockIP = new security_block_ip();
		$chkIP = $objSecurityBlockIP->fetchAllAsArray("",""," AND ipaddress='".$ipAddress."' AND client_id=0 ");
		
		$loginpage = 1;
		
		if ($objvalidation->validate())
		{
			if(count($chkIP)>0)
			{
				$cmn->addUserLoginHistory("Fail",0,$user_username,$loginpage);
				$msg->sendMsg("index.php","Login",74);
			}
			
			if(count($chkUser)>0)
			{
				$cmn->addUserLoginHistory("Fail",0,$user_username,$loginpage);
				$msg->sendMsg("index.php","Login",75);
			}
			
			$adminloginstatus = $cmn->loginAdmin($user_username,$pass);			
			if($adminloginstatus == "1")
			{
				if (!empty($_SESSION["LOGIN"])) 
				{
					unset($_SESSION["LOGIN"]);	
				}
				$cmn->addUserLoginHistory("Pass",$_SESSION['ELECTION_IMPACT_CLIENT_SESSION_system_admin_user_id'],$user_username,$loginpage);
				$default_menu = $cmn->getFirstAdminMenu($cmn->getSession(SYSTEM_ADMIN_USER_ID));
				if (trim($default_menu) == "")
					$msg->sendMsg($default_menu,"",43);
				else
				{
					$cmn->updateLastLogin($cmn->getSession(SYSTEM_ADMIN_USER_ID));
					$msg->sendMsg($cmn->getFirstAdminMenu($cmn->getSession(SYSTEM_ADMIN_USER_ID)),"Login",10);
				}
			}
			else if($adminloginstatus == 2)
			{
				$cmn->addUserLoginHistory("Fail",0,$user_username,$loginpage);
				$msg->sendMsg("index.php","Login",100);
			}
			else
			{
				$cmn->addUserLoginHistory("Fail",0,$user_username,$loginpage);
				$msg->sendMsg("index.php","Login",1);
			}
		}
	}
?>