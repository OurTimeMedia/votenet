<?php
class client extends common
{
	//Property
	var $user_id;
	var $client_id;
	var $user_type_id;
	var $user_username;
	var $user_password;
	var $user_firstname;
	var $user_lastname;
	var $user_email;
	var $user_company;
	var $user_designation;
	var $user_phone;
	var $user_address1;
	var $user_address2;
	var $user_city;
	var $user_state;
	var $user_country;
	var $user_zipcode;
	var $user_lastlogin;
	var $user_isactive;
	var $user_verification;
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
	var $pagingType;
	
	var $plan_id;
	var $languages;
	var $allow_credit;
	var $register_date;
	var $expiry_date;
	var $bill_name;
	var $bill_address1;
	var $bill_address2;
	var $bill_city;
	var $bill_state;
	var $bill_country_id;
	var $bill_zipcode;

	var $user_oldpassword;
	
	var $checkedids;
	var $uncheckedids;
	
	function client()
	{
		$this->client_id = 0;
		
		$this->plan_id = 0;
		$this->languages = "";
		$this->allow_credit = 1;
		$this->user_isactive = 1;
		
		$this->user_type_id = 3;
		
		$this->user_country = 0;
		
		$this->bill_country_id = 0;
		
		$this->user_lastlogin = '0000-00-00 00:00:00';
		$this->register_date = '0000-00-00 00:00:00';
		$this->expiry_date = '';
		
		$this->cust_currentpassword = "";
		$this->cust_newpassword = "";
		$this->cust_cpassword = "";
		$this->user_verification = "";
	}

	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id = "",$condition = "",$order = "user_id")
	{
		
		$condition  .= " and ".DB_PREFIX."user.client_id = ".DB_PREFIX."client.client_id ";  
		
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and ".DB_PREFIX."user.user_id = ". $id .$condition;
		}
		if($order !=  "" && $order !=   NULL && is_null($order) == false)
		{
			$order  =  " order by " . $order.", user_id desc";
		}
		$sQuery = "SELECT * FROM ".DB_PREFIX."user, ".DB_PREFIX."client WHERE 1 = 1 " . $condition . $order;
		// echo $sQuery;
		$rs  =  $this->runquery($sQuery);
		return $rs;
	}
	
	/**
	 * Function to retrieve records of table in form of two dimensional array
	 * Used in Submission count reports in system admin panel
	 * 
	 */
	function getAllClients()
	{
		
		$arrlist  =  array();
		$i  =  0;
		
		$condition  = " and ".DB_PREFIX."user.client_id = ".DB_PREFIX."client.client_id 
						AND ".DB_PREFIX."user.user_type_id = 3 AND ".DB_PREFIX."user.user_isactive = 1
						";  
				
		$sQuery = "SELECT 	".DB_PREFIX."user.user_id, 
							concat(".DB_PREFIX."user.user_firstname,' ',".DB_PREFIX."user.user_lastname) as username,
							".DB_PREFIX."client.* 
		
					
						FROM ".DB_PREFIX."user , ".DB_PREFIX."client 
						
						WHERE 1 = 1 " . $condition . " ORDER BY username ASC";
		//echo $sQuery; exit;
		$rs  =  $this->runquery($sQuery);
		while($artf_user =  mysql_fetch_assoc($rs))
		{
			foreach ($artf_user as $k => $v)
			{
				
				$arrlist[$i][$k]  =  $v;
			}
		
			
			
			$i++;
		}
		return $arrlist;
		
	}


	function getAllUsers()
	{
		
		$arrlist  =  array();
		$i  =  0;
		
		$condition  = " AND ".DB_PREFIX."user.user_type_id in (3,4) AND ".DB_PREFIX."user.client_id='".$this->client_id."'
						";  
				
		$sQuery = "SELECT 	".DB_PREFIX."user.user_id, 
							concat(".DB_PREFIX."user.user_firstname,' ',".DB_PREFIX."user.user_lastname) as username,
							".DB_PREFIX."user.user_email
							
					
						FROM ".DB_PREFIX."user 
						
						WHERE 1 = 1 " . $condition . " ORDER BY username ASC";
	
		$rs  =  $this->runquery($sQuery);
		while($artf_user =  mysql_fetch_assoc($rs))
		{
			foreach ($artf_user as $k => $v)
			{
				
				$arrlist[$i][$k]  =  $v;
			}
		
			
			
			$i++;
		}
		return $arrlist;
		
	}
	
	function getAllAdmin($con = "")
	{
		
		$arrlist  =  array();
		$i  =  0;
		
		$condition  = " AND ".DB_PREFIX."user.user_type_id IN (1,2)
						".$con;  
				
		$sQuery = "SELECT 	".DB_PREFIX."user.user_id, 
							concat(".DB_PREFIX."user.user_firstname,' ',".DB_PREFIX."user.user_lastname) as username,
							".DB_PREFIX."user.user_email
		
					
						FROM ".DB_PREFIX."user 
						
						WHERE 1 = 1 " . $condition . " ORDER BY user_type_id,username ASC";
		//echo $sQuery; exit;
		$rs  =  $this->runquery($sQuery);
		while($artf_user =  mysql_fetch_assoc($rs))
		{
			foreach ($artf_user as $k => $v)
			{
				
				$arrlist[$i][$k]  =  $v;
			}
		
			
			
			$i++;
		}
		return $arrlist;
		
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid = NULL, $stralphabet = NULL,$condition = "",$order = "user_id")
	{
		$arrlist  =  array();
		$i  =  0;
		$condition  .= " and ".DB_PREFIX."user.client_id = ".DB_PREFIX."client.client_id ";  
		$and  =  $condition;
		if(!is_null($intid) && trim($intid) !=  "") $and .=  " AND ".DB_PREFIX."user.user_id  =  " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet) !=  "")	$and .=  " AND ".DB_PREFIX."user.user_id like '" . $stralphabet . "%'";
		$sQuery = "SELECT * FROM ".DB_PREFIX."user WHERE 1 = 1 " . $and . " ORDER BY ".$order;
		$rs  =  $this->runquery($sQuery);
		while($artf_user =  mysql_fetch_assoc($rs))
		{
			$arrlist[$i]["user_id"]  =  $artf_user["user_id"];
			$arrlist[$i]["client_id"]  =  $artf_user["client_id"];
			$arrlist[$i]["user_type_id"]  =  $artf_user["user_type_id"];
			$arrlist[$i]["user_username"]  =  $artf_user["user_username"];
			$arrlist[$i]["user_password"]  =  $artf_user["user_password"];
			$arrlist[$i]["user_firstname"]  =  $artf_user["user_firstname"];
			$arrlist[$i]["user_lastname"]  =  $artf_user["user_lastname"];
			$arrlist[$i]["user_email"]  =  $artf_user["user_email"];
			$arrlist[$i]["user_company"]  =  $artf_user["user_company"];
			$arrlist[$i]["user_designation"]  =  $artf_user["user_designation"];
			$arrlist[$i]["user_phone"]  =  $artf_user["user_phone"];
			$arrlist[$i]["user_address1"]  =  $artf_user["user_address1"];
			$arrlist[$i]["user_address2"]  =  $artf_user["user_address2"];
			$arrlist[$i]["user_city"]  =  $artf_user["user_city"];
			$arrlist[$i]["user_state"]  =  $artf_user["user_state"];
			$arrlist[$i]["country_id"]  =  $artf_user["country_id"];
			$arrlist[$i]["user_zipcode"]  =  $artf_user["user_zipcode"];
			$arrlist[$i]["user_lastlogin"]  =  $artf_user["user_lastlogin"];
			$arrlist[$i]["user_isactive"]  =  $artf_user["user_isactive"];
			$arrlist[$i]["user_verification"]  =  $artf_user["user_verification"];
			$arrlist[$i]["created_date"]  =  $artf_user["created_date"];
			$arrlist[$i]["created_by"]  =  $artf_user["created_by"];
			$arrlist[$i]["updated_date"]  =  $artf_user["updated_date"];
			$arrlist[$i]["updated_by"]  =  $artf_user["updated_by"];
			
			$arrlist[$i]["languages"]  =  $artf_user["languages"];
			$arrlist[$i]["plan_id"]  =  $artf_user["plan_id"];
			$arrlist[$i]["allow_credit"]  =  $artf_user["allow_credit"];
			$arrlist[$i]["register_date"]  =  $artf_user["register_date"];
			$arrlist[$i]["expiry_date"]  =  $artf_user["expiry_date"];
			$arrlist[$i]["bill_name"]  =  $artf_user["bill_name"];
			$arrlist[$i]["bill_address1"]  =  $artf_user["bill_address1"];
			$arrlist[$i]["bill_address2"]  =  $artf_user["bill_address2"];
			$arrlist[$i]["bill_city"]  =  $artf_user["bill_city"];
			$arrlist[$i]["bill_state"]  =  $artf_user["bill_state"];
			$arrlist[$i]["bill_country_id"]  =  $artf_user["bill_country_id"];
			$arrlist[$i]["bill_zipcode"]  =  $artf_user["bill_zipcode"];
			
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setAllValues($id = "",$condition = "")
	{
		$rs = $this->fetchRecordSet($id, $condition);
	
		if($artf_user =  mysql_fetch_assoc($rs))		
		{
			$this->user_id  =  $artf_user["user_id"];
			$this->client_id  =  $artf_user["client_id"];
			$this->user_type_id  =  $artf_user["user_type_id"];
			$this->user_username  =  $artf_user["user_username"];
			$this->user_password  =  $artf_user["user_password"];
			$this->user_firstname  =  $artf_user["user_firstname"];
			$this->user_lastname  =  $artf_user["user_lastname"];
			$this->user_email  =  $artf_user["user_email"];
			$this->user_company  =  $artf_user["user_company"];
			$this->user_designation  =  $artf_user["user_designation"];
			$this->user_phone  =  $artf_user["user_phone"];
			$this->user_address1  =  $artf_user["user_address1"];
			$this->user_address2  =  $artf_user["user_address2"];
			$this->user_city  =  $artf_user["user_city"];
			$this->user_state  =  $artf_user["user_state"];
			$this->user_country  =  $artf_user["user_country"];
			$this->user_zipcode  =  $artf_user["user_zipcode"];
			$this->user_lastlogin  =  $artf_user["user_lastlogin"];
			$this->user_isactive  =  $artf_user["user_isactive"];
			$this->user_verification  =  $artf_user["user_verification"];
			$this->created_date  =  $artf_user["created_date"];
			$this->created_by  =  $artf_user["created_by"];
			$this->updated_date  =  $artf_user["updated_date"];
			$this->updated_by  =  $artf_user["updated_by"];
			
			$this->languages  =  $artf_user["languages"];
			$this->plan_id  =  $artf_user["plan_id"];
			$this->allow_credit  =  $artf_user["allow_credit"];
			$this->register_date  =  $artf_user["register_date"];
			$this->expiry_date  =  $artf_user["expiry_date"];
			$this->bill_name  =  $artf_user["bill_name"];
			$this->bill_address1 =  $artf_user["bill_address1"];
			$this->bill_address2  =  $artf_user["bill_address2"];
			$this->bill_city =  $artf_user["bill_city"];
			$this->bill_state =  $artf_user["bill_state"];
			$this->bill_country_id =  $artf_user["bill_country_id"];
			$this->bill_zipcode  =  $artf_user["bill_zipcode"];
			
		}
		
	//	echo "<pre>"; print_r($artf_user); exit;
		
	}

	//Function to get particular field value
	function fieldValue($field = "user_id",$id = "",$condition = "",$order = "")
	{
		$rs = $this->fetchRecordSet($id, $condition, $order);
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}

	function addClient()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."client 
					
					(	plan_id, languages, allow_credit, register_date, expiry_date, bill_name,
						bill_address1, bill_address2, bill_city,
						bill_state, bill_country_id, bill_zipcode
					) 
					values(
							'".$this->plan_id."', '".$this->languages."','".$this->allow_credit."', '".currentScriptDate()."', '".$this->expiry_date."',
							'".$this->bill_name."', '".$this->bill_address1."',
							'".$this->bill_address2."','".$this->bill_city."',
							'".$this->bill_state."','".$this->bill_country_id."',
							'".$this->bill_zipcode."')";
		
		$this->runquery($sQuery);
		$this->client_id  =  mysql_insert_id();
		
		$sQuery1 =  "INSERT INTO ".DB_PREFIX."website 					
					(client_id, template_id, total_visit, created_date, created_by, updated_date, updated_by) 					
					values('".$this->client_id."', '1', '0', '".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
		
		$this->runquery($sQuery1);
				
		return $this->client_id;
	}
	
	//Function to add record into table
	function register() 
	{
		echo $sQuery  =  "INSERT INTO ".DB_PREFIX."user 
					
					(client_id, user_type_id, user_username, user_password, 
					user_firstname, user_lastname, user_email, user_company,
					user_designation, user_phone,user_address1, user_address2,
					user_city, user_state, user_country, user_zipcode, 
					user_lastlogin, user_isactive, user_verification, created_date, created_by, 
					updated_date, updated_by) 
					
					values(
							'".$this->client_id."', '".$this->user_type_id."',
							'".$this->user_username."', '".$this->user_password."',
							'".$this->user_firstname."','".$this->user_lastname."',
							'".$this->user_email."','".$this->user_company."',
							'".$this->user_designation."','".$this->user_phone."',
							'".$this->user_address1."','".$this->user_address2."',
							'".$this->user_city."','".$this->user_state."',
							'".$this->user_country."','".$this->user_zipcode."',
							'".$this->user_lastlogin."','".$this->user_isactive."',
							'".$this->user_verification."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
		
				
		
		$this->runquery($sQuery);
		$this->user_id  =  mysql_insert_id();
		
		$sQuery  =  "UPDATE ".DB_PREFIX."user SET created_by='".$this->user_id."',updated_by='".$this->user_id."' WHERE user_id ='".$this->user_id."'";
		$this->runquery($sQuery);
		
		return $this->user_id;
	}
	
	function registrationMail($emailID,$email_to,$email_from,$superAdminType,$serverroot,$contest_title="",$contest_id=0)
	{
		$objEncDec = new encdec();
		$aMailDetail = $this->fetchMailDetail($emailID,$this->client_id);
		
		if(empty($aMailDetail))
		{
			$aMailDetail = $this->fetchMailDetail($emailID);
		}
		
		
		//$email_to = '';
		/*if($aMailDetail['email_to']!='')
		{
			$email_to = $aMailDetail['email_to'].",";
		}*/
		
		//$aEmailID = $this->fetchSuperAdminEmailID($superAdminType);
		//$email_to.= $aEmailID['user_email'].",";
		//$email_to.= $this->user_email;
		$email_verification_link = "<a href='".CURRENT_ENTRANT_URL."register_verification.php?user_id=".$objEncDec->encrypt($this->user_id)."&vcode=".$this->user_verification."'>Click on link to verify and activate your account</a>";
		
		$aMailDetail['email_subject'] = str_replace('{username}',$this->user_username,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{user_firstname}',$this->user_firstname,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{user_lastname}',$this->user_lastname,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{user_fullname}',$this->user_firstname." ".$this->user_lastname,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{user_email}',$this->user_email,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{password}',$this->user_password,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{contest_title}',$contest_title,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{client_url}',CURRENT_ENTRANT_URL,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{SERVER_ADMIN_ROOT}',$serverroot,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{SERVER_CLIENT_HOST}',SERVER_CLIENT_HOST,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{user_id}',$this->user_username,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{email_verification_link}',$email_verification_link,$aMailDetail['email_subject']);
		
		$emailMessage = str_replace('{username}',$this->user_username,$aMailDetail['email_body']);
		$emailMessage = str_replace('{user_firstname}',$this->user_firstname,$emailMessage);
		$emailMessage = str_replace('{user_lastname}',$this->user_lastname,$emailMessage);
		$emailMessage = str_replace('{user_fullname}',$this->user_firstname." ".$this->user_lastname,$emailMessage);
		$emailMessage = str_replace('{user_email}',$this->user_email,$emailMessage);
		$emailMessage = str_replace('{password}',$this->user_password,$emailMessage);
		$emailMessage = str_replace('{contest_title}',"<a href='".CURRENT_ENTRANT_URL."'>".$contest_title."</a>",$emailMessage);
		$emailMessage = str_replace('{client_url}',CURRENT_ENTRANT_URL,$emailMessage);
		$emailMessage = str_replace('{SERVER_ADMIN_ROOT}',$serverroot,$emailMessage);
		$emailMessage = str_replace('{SERVER_CLIENT_HOST}',SERVER_CLIENT_HOST,$emailMessage);
		$emailMessage = str_replace('{user_id}',$this->user_username,$emailMessage);
		$emailMessage = str_replace('{email_verification_link}',$email_verification_link,$emailMessage);
		
		if($contest_id!=0)
		{
			$emailMessage = str_replace('{SPONSOR_LOGOS}',$this->addSponsorsInEmails($contest_id),$emailMessage);
		}
		else
		{
			$emailMessage = str_replace('{SPONSOR_LOGOS}',"",$emailMessage);
		}
		
		$this->phpMailer($email_to, $aMailDetail['email_subject'], $emailMessage , '',  $email_from,'',$aMailDetail['email_cc'],'',$aMailDetail['email_bcc'],'',false);
	}
	
	
	function clientRegistrationMail($emailID,$email_to,$email_from,$superClientUserName="")
	{
		$aMailDetail = $this->fetchMailDetail($emailID,$this->client_id);
		
		if(empty($aMailDetail))
		{
			$aMailDetail = $this->fetchMailDetail($emailID);
		}
		
		if($superClientUserName!="")
		{
			$sContestUrl = SERVER_CLIENT_HOST . $superClientUserName;
		}
		else
		{
			$sContestUrl = SERVER_CLIENT_HOST . $this->user_username;
		}
		
		//$sContestUrl = SERVER_CLIENT_HOST . $this->user_username;
		
		$aMailDetail['email_subject'] = str_replace('{user_firstname}',$this->user_firstname,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{user_lastname}',$this->user_lastname,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{user_fullname}',$this->user_firstname." ".$this->user_lastname,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{username}',$this->user_username,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{user_email}',$this->user_email,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{password}',$this->user_password,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{client_url}',$sContestUrl,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{SERVER_CLIENT_HOST}',SERVER_CLIENT_HOST,$aMailDetail['email_subject']);
		$aMailDetail['email_subject'] = str_replace('{user_id}',$this->user_username,$aMailDetail['email_subject']);
	
		$emailMessage = str_replace('{user_firstname}',$this->user_firstname,$aMailDetail['email_body']);
		$emailMessage = str_replace('{user_lastname}',$this->user_lastname,$emailMessage);
		$emailMessage = str_replace('{user_fullname}',$this->user_firstname." ".$this->user_lastname,$emailMessage);
		$emailMessage = str_replace('{username}',$this->user_username,$emailMessage);
		$emailMessage = str_replace('{user_email}',$this->user_email,$emailMessage);
		$emailMessage = str_replace('{password}',$this->user_password,$emailMessage);
		$emailMessage = str_replace('{client_url}',$sContestUrl,$emailMessage);
		$emailMessage = str_replace('{SERVER_CLIENT_HOST}',SERVER_CLIENT_HOST,$emailMessage);
		$emailMessage = str_replace('{user_id}',$this->user_username,$emailMessage);
	
		$this->phpMailer($email_to, $aMailDetail['email_subject'], $emailMessage , '',  $email_from,'',$aMailDetail['email_cc'],'',$aMailDetail['email_bcc'],'',false);
	}
	
	//Function to add record into table
	function add() 
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."user 
					
					(client_id, user_type_id, user_username, user_password, 
					user_firstname, user_lastname, user_email, user_company,
					user_designation, user_phone,user_address1, user_address2,
					user_city, user_state, user_country, user_zipcode, 
					user_lastlogin, user_isactive, user_verification, created_date, created_by, 
					updated_date, updated_by) 
					
					values(
							'".$this->client_id."', '".$this->user_type_id."',
							'".$this->user_username."', '".$this->user_password."',
							'".$this->user_firstname."','".$this->user_lastname."',
							'".$this->user_email."','".$this->user_company."',
							'".$this->user_designation."','".$this->user_phone."',
							'".$this->user_address1."','".$this->user_address2."',
							'".$this->user_city."','".$this->user_state."',
							'".$this->user_country."','".$this->user_zipcode."',
							'".$this->user_lastlogin."','".$this->user_isactive."',
							'".$this->user_verification."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
		
				
		
		$this->runquery($sQuery);
		$this->user_id  =  mysql_insert_id();
		return mysql_insert_id();
	}
	
	function updateClient()
	{
		$sQuery = "UPDATE ".DB_PREFIX."client SET 
					plan_id = '".$this->plan_id."', 					
					allow_credit = '".$this->allow_credit."', 
					bill_name = '".$this->bill_name."', 
					bill_address1 = '".$this->bill_address1."', 
					bill_address2 = '".$this->bill_address2."', 
					bill_city = '".$this->bill_city."', 
					bill_state = '".$this->bill_state."', 
					bill_country_id = '".$this->bill_country_id."', 
					bill_zipcode = '".$this->bill_zipcode."'
					WHERE client_id = ".$this->client_id;
		
		//echo $sQuery; exit;
		return $this->runquery($sQuery);
	}

	function updateClientCredit()
	{
		$sQuery = "UPDATE ".DB_PREFIX."client SET 
					plan_id = '".$this->plan_id."',
					languages = '".$this->languages."', 
					expiry_date = '".$this->expiry_date."',					
					allow_credit = '".$this->allow_credit."'
					WHERE client_id = ".$this->client_id;
		
		//echo $sQuery; exit;
		return $this->runquery($sQuery);
	}

	//Function to update record of table
	function update() 
	{
		$sQuery = "UPDATE ".DB_PREFIX."user SET 
					client_id = '".$this->client_id."', 
					user_type_id = '".$this->user_type_id."', 
					user_username = '".$this->user_username."', 
					user_password = '".$this->user_password."', 
					user_firstname = '".$this->user_firstname."', 
					user_lastname = '".$this->user_lastname."', 
					user_email = '".$this->user_email."', 
					user_company = '".$this->user_company."', 
					user_designation = '".$this->user_designation."', 
					user_phone = '".$this->user_phone."', 
					user_address1 = '".$this->user_address1."', 
					user_address2 = '".$this->user_address2."', 
					user_city = '".$this->user_city."', 
					user_state = '".$this->user_state."', 
					user_country = '".$this->user_country."', 
					user_zipcode = '".$this->user_zipcode."', 
					user_lastlogin = '".$this->user_lastlogin."', 
					user_isactive = '".$this->user_isactive."', 
					user_verification = '".$this->user_verification."',
					updated_date = '".currentScriptDate()."', 
					updated_by = '".$this->updated_by."' 
				
					WHERE user_id = ".$this->user_id;
		
		return $this->runquery($sQuery);
	}
	
	//Function to update record of table
	function verifyUser() 
	{
		$sQuery = "UPDATE ".DB_PREFIX."user SET 
					user_isactive = '".$this->user_isactive."', 
					user_verification = '".$this->user_verification."',
					updated_date = '".currentScriptDate()."', 
					updated_by = '".$this->updated_by."' 				
					WHERE user_id = ".$this->user_id;
		
		return $this->runquery($sQuery);
	}

	//Function to delete record from table
	function delete() 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."user  WHERE user_id in(".$this->checkedids.")";
		$this->runquery($sQuery);
		
		$sQuery = "DELETE FROM ".DB_PREFIX."user_menu  WHERE user_id in(".$this->checkedids.")";
		$this->runquery($sQuery);	
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$sQuery	 = 	"UPDATE " . DB_PREFIX . "user SET user_isactive = 'n' WHERE user_id in(" . $this->uncheckedids . ")";
		$result  =  $this->runquery($sQuery);
		if($result  ==  false)
			return ;
		$sQuery	 = 	"UPDATE " . DB_PREFIX . "user SET user_isactive = 'y' WHERE user_id in(" . $this->checkedids . ")";
		return $this->runquery($sQuery);
	}
	
	function saveAccessRights()
	{
		$ids = implode(",",$this->checkedids);
		
		/*$strquery = "delete from ".DB_PREFIX."admin_user_menu where user_id='".$this->user_id."' and menu_id not in (".$ids.")";*/
		
		$strquery = "delete from ".DB_PREFIX."user_menu where user_id='".$this->user_id."'";
		mysql_query($strquery);
		
		for ($i=0;$i<count($this->checkedids);$i++)
		{
			if ($this->getMenuCount(" and user_id='".$this->user_id."' and menu_id='".$this->checkedids[$i]."'") == 0)
			{
				$strquery = "insert into ".DB_PREFIX."user_menu (menu_id, user_id) values ('".$this->checkedids[$i]."','".$this->user_id."')";
				
				mysql_query($strquery);
			}
		}
		
	}
	function getMenuCount($condition)
	{
		$strquery = "select count(user_id)as cnt from ".DB_PREFIX."user_menu where 1=1 ".$condition;
		
		
		$rs = mysql_query($strquery);
		$rw = mysql_fetch_assoc($rs);
		return $rw["cnt"];
	}
	
	/**
	 * Get Contest count for listing
	 *
	 * @param int $iClientId
	 * @param int $iStatus
	 * @return count
	 */
	function getContestCountByClientId($iClientId, $iStatus)
	{
		$strquery = "select count(contest_id)as cnt from ".DB_PREFIX."contest where client_id='".$iClientId."' AND contest_status = '".$iStatus."'";
		
		$rs = mysql_query($strquery);
		$rw = mysql_fetch_assoc($rs);
		return $rw["cnt"];
	}
	
	/**
    * This is the function to send mail for forgot password functionality
    */
    function sendForgotPasswordMail($emailID,$userEmail,$emailFrom,$serverroot,$chkType,$condition="")
    {
       $cmn = new common();
       $qry = "SELECT * FROM  ".DB_PREFIX."user  WHERE  user_isactive ='1' AND user_email = '".$userEmail."' AND user_type_id  in (".$chkType.") ".$condition;
	   $rs = mysql_query($qry);
	   
        if (mysql_num_rows($rs) > 0) 
        {
            $row=mysql_fetch_assoc($rs);
       
			$aMailDetail = $this->fetchMailDetail($emailID,$this->client_id);
		
			if(empty($aMailDetail))
			{
				$aMailDetail = $this->fetchMailDetail($emailID);
			}
	   
	   		$emailMessage = str_replace('{user_fullname}',$row['user_firstname']." ".$row['user_lastname'],$aMailDetail['email_body']);
			$emailMessage = str_replace('{username}',$row['user_username'],$emailMessage);
			$emailMessage = str_replace('{password}',$row['user_password'],$emailMessage);		
			$emailMessage = str_replace('{user_firstname}',$row['user_firstname'],$emailMessage);
			$emailMessage = str_replace('{user_lastname}',$row['user_lastname'],$emailMessage);
			$emailMessage = str_replace('{user_email}',$row['user_email'],$emailMessage);
			
			$aMailDetail['email_subject'] = str_replace('{user_fullname}',$row['user_firstname']." ".$row['user_lastname'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{username}',$row['user_username'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{password}',$row['user_password'],$aMailDetail['email_subject']);		
			$aMailDetail['email_subject'] = str_replace('{user_firstname}',$row['user_firstname'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{user_lastname}',$row['user_lastname'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{user_email}',$row['user_email'],$aMailDetail['email_subject']);
			
            $sendMail = $this->phpMailer($row['user_email'], $aMailDetail['email_subject'], $emailMessage , '',  $emailFrom,'',$aMailDetail['email_cc'],'',$aMailDetail['email_bcc'],'',false);
            
            if(isset($sendMail)) {
              	return 1;
            } else {
				return 2;
            }
        }
        else
        {
            return 3;
        }
    }
	
	function sendForgotPasswordMailJudge($emailID,$userName,$emailFrom,$serverroot,$chkType,$contest_id=0,$client_id=0)
    {
       $cmn = new common();
       $qry = "SELECT user_firstname, user_lastname, user_username, user_password, user_email FROM  ".DB_PREFIX."user  WHERE  user_isactive ='1' AND user_username = '".$userName."' AND user_type_id  in (".$chkType.") AND client_id='".$client_id."' UNION SELECT voter_firstname as user_firstname, voter_lastname as user_lastname, voter_username as user_username, voter_password as user_password, voter_email as user_email FROM  ".DB_PREFIX."voter  WHERE  voter_isactive ='1' AND voter_username = '".$userName."' AND user_type_id  in (".$chkType.") AND client_id='".$client_id."' ";
	   
	   $rs = mysql_query($qry);
	   
	   if($contest_id != 0)
	   {
		   $qry_contest = "SELECT * FROM  ".DB_PREFIX."contest  WHERE  contest_id = '".$contest_id."'";	   
		   $rs_contest = mysql_query($qry_contest);
		   $row_contest=mysql_fetch_assoc($rs_contest);
	   }
	   else
	   {
	   		$row_contest['contest_title'] == "";
	   }
	   

        if (mysql_num_rows($rs) > 0) 
        {
            $row=mysql_fetch_assoc($rs);
			$aMailDetail = $this->fetchMailDetail($emailID,$this->client_id);
		
			if(empty($aMailDetail))
			{
				$aMailDetail = $this->fetchMailDetail($emailID);
			}
			
			$aMailDetail['email_subject'] = str_replace('{user_fullname}',$row['user_firstname']." ".$row['user_lastname'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{username}',$row['user_username'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{password}',$row['user_password'],$aMailDetail['email_subject']);		
			$aMailDetail['email_subject'] = str_replace('{user_firstname}',$row['user_firstname'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{user_lastname}',$row['user_lastname'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{user_email}',$row['user_email'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{contest_title}',$row_contest['contest_title'],$aMailDetail['email_subject']);
			$aMailDetail['email_subject'] = str_replace('{client_url}',CURRENT_JUDGE_URL,$aMailDetail['email_subject']);
			
	   		$emailMessage = str_replace('{user_fullname}',$row['user_firstname']." ".$row['user_lastname'],$aMailDetail['email_body']);
			$emailMessage = str_replace('{username}',$row['user_username'],$emailMessage);
			$emailMessage = str_replace('{password}',$row['user_password'],$emailMessage);		
			$emailMessage = str_replace('{user_firstname}',$row['user_firstname'],$emailMessage);
			$emailMessage = str_replace('{user_lastname}',$row['user_lastname'],$emailMessage);
			$emailMessage = str_replace('{user_email}',$row['user_email'],$emailMessage);
			$emailMessage = str_replace('{contest_title}',"<a href='".CURRENT_ENTRANT_URL."'>".$row_contest['contest_title']."</a>",$emailMessage);
			$emailMessage = str_replace('{client_url}',CURRENT_JUDGE_URL,$emailMessage);		
			
			if($contest_id!=0)
			{
				$emailMessage = str_replace('{SPONSOR_LOGOS}',$this->addSponsorsInEmails($contest_id),$emailMessage);
			}
			else
			{
				$emailMessage = str_replace('{SPONSOR_LOGOS}',"",$emailMessage);
			}
			
			$sendMail = $this->phpMailer($row['user_email'], $aMailDetail['email_subject'], $emailMessage , '',  $emailFrom,'',$aMailDetail['email_cc'],'',$aMailDetail['email_bcc'],'',false);
            
            if(isset($sendMail)) {
              	return 1;
            } else {
				return 2;
            }
        }
        else
        {
            return 3;
        }
    }
	/**
     * Function to change password functionality
     *
     */
    function changePassword() {
      
           $selUserQry = "SELECT * FROM ".DB_PREFIX."user WHERE 1=1 ";

           if ($this->user_id!="")
           $selUserQry.=" and user_id ='". $this->user_id ."' and user_password ='".$this->user_oldpassword."'";
	
           $resUser = mysql_query($selUserQry);
		   $Qry1 = '';
           if(mysql_num_rows($resUser)>0)
           {
               $Qry1 .= "user_password ='".$this->user_password."',";
               if($Qry1 != "") {
                   $Qry1 = substr($Qry1,0,strlen($Qry1)-1);
                   $qry = "update ".DB_PREFIX."user set " . $Qry1 . " where user_id=".$this->user_id;
                   mysql_query($qry);
					return 1;
               }

            } else {
               return 2;
            }

    }
	
	function fetchSuperSystemAdmin()
	{
		$selUserQry ="SELECT user_id FROM ".DB_PREFIX."user WHERE 1=1 AND user_type_id = '".USER_TYPE_SUPER_SYSTEM_ADMIN."' ";
         $resUser = mysql_query($selUserQry);
		 if(mysql_num_rows($resUser)>0)
		 {
		 	$res = mysql_fetch_assoc($resUser);
			return $res["user_id"];
		 }
		 else
		 {
		 	return 0;
		 }
	}
	
	function userName($user_id)
	{
		 $selUserQry ="SELECT user_username FROM ".DB_PREFIX."user WHERE 1=1 AND user_id='".$user_id."'";
         $resUser = mysql_query($selUserQry);
		 if(mysql_num_rows($resUser)>0)
		 {
		 	$res = mysql_fetch_assoc($resUser);
			return $res["user_username"];
		 }
		 else
		 {
		 	return "";
		 }
	}
	
	function userNameValue($user_id)
	{
		 $selUserQry ="SELECT concat(user_firstname,' ',user_lastname) as userName FROM ".DB_PREFIX."user WHERE 1=1 AND user_id='".$user_id."'";
         $resUser = mysql_query($selUserQry);
		 if(mysql_num_rows($resUser)>0)
		 {
		 	$res = mysql_fetch_assoc($resUser);
			return $res["userName"];
		 }
		 else
		 {
		 	return "";
		 }
	}
	
	//Function to set field values into object properties
	function setAllUserValues($id = "",$condition = "",$order="")
	{
		if($id !=  "" && $id !=   NULL && is_null($id) == false)
		{
			$condition  =  " and ".DB_PREFIX."user.user_id = ". $id .$condition;
		}
		if($order !=  "" && $order !=   NULL && is_null($order) == false)
		{
			$order  =  " order by " . $order.", user_id desc";
		}
		$sQuery = "SELECT * FROM ".DB_PREFIX."user WHERE 1 = 1 " . $condition . $order;
		$rs  =  $this->runquery($sQuery);
		if($artf_user =  mysql_fetch_assoc($rs))		
		{
			$this->user_id  =  $artf_user["user_id"];
			$this->client_id  =  $artf_user["client_id"];
			$this->user_type_id  =  $artf_user["user_type_id"];
			$this->user_username  =  $artf_user["user_username"];
			$this->user_password  =  $artf_user["user_password"];
			$this->user_firstname  =  $artf_user["user_firstname"];
			$this->user_lastname  =  $artf_user["user_lastname"];
			$this->user_email  =  $artf_user["user_email"];
			$this->user_company  =  $artf_user["user_company"];
			$this->user_designation  =  $artf_user["user_designation"];
			$this->user_phone  =  $artf_user["user_phone"];
			$this->user_address1  =  $artf_user["user_address1"];
			$this->user_address2  =  $artf_user["user_address2"];
			$this->user_city  =  $artf_user["user_city"];
			$this->user_state  =  $artf_user["user_state"];
			$this->user_country  =  $artf_user["user_country"];
			$this->user_zipcode  =  $artf_user["user_zipcode"];
			$this->user_lastlogin  =  $artf_user["user_lastlogin"];
			$this->user_isactive  =  $artf_user["user_isactive"];
			$this->created_date  =  $artf_user["created_date"];
			$this->created_by  =  $artf_user["created_by"];
			$this->updated_date  =  $artf_user["updated_date"];
			$this->updated_by  =  $artf_user["updated_by"];
		}
	//	echo "<pre>"; print_r($artf_user); exit;
	}
	function fetchplanid()
	{
		 $sql="select plan_id from ".DB_PREFIX."client where client_id=".$this->client_id;
		$res=mysql_query($sql);
		$data=mysql_fetch_assoc($res);
		//print_r($data);exit;
		$this->plan_id=$data['plan_id'];
	}
	function renewalclientbeforeweek()
	{
		$sql="select user_firstname,user_lastname,user_email,expiry_date from ".DB_PREFIX."client c
		left join ".DB_PREFIX."user u on u.client_id=c.client_id
		where DATEDIFF(expiry_date,curdate())=7";
		
		$res=mysql_query($sql);
		$EmailType="Renewal_Reminder";
		
		if(empty($aMailDetail))
		{
			$aMailDetail = $this->fetchMailDetail($EmailType);
		}
		while($arr=mysql_fetch_array($res))
		{
			$emailMessage=$aMailDetail['email_body'];
			$email_to=$arr['user_email'];
			$name=$arr['user_firstname']." ".$arr['user_lastname'];
			$emailMessage = str_replace('clientname',$name,$emailMessage);
			$emailMessage = str_replace('{expdate}',$arr['expiry_date'],$emailMessage);
		//	echo $emailMessage;exit;
			$this->phpMailer($email_to, $aMailDetail['email_subject'], $emailMessage , '',  ADMIN_EMAIL,'','','','','',false);
		}
	}	

function renewalclientbeforeoneday()
	{
		$sql="select user_firstname,user_lastname,user_email,expiry_date from ".DB_PREFIX."client c
		left join ".DB_PREFIX."user u on u.client_id=c.client_id
		where DATEDIFF(expiry_date,curdate())=1";
		
		$res=mysql_query($sql);
		$EmailType="Renewal_Reminder";
		
		if(empty($aMailDetail))
		{
			$aMailDetail = $this->fetchMailDetail($EmailType);
		}
		while($arr=mysql_fetch_array($res))
		{
			$emailMessage=$aMailDetail['email_body'];
			$email_to=$arr['user_email'];
			$name=$arr['user_firstname']." ".$arr['user_lastname'];
			$emailMessage = str_replace('clientname',$name,$emailMessage);
			$emailMessage = str_replace('{expdate}',$arr['expiry_date'],$emailMessage);
		//	echo $emailMessage;exit;
			$this->phpMailer($email_to, $aMailDetail['email_subject'], $emailMessage , '',  ADMIN_EMAIL,'','','','','',false);
		}
	}	
	function expireclientaccount()
	{
		$sql="select c.client_id from ".DB_PREFIX."client c
		left join ".DB_PREFIX."user u on u.client_id=c.client_id
		where DATEDIFF(expiry_date,curdate())=0";
		
		$res=mysql_query($sql);
		while($arr=mysql_fetch_array($res))
		{
			$query="update ".DB_PREFIX."user set user_isactive=2 where client_id=".$arr['client_id'];
			mysql_query($query);
		}
	}		
	
	function fetchclientidapi($api_key)
	{
		$sql = "Select client_id from ".DB_PREFIX."website where ActivationKey='".$api_key."'";
		$res=mysql_query($sql);
		$client_id=0;
		
		while($data=mysql_fetch_array($res))
		{	
			$client_id=$data['client_id'];
		}
		
		return $client_id;
	}

	function fetchClientLanguages($client_id)
	{
		$sql="select languages from ".DB_PREFIX."client where client_id=".$client_id;
		$res=mysql_query($sql);
		$data=mysql_fetch_assoc($res);
		//print_r($data);exit;
		return $data['languages'];
	}
	
	function getSuperClientDetail($client_id)
	{
		$sql="select * from ".DB_PREFIX."client c, ".DB_PREFIX."user u where c.client_id = u.client_id AND u.user_type_id = '3' AND c.client_id=".$client_id;
		$res=mysql_query($sql);
		
		$userdata = array();
		
		if(mysql_num_rows($res) > 0)
		$userdata=mysql_fetch_assoc($res);
		//print_r($data);exit;
		return $userdata;
	}

}
?>