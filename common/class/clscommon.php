<?php
class common
{
	var $judgeRndDate;
	var $defaultMenu=1;
	//var $systemMenuAddedID = 0;
	/**
	 * Get Country Selection box
	 *
	 * @param integer $iSelectedId Selected Country Id
	 * @return Contry combobox HTML 
	 */
	function getContryArray($iSelectedId)
	{
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "country";

		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs) > 0) 
		{
			
			$aCountries = mysql_fetch_array($rs);
			
			$selCountries = '<select name="selcountry_id" id="selcountry_id" class="input_text">
								<option value="0">- Select -</option>';
			
			while ($aCountries) 
			{
				if (!empty($iSelectedId) && $iSelectedId == $aCountries['country_id']) 
				{
					$selected = 'selected';
				}
				else 
				{
					$selected = '';
				}	
							
				$selCountries .=  '<option value="'.$aCountries['country_id'].'" '.$selected.'>'.$aCountries['country_name'].'</option>';
				
				$aCountries = mysql_fetch_array($rs);
			}
			
			$selCountries .=  '</select>';
			
		}
		
		return $selCountries;
	}
	
	function getContryNameById($countryId)
	{
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "country WHERE country_id = '".$countryId."'";

		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs) > 0) 
		{
			$aCountry = mysql_fetch_assoc($rs);
			return $aCountry['country_name'];
		}
		else 
		{
			return 0;
		}
	}

	
	/**
	 * Login to System admin panel / Contest admin panel
	 *
	 * @param string $username
	 * @param string $pass
	 * @param defined value in global declaration file $adminType
	 * @return true if login successfully
	 */
	function loginAdmin($username, $pass, $adminType = 'system_admin', $client_id=0)
	{	
		if($adminType == 'client_admin')
		{
			$sQuery  =  "SELECT * FROM " . DB_PREFIX . "user
			left join " . DB_PREFIX . "client on " . DB_PREFIX . "user.client_id=" . DB_PREFIX . "client.client_id
			WHERE 
			user_username = '". trim($username) ."' AND user_password = '". trim($pass) ."' AND user_type_id in (3,4)";
			//AND client_id='".$client_id."'
		}
		else
		{
			$sQuery  =  "SELECT * FROM " . DB_PREFIX . "user WHERE user_username = '". trim($username) ."' AND user_password = '". trim($pass) ."'";
		}

		$rs  =  $this->runQuery($sQuery); 
		
		$ret = '0';

		switch ($adminType)
		{
			case 'system_admin':
				
				$userTypes  =  array(
										USER_TYPE_SUPER_SYSTEM_ADMIN,
										USER_TYPE_SYSTEM_ADMIN
								  );
								  
				$sessionArray  =  array(
										'user_id' => SYSTEM_ADMIN_USER_ID, 
										'user_username' => SYSTEM_ADMIN_USER_USERNAME,
										'user_firstname' => SYSTEM_ADMIN_USER_DISPLAYNAME, 
										'user_type_id' => SYSTEM_ADMIN_USER_TYPE_ID	
									);			  
				
				break;
				
			case 'client_admin':
				
				$userTypes  =  array(
										USER_TYPE_SUPER_SYSTEM_ADMIN,
										USER_TYPE_SYSTEM_ADMIN,
										USER_TYPE_SUPER_CLIENT_ADMIN,
										USER_TYPE_CLIENT_ADMIN
								   );
								   
				$sessionArray  =  array(
										'user_id' => ADMIN_USER_ID, 
										'user_username' => ADMIN_USER_USERNAME,
										'user_firstname' => ADMIN_USER_DISPLAYNAME, 
										'user_type_id' => ADMIN_USER_TYPE_ID	
									);		  
				
				break;
						
		}
	
		$rw = mysql_fetch_array($rs);
		
		if ($rw)
		{
			$payment_status = 1;
			if($rw["allow_credit"] != 1 && $adminType == "client_admin")
			{
				$payment_status = $this->checkPaymentStatusByClientId($rw['client_id']);
			}
			
			if($rw["expiry_date"] < date("Y-m-d") && $adminType == 'client_admin' && $rw["user_username"] == $this->readValue($username) && $rw["user_password"] == $this->readValue($pass))
			{
				$ret ='3';
			}
			else if($payment_status != 1)
			{
				$ret ='4';
			}
			else
			{
				if ($rw["user_username"] == $this->readValue($username) && $rw["user_password"] == $this->readValue($pass) && $rw["user_isactive"] == 1)
				{
					if ( in_array($rw["user_type_id"],$userTypes))
					{
						$ret = '1';
						$this->logoutAdmin($adminType);
					
						if (!empty($sessionArray)) 
						{
							foreach ($sessionArray as $sessionK => $sessionV)	
							{
								if ($sessionK == 'user_firstname') 
								{
					$fullName = $rw["user_firstname"]." ".$rw["user_lastname"];	
									$this->setSession($sessionV, $fullName);
								}
								else 
								{
									$this->setSession($sessionV, $rw[$sessionK]);
								}
							}
						}
					}
				}
				else
				{
					$ret = '2';
				}
			}
		}
		return $ret;
	}
	
	function loginEntrant($username, $pass, $client_id, $contest_id=0)
	{	
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "user WHERE user_username = '". trim($username) ."' AND user_password = '". trim($pass) ."' AND user_type_id='".USER_TYPE_ENTRANT_USER."' AND client_id='".$client_id."'";
		$rs  =  $this->runQuery($sQuery); 
		$ret = '0';

		$userTypes  =  array(
			USER_TYPE_ENTRANT_USER,
			USER_TYPE_JUDGE_USER
		);
								  
		$sessionArray  =  array(
			'user_id' => SYSTEM_ENTRANT_USER_ID, 
			'user_username' => SYSTEM_ENTRANT_USER_USERNAME,
			'user_firstname' => SYSTEM_ENTRANT_USER_DISPLAYNAME, 
			'contest_id' => SYSTEM_CLIENT_ID
		);			  
		
		$rw = mysql_fetch_array($rs);
		if ($rw)
		{
			if ($rw["user_username"] == $this->readValue($username) && $rw["user_password"] == $this->readValue($pass) && $rw["user_isactive"]=="1")
			{
				if ( in_array($rw["user_type_id"],$userTypes))
				{
					$ret = '1';
					
					$this->logoutAdmin('entrant_user');
					
					if (!empty($sessionArray)) 
					{
						foreach ($sessionArray as $sessionK => $sessionV)	
						{
							if ($sessionK == 'user_firstname') 
							{
								$fullName  =  $rw["user_firstname"]." ".$rw["user_lastname"];	
								$this->setSession($sessionV, $fullName);
							}
							elseif ($sessionK == 'contest_id') 
							{
								$fullName  =  $contest_id;	
								$this->setSession($sessionV, $fullName);
							}
							else 
							{
								$this->setSession($sessionV, $rw[$sessionK]);
							}
						}
					}
				}
			}
			else if($rw["user_isactive"] == "0" && $rw["user_verification"]!="")
			{
				$ret = '2';
			}
		}
		return $ret;
	}
	
	
	function loginPreviewEntrant($username, $pass, $client_id)
	{	
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "user WHERE user_username = '". trim($username) ."' AND user_password = '". trim($pass) ."' AND user_isactive  =  1 AND user_type_id='".USER_TYPE_PREVIEW_ENTRANT_USER."' ";
		$rs  =  $this->runQuery($sQuery); 
		$ret = '0';

		$userTypes  =  array(
			USER_TYPE_PREVIEW_ENTRANT_USER
		);
								  
		$sessionArray  =  array(
			'user_id' => SYSTEM_ENTRANT_USER_ID, 
			'user_username' => SYSTEM_ENTRANT_USER_USERNAME,
			'user_firstname' => SYSTEM_ENTRANT_USER_DISPLAYNAME, 
		);			  
		
		$rw = mysql_fetch_array($rs);
		if ($rw)
		{
			if ($rw["user_username"] == $this->readValue($username) && $rw["user_password"] == $this->readValue($pass))
			{
				if ( in_array($rw["user_type_id"],$userTypes))
				{
					$ret = '1';
					
					$this->logoutAdmin('entrant_user');
					
					if (!empty($sessionArray)) 
					{
						foreach ($sessionArray as $sessionK => $sessionV)	
						{
							if ($sessionK == 'user_firstname') 
							{
								$fullName  =  $rw["user_firstname"]." ".$rw["user_lastname"];	
								$this->setSession($sessionV, $fullName);
							}
							else 
							{
								$this->setSession($sessionV, $rw[$sessionK]);
							}
						}
					}
				}
			}
		}
		return $ret;
	}
	
	function chkUserExistsOrNot($username, $pass, $client_id)
	{
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "user u WHERE u.user_username = '". trim($username) ."' AND u.user_password = '". trim($pass) ."' AND u.user_type_id='".USER_TYPE_JUDGE_USER."' AND u.client_id='".$client_id."' ";
		
		$rs  =  $this->runQuery($sQuery); 
		return mysql_num_rows($rs);
	}
	
	function chkUserActiveOrNot($username, $pass, $client_id)
	{
		$sQuery  =  "SELECT user_isactive FROM " . DB_PREFIX . "user u WHERE u.user_username = '". trim($username) ."' AND u.user_password = '". trim($pass) ."' AND u.user_type_id='".USER_TYPE_JUDGE_USER."' AND u.client_id='".$client_id."' ";
		
		$rs  =  $this->runQuery($sQuery); 
		$res = mysql_fetch_assoc($rs);
		return $res["user_isactive"];
	}
	
	function convertFormtTime($date)
	{
		$dateValue = explode(" ",$date);		
		$dateVal = $this->dateTimeFormatMonth($dateValue[0],'%Y-%m-%d');
		
		if(count($dateValue) > 2)
			$timeVal = DATE("H:i", STRTOTIME($dateValue[1]." ".$dateValue[2]));
		else if(count($dateValue) > 1)	
			$timeVal = DATE("H:i", STRTOTIME($dateValue[1]));
		else
			$timeVal = "00:00";
		
		return $dateVal." ".$timeVal.":00";
	}
	
	function convertFormtDate($date, $format="Y-m-d")
	{
		$dateValue = explode(" ",$date);	
		$dateVal = date($format, strtotime($dateValue[0]));
				
		return $dateVal;
	}
	
	function convertFormtTimeToDb($date)
	{
		$dateValue = explode(" ",$date);		
		$dateVal = $this->dateTimeFormat($dateValue[0],'%m/%d/%Y');
		
		if(count($dateValue) > 2)
			$timeVal = DATE("H:i", STRTOTIME($dateValue[1]." ".$dateValue[2]));
		else if(count($dateValue) > 1)	
			$timeVal = DATE("H:i", STRTOTIME($dateValue[1]));
		else
			$timeVal = "00:00";
		
		return $dateVal." ".$timeVal.":00";
	}
	
	function convertFormtTimeDb($date)
	{	
		$dateValue = explode(" ",$date);
		$dateVal = $this->dateTimeFormatYearChk($dateValue[0],'%m/%d/%Y');
		$timeVal = DATE("h:i a", STRTOTIME($dateValue[1]));
		return $dateVal." ".$timeVal;
	}
	
	function changeDateTimeFormateFromDb($dateVal)
	{
		$adateValue = explode(" ",$dateVal);
		$dateValue = $adateValue[0];
		$arrdateValue = explode("-",$dateValue);
		$dateValue = $arrdateValue[1]."/".$arrdateValue[2]."/".$arrdateValue[0];
		$atimeValue = explode(":",$adateValue[1]);
		$timeValue = $atimeValue[0].":".$atimeValue[1]." am";
		if($atimeValue[0]>12)
		{
			$timeValue = ($atimeValue[0]-12).":".$atimeValue[1]." pm";
		}
		$dateTimeVal = $dateValue." ".$timeValue;
		return $dateTimeVal;
	}
	
	function chkVoterActiveOrNot($username, $pass, $client_id)
	{	
	
		$sQuery  =  "SELECT voter_isactive FROM " . DB_PREFIX . "voter v WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND v.user_type_id='".USER_TYPE_VOTER_USER."' AND v.client_id='".$client_id."' ";
		
		$rs  =  $this->runQuery($sQuery); 
		$res = mysql_fetch_assoc($rs);
		return $res["voter_isactive"];
	}
	
	function chkVoterExistsOrNot($username, $pass, $client_id)
	{
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "voter v WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND v.user_type_id='".USER_TYPE_VOTER_USER."' AND v.client_id='".$client_id."' ";
		
		$rs  =  $this->runQuery($sQuery); 
		return mysql_num_rows($rs);
	}
	
	function chkPublicVoterActiveOrNot($username, $pass, $client_id)
	{
		$sQuery  =  "SELECT voter_isactive, voter_verification FROM " . DB_PREFIX . "voter v WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND v.user_type_id='".USER_TYPE_PUBLIC_VOTER_USER."' AND v.client_id='".$client_id."' ";
		
		$rs  =  $this->runQuery($sQuery); 
		$res = mysql_fetch_assoc($rs);
		
		if($res['voter_verification'] != "")
			return (-1);
			
		return $res["voter_isactive"];
	}
	
	function chkPublicVoterExistsOrNot($username, $pass, $client_id)
	{
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "voter v WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND v.user_type_id='".USER_TYPE_PUBLIC_VOTER_USER."' AND v.client_id='".$client_id."' ";
		
		$rs  =  $this->runQuery($sQuery); 
		return mysql_num_rows($rs);
	}
	
	function loginJudge($username, $pass, $client_id, $contest_id)
	{	
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "user u," . DB_PREFIX . "judge_round jr," . DB_PREFIX . "judge_round_user jru," . DB_PREFIX . "contest c WHERE u.user_username = '". trim($username) ."' AND c.contest_id='".$contest_id."' AND u.user_password = '". trim($pass) ."' AND u.user_type_id='".USER_TYPE_JUDGE_USER."' AND u.client_id='".$client_id."' AND jr.judge_round_id=jru.judge_round_id AND u.user_id=jru.user_id AND jr.contest_id=c.contest_id AND c.client_id='".$client_id."' AND c.client_id=u.client_id AND jr.start_date<='".currentScriptDate()."' AND jr.end_date>='".currentScriptDate()."'";
		
		$rs  =  $this->runQuery($sQuery); 
		$ret = '0';

		$userTypes  =  array(
			USER_TYPE_JUDGE_USER
		);
								  
		$sessionArray  =  array(
			'user_id' => SYSTEM_JUDGE_USER_ID, 
			'user_username' => SYSTEM_JUDGE_USER_USERNAME,
			'user_firstname' => SYSTEM_JUDGE_USER_DISPLAYNAME, 
			'user_type_id' => SYSTEM_JUDGE_USER_TYPE_ID,
			'contest_id' => SYSTEM_JUDGE_CONTEST_ID	
		);			  
		
		$rw = mysql_fetch_array($rs);
		if ($rw)
		{
			if ($rw["user_username"] == $this->readValue($username) && $rw["user_password"] == $this->readValue($pass))
			{
				if ( in_array($rw["user_type_id"],$userTypes))
				{
					if($rw["user_isactive"] == 1)
					{
						$ret = '1';
						
						$this->logoutAdmin('judge_user');
						
						if (!empty($sessionArray)) 
						{	
							foreach ($sessionArray as $sessionK => $sessionV)	
							{
								if ($sessionK == 'user_firstname') 
								{
									$fullName  =  $rw["user_firstname"]." ".$rw["user_lastname"];	
									$this->setSession($sessionV, $fullName);
								}
								elseif ($sessionK == 'contest_id') 
								{
									$fullName  =  $contest_id;	
									$this->setSession($sessionV, $fullName);
								}
								else 
								{	
									$this->setSession($sessionV, $rw[$sessionK]);
								}
							}
						}
					}					
					else
					{
						$ret = '3';
					}	
				}
			}
		}
		else
		{
			$sQuery  =  "SELECT jr.start_date FROM " . DB_PREFIX . "user u," . DB_PREFIX . "judge_round jr," . DB_PREFIX . "judge_round_user jru," . DB_PREFIX . "contest c WHERE u.user_username = '". trim($username) ."' AND u.user_password = '". trim($pass) ."' AND u.user_isactive  =  1 AND u.user_type_id='".USER_TYPE_JUDGE_USER."' AND c.contest_id='".$contest_id."' AND u.client_id='".$client_id."' AND jr.judge_round_id=jru.judge_round_id AND u.user_id=jru.user_id AND jr.contest_id=c.contest_id AND c.client_id='".$client_id."' AND c.client_id=u.client_id AND jr.start_date>='".currentScriptDate()."' ORDER BY jr.start_date asc LIMIT 0,1 ";
			$rs  =  $this->runQuery($sQuery); 
			if(mysql_num_rows($rs)>0)
			{				
				$ret = 2;
				$res = mysql_fetch_assoc($rs);
				$this->judgeRndDate = $res['start_date'];				
			}
			else
			{
				$sQuery  =  "SELECT jr.end_date FROM " . DB_PREFIX . "user u," . DB_PREFIX . "judge_round jr," . DB_PREFIX . "judge_round_user jru," . DB_PREFIX . "contest c WHERE u.user_username = '". trim($username) ."' AND u.user_password = '". trim($pass) ."' AND u.user_isactive  =  1 AND u.user_type_id='".USER_TYPE_JUDGE_USER."' AND c.contest_id='".$contest_id."' AND u.client_id='".$client_id."' AND jr.judge_round_id=jru.judge_round_id AND u.user_id=jru.user_id AND jr.contest_id=c.contest_id AND c.client_id='".$client_id."' AND c.client_id=u.client_id AND jr.end_date<='".currentScriptDate()."' ORDER BY jr.end_date asc LIMIT 0,1 ";
				$rs  =  $this->runQuery($sQuery); 
				if(mysql_num_rows($rs)>0)
				{				
					$ret = 4;
					$res = mysql_fetch_assoc($rs);
					$this->judgeRndDate = $res['end_date'];				
				}
			}
		}
		return $ret;
	}
	
	
	function loginVoter($username, $pass, $client_id, $contest_id)
	{	
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "voter v," . DB_PREFIX . "judge_round jr," . DB_PREFIX . "judge_round_voter_group jrv," . DB_PREFIX . "contest c WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND v.user_type_id='".USER_TYPE_VOTER_USER."' AND c.contest_id='".$contest_id."' AND v.client_id='".$client_id."' AND jr.judge_round_id=jrv.judge_round_id AND v.voter_group_id=jrv.voter_group_id AND jr.contest_id=c.contest_id AND c.client_id='".$client_id."' AND c.client_id=v.client_id AND jr.start_date<='".currentScriptDate()."' AND jr.end_date>='".currentScriptDate()."'";
		
		$rs  =  $this->runQuery($sQuery); 
		$ret = '0';

		$userTypes  =  array(
			USER_TYPE_VOTER_USER
		);
								  
		$sessionArray  =  array(
			'voter_id' => SYSTEM_JUDGE_USER_ID, 
			'voter_username' => SYSTEM_JUDGE_USER_USERNAME,
			'voter_firstname' => SYSTEM_JUDGE_USER_DISPLAYNAME, 
			'user_type_id' => SYSTEM_JUDGE_USER_TYPE_ID,
			'contest_id' => SYSTEM_JUDGE_CONTEST_ID		
		);			  

		$rw = mysql_fetch_array($rs);
		if ($rw)
		{
			if ($rw["voter_username"] == $this->readValue($username) && $rw["voter_password"] == $this->readValue($pass))
			{
				if ( in_array($rw["user_type_id"],$userTypes))
				{	
					if($rw["voter_isactive"] == 1)
					{
						$ret = '1';
						
						$this->logoutAdmin('judge_user');
						
						if (!empty($sessionArray)) 
						{
							foreach ($sessionArray as $sessionK => $sessionV)	
							{
								if ($sessionK == 'voter_firstname') 
								{
									$fullName  =  $rw["voter_firstname"]." ".$rw["voter_lastname"];	
									$this->setSession($sessionV, $fullName);
								}
								elseif ($sessionK == 'contest_id') 
								{
									$fullName  =  $contest_id;	
									$this->setSession($sessionV, $fullName);
								}
								else 
								{	
									$this->setSession($sessionV, $rw[$sessionK]);
								}
							}
						}
					}
					else
					{
						$ret = '3';
					}
				}
			}
		}
		else
		{
			$sQuery  =  "SELECT jr.start_date FROM " . DB_PREFIX . "voter v," . DB_PREFIX . "judge_round jr," . DB_PREFIX . "judge_round_voter_group jrv," . DB_PREFIX . "contest c WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND v.user_type_id='".USER_TYPE_VOTER_USER."' AND c.contest_id='".$contest_id."' AND v.client_id='".$client_id."' AND jr.judge_round_id=jrv.judge_round_id AND v.voter_group_id=jrv.voter_group_id AND jr.contest_id=c.contest_id AND c.client_id='".$client_id."' AND c.client_id=v.client_id AND jr.start_date>='".currentScriptDate()."' ORDER BY jr.start_date asc LIMIT 0,1 ";
		
			$rs  =  $this->runQuery($sQuery); 
			if(mysql_num_rows($rs)>0)
			{
				$ret = 2;
				$res = mysql_fetch_assoc($rs);
				$this->judgeRndDate = $res['start_date'];				
			}
			else
			{
				$sQuery  =  "SELECT jr.end_date FROM " . DB_PREFIX . "voter v," . DB_PREFIX . "judge_round jr," . DB_PREFIX . "judge_round_voter_group jrv," . DB_PREFIX . "contest c WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND v.user_type_id='".USER_TYPE_VOTER_USER."' AND c.contest_id='".$contest_id."' AND v.client_id='".$client_id."' AND jr.judge_round_id=jrv.judge_round_id AND v.voter_group_id=jrv.voter_group_id AND jr.contest_id=c.contest_id AND c.client_id='".$client_id."' AND c.client_id=v.client_id AND jr.end_date>='".currentScriptDate()."' ORDER BY jr.end_date asc LIMIT 0,1 ";
			
				$rs  =  $this->runQuery($sQuery); 
				if(mysql_num_rows($rs)>0)
				{				
					$ret = 4;
					$res = mysql_fetch_assoc($rs);
					$this->judgeRndDate = $res['end_date'];				
				}
			}
		}
		
		return $ret;
	}
	
	function loginPublicVoter($username, $pass, $client_id, $contest_id)
	{	
		$sQuery  =  "SELECT * FROM " . DB_PREFIX . "voter v," . DB_PREFIX . "judge_round jr," . DB_PREFIX . "contest c WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND c.contest_id='".$contest_id."' AND v.user_type_id='".USER_TYPE_PUBLIC_VOTER_USER."' AND v.client_id='".$client_id."' AND jr.contest_id=c.contest_id AND c.client_id='".$client_id."' AND c.client_id=v.client_id AND jr.start_date<='".currentScriptDate()."' AND jr.end_date>='".currentScriptDate()."' AND jr.is_public='1' ";
		$rs  =  $this->runQuery($sQuery); 
		$ret = '0';

		$userTypes  =  array(
			USER_TYPE_PUBLIC_VOTER_USER
		);
								  
		$sessionArray  =  array(
			'voter_id' => SYSTEM_JUDGE_USER_ID, 
			'voter_username' => SYSTEM_JUDGE_USER_USERNAME,
			'voter_firstname' => SYSTEM_JUDGE_USER_DISPLAYNAME, 
			'user_type_id' => SYSTEM_JUDGE_USER_TYPE_ID,
			'contest_id' => SYSTEM_JUDGE_CONTEST_ID	
		);			  
		
		$rw = mysql_fetch_array($rs);
		if ($rw)
		{
			if ($rw["voter_username"] == $this->readValue($username) && $rw["voter_password"] == $this->readValue($pass))
			{
				if ( in_array($rw["user_type_id"],$userTypes))
				{	
					if($rw["voter_isactive"] == 1)
					{
						$ret = '1';
						
						$this->logoutAdmin('judge_user');
						
						if (!empty($sessionArray)) 
						{
							foreach ($sessionArray as $sessionK => $sessionV)	
							{
								if ($sessionK == 'voter_firstname') 
								{
									$fullName  =  $rw["voter_firstname"]." ".$rw["voter_lastname"];	
									$this->setSession($sessionV, $fullName);
								}
								elseif ($sessionK == 'contest_id') 
								{
									$fullName  =  $contest_id;	
									$this->setSession($sessionV, $fullName);
								}
								else 
								{	
									$this->setSession($sessionV, $rw[$sessionK]);
								}
							}
						}
					}
					else if($rw["voter_isactive"] == "0" && $rw["voter_verification"]!="")
					{
						$ret = '5';
					}
					else
					{
						$ret = '3';
					}	
				}
			}
		}
		else
		{
			$sQuery  =  "SELECT jr.start_date FROM " . DB_PREFIX . "voter v," . DB_PREFIX . "judge_round jr," . DB_PREFIX . "contest c WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND c.contest_id='".$contest_id."' AND v.user_type_id='".USER_TYPE_PUBLIC_VOTER_USER."' AND v.client_id='".$client_id."' AND jr.contest_id=c.contest_id AND c.client_id='".$client_id."' AND c.client_id=v.client_id AND jr.is_public='1'  AND jr.start_date>='".currentScriptDate()."' ORDER BY jr.start_date asc LIMIT 0,1 ";
			
			$rs  =  $this->runQuery($sQuery); 
			if(mysql_num_rows($rs)>0)
			{
				$ret = 2;
				$res = mysql_fetch_assoc($rs);
				$this->judgeRndDate = $res['start_date'];				
			}
			else
			{
				$sQuery  =  "SELECT jr.end_date FROM " . DB_PREFIX . "voter v," . DB_PREFIX . "judge_round jr," . DB_PREFIX . "contest c WHERE v.voter_username = '". trim($username) ."' AND v.voter_password = '". trim($pass) ."' AND c.contest_id='".$contest_id."' AND v.user_type_id='".USER_TYPE_PUBLIC_VOTER_USER."' AND v.client_id='".$client_id."' AND jr.contest_id=c.contest_id AND c.client_id='".$client_id."' AND c.client_id=v.client_id AND jr.is_public='1'  AND jr.end_date>='".currentScriptDate()."' ORDER BY jr.end_date asc LIMIT 0,1 ";
			
				$rs  =  $this->runQuery($sQuery); 
				if(mysql_num_rows($rs)>0)
				{				
					$ret = 4;
					$res = mysql_fetch_assoc($rs);
					$this->judgeRndDate = $res['end_date'];				
				}
			}
		}
		
		return $ret;
	}
	
	function checkUserAvailable($user_id)
	{
		$sQuery = "SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '".$user_id."' ";
		$rs  =  $this->runQuery($sQuery);
		return mysql_num_rows($rs);
	}
	
	function checkUserAvailableUserName($user_id)
	{
		$sQuery = "SELECT * FROM " . DB_PREFIX . "user WHERE user_username = '".$user_id."' ";
		$rs  =  $this->runQuery($sQuery);
		return mysql_num_rows($rs);
	}
	
	function addUserLoginHistory($result,$user_id,$username,$loginpage)
	{
		$strquery="INSERT INTO ".DB_PREFIX."user_login_history (client_id, user_id, loginuser_name, 
						login_date, ip_address,login_result,login_page,created_by, created_date, 
						updated_by, updated_date) values('0',
							'".$user_id."', '".$username."',
							'".currentScriptDate()."',
							'".$this->getRealIpAddr()."',
							'".$result."',
							'".$loginpage."',
							'1',
							'".currentScriptDate()."',
							'1',
							'".currentScriptDate()."')";
		
		return mysql_query($strquery) or die(mysql_error());
	}

	function logoutAdmin($adminType = 'system_admin')
	{	
		$ret = '1';
		
		switch ($adminType)
		{
			case 'system_admin':
				
				$sessionArray  =  array(
				
									SYSTEM_ADMIN_USER_ID, SYSTEM_ADMIN_USER_USERNAME,
									SYSTEM_ADMIN_USER_DISPLAYNAME, SYSTEM_ADMIN_USER_TYPE_ID	
									);		  
				
				break;
				
			case 'client_admin':
				
				$sessionArray  =  array(
				
									ADMIN_USER_ID, ADMIN_USER_USERNAME,
									ADMIN_USER_DISPLAYNAME, ADMIN_USER_TYPE_ID	
									);		  
				
				break;
				
			case 'entrant_user':
				
				$sessionArray  =  array(
				
									SYSTEM_ENTRANT_USER_ID, SYSTEM_ENTRANT_USER_USERNAME,
									SYSTEM_ENTRANT_USER_DISPLAYNAME, SYSTEM_ENTRANT_USER_TYPE_ID,
									SYSTEM_CLIENT_ID
									);	
				break;	  
				
			case 'judge_user':
				
				$sessionArray  =  array(
				
									SYSTEM_JUDGE_USER_ID, SYSTEM_JUDGE_USER_USERNAME,
									SYSTEM_JUDGE_USER_DISPLAYNAME, SYSTEM_JUDGE_USER_TYPE_ID,
									SYSTEM_JUDGE_CONTEST_ID	
									);	
				break;
				
		}
		
		if (!empty($sessionArray)) 
		{
			foreach ($sessionArray as $sessionK)	
			{
				$this->removeSession($sessionK);
			}
		}
		
		return $ret;
	}	
	
	function loginUser($user_username,$pass, $isadmin = false)
	{	
		$sQuery = "SELECT *, (SELECT membership_name FROM ".DB_PREFIX."membership m WHERE m.membership_id = u.membership_id) as membership_name FROM " . DB_PREFIX . "user u WHERE usertype_id <> 1 AND user_email = '". trim($user_username) ."' AND user_password = '". trim($pass) ."'";
		if (!$isadmin)
			$sQuery .=  " AND user_isactive  =  1 ";

		$rs  =  $this->runQuery($sQuery);
		
		$ret  =  0;

		$rw = mysql_fetch_array($rs);
		if ($rw)
		{
			$ret  =  1;
			$this->setSession(CLIENT_USER_ID,$rw["user_id"]);
			$this->setSession(CLIENT_USER_USERNAME,$rw["user_email"]);
			$this->setSession(CLIENT_USER_DISPLAYNAME,$rw["user_firstname"]." ".$rw["user_lastname"]);
			$this->setSession(CLIENT_USER_MEMBERSHIP_ID,$rw["membership_id"]);
			$this->setSession(CLIENT_USER_MEMBERSHIP_NAME,$rw["membership_name"]);
			$this->setSession(CLIENT_USER_PHOTO,$rw["user_photo"]);
		}
		if ($ret == 0)
		{
			$sQuery = "SELECT * FROM ".DB_PREFIX."user WHERE user_email = '".trim($user_username)."'";
			$rs  =  $this->runQuery($sQuery);
		
			if (mysql_num_rows($rs)>0)
			{
				$rw  =  mysql_fetch_array($rs);
				if ($rw["user_isactive"]==1)
				{
					if ($rw["user_password"] == $pass)
					{
						if ($rw["usertype_id"] !=  2)
							$ret  =  2;
					}
					else
						$ret  =  3;
				}
				else
					$ret  =  4;
			}
			else
			{
				$ret  =  2;
			}
		}

		return $ret;
	}
	
	function userExists($user_email)
	{	
		$sQuery = "SELECT * FROM " . DB_PREFIX . "user WHERE usertype_id <> 1 AND user_email = '". trim($user_email) ."' ";
		
		$rs  =  $this->runQuery($sQuery);
		
		$ret = '0';
		$rw  =  mysql_fetch_array($rs);
		if ($rw)
		{
			$ret = '1';
		}
		
		return $ret;
	} 

	function getUserInfo($user_email,$field)
	{	
		if ($field !=  "user_name")
			$sQuery = "SELECT ".$field." FROM " . DB_PREFIX . "user WHERE usertype_id <> 1 AND user_email = '". trim($user_email) ."' ";
		else
			$sQuery = "SELECT concat(user_firstname,' ',user_lastname) as user_name FROM " . DB_PREFIX . "user WHERE usertype_id <> 1 AND user_email = '". trim($user_email) ."' ";
		$rs  =  $this->runQuery($sQuery);
		$ret = "";

		$rw = mysql_fetch_array($rs);
		if ($rw)
		{
			$ret = $rw[0];
		}
		
		return $ret;
	} 
	function logoutUser()
	{	
		$ret = '1';
		$this->removeSession(CLIENT_USER_ID);
		$this->removeSession(CLIENT_USER_USERNAME);
		$this->removeSession(CLIENT_USERTYPE_ID);
		$this->removeSession(CLIENT_USER_MEMBERSHIP_ID);
		
		return $ret;
	}
	
	function updateLastLogin($user_id)
	{
		$sQuery  =  "update ".DB_PREFIX."user set user_lastlogin = '".currentScriptDate()."' WHERE user_id = ".$user_id;
		
		$this->runQuery($sQuery);
	}
	
	function setSession($key,$value)
	{	
		if($GLOBALS["scope"] == "voter")
		{	
			$_SESSION[SESSION_VOTER_PREFIX . $key] = $value;
		}		
		else if ($GLOBALS["scope"] !=  "admin")
		{
			$_SESSION[SESSION_CLIENT_PREFIX . $key] = $value;
		}
		else
		{
			$_SESSION[SESSION_ADMIN_PREFIX . $key] = $value;
		}
	}
	
	function removeSession($key)
	{
		if ($GLOBALS["scope"] ==  "voter")
		{	
			$_SESSION[SESSION_VOTER_PREFIX . $key] = "";
			$_SESSION[SESSION_CLIENT_PREFIX . $key] = "";
		}
		else if ($GLOBALS["scope"] !=  "admin")
		{
			$_SESSION[SESSION_CLIENT_PREFIX . $key] = "";
		}
		else
		{
			$_SESSION[SESSION_ADMIN_PREFIX . $key] = "";
		}
	}
	
	function getSession($key)
	{
		$retval = "";
		
		if ($GLOBALS["scope"] ==  "voter")
		{
			if (!empty($_SESSION[SESSION_VOTER_PREFIX . $key]))
				$retval = $_SESSION[SESSION_VOTER_PREFIX . $key];
		}
		else if ($GLOBALS["scope"] ==  "judge")
		{
			if (!empty($_SESSION[SESSION_JUDGE_PREFIX . $key]))
				$retval = $_SESSION[SESSION_JUDGE_PREFIX . $key];
		}
		else if ($GLOBALS["scope"] !=  "admin")
		{
			if (!empty($_SESSION[SESSION_CLIENT_PREFIX . $key]))
				$retval = $_SESSION[SESSION_CLIENT_PREFIX . $key];
		}
		else
		{
			if (isset($_SESSION[SESSION_ADMIN_PREFIX . $key]))
				$retval = $_SESSION[SESSION_ADMIN_PREFIX . $key];
		}
		return $retval;
	
	}
	
	function isAuthorized($link = "login.php",$id = ADMIN_USER_ID)
	{
		if(isset($_REQUEST['uId']))
		{
			$this->chkSiteOfflineClient();
		}
		$msgobj = new message();
		if ($this->getSession($id)=="")
		{
			$strfrm = "";
			$msgerr = trim($msgobj->sendMsg($link,$strfrm,2));
			exit();
		}
		
		if(strpos($_SERVER['REQUEST_URI'],"client/")!= false && strpos($_SERVER['REQUEST_URI'],"client/")!=0)
		{	
			if(!isset($_REQUEST['uId']))
			{
				$this->logoutAdmin('client_admin');
				$msgobj->sendMsg("unauthorize.php","Login",75);
				exit();
			}
			
			$superAdminUserName = $this->getSuperContestAdminUsername();
			
			if($superAdminUserName!=$_REQUEST['uId'])
			{	
				$this->logoutAdmin('client_admin');
				$msgobj->sendMsg("unauthorize.php","Login",75);
				exit();
			}
		}
	}
	
	function isAuthorizedEntrant($link = "login.php",$id = ADMIN_USER_ID)
	{
		$msgobj = new message();
		if ($this->getSession($id)=="")
		{
			$strfrm = "";
			$msgerr = trim($msgobj->sendMsg($link,$strfrm,2));
			exit();
		}
	}
	
	function chkContestRelatedEntrant($link = "index.php",$contest_client_id,$user_client_id)
	{
		$msgobj = new message();
		if ($contest_client_id!=$user_client_id)
		{
			$strfrm = "";
			$this->logoutAdmin('entrant_user');
			$msgerr = trim($msgobj->sendMsg($link,$strfrm,6));
			exit();
		}
	}
	
	function chkContestRelatedJudge($link = "index.php",$contest_client_id,$user_client_id)
	{
		$msgobj = new message();
		if ($contest_client_id!=$user_client_id)
		{
			$strfrm = "";
			$this->logoutAdmin('judge_user');
			$msgerr = trim($msgobj->sendMsg($link,$strfrm,6));
			exit();
		}
	}

	function getSuperContestAdminUsername()
	{
		$clientIDVal = $this->fetchClientId($this->getSession(ADMIN_USER_USERNAME));
		
		$selUserQry ="SELECT u.user_username FROM ".DB_PREFIX."user u WHERE 1=1 AND u.client_id='".$clientIDVal."' AND user_type_id = '".USER_TYPE_SUPER_CLIENT_ADMIN."'";
		$res = mysql_query($selUserQry);
		$rs = mysql_fetch_assoc($res);
		return $rs['user_username'];
	}

	function fetchClientId($userName)
	{
		 $selUserQry ="SELECT u.client_id FROM ".DB_PREFIX."user u WHERE 1=1 AND u.user_username='".$userName."'";
		 $res = mysql_query($selUserQry);
		 $rs = mysql_fetch_assoc($res);
		 return $rs['client_id'];
	}

	function isAuthorizedClient($link = "login.php", $redirectionpage = "")
	{
		$msgobj = new message();
		if ($this->getSession(CLIENT_USER_ID)=="")
		{
			$_SESSION['redirectionto'] = $redirectionpage; 
			if ( $redirectionpage  !=   ""){
				$_SESSION['redirectionto'] = $redirectionpage;
			}
				
			header("location: " . $link);
			exit();
		}
	}
	
	function isClientLoggedin()
	{
		$ret  =  0;

		if (!isset($_SESSION[SESSION_CLIENT_PREFIX . CLIENT_USER_ID]))
			$_SESSION[SESSION_CLIENT_PREFIX . CLIENT_USER_ID]  =  "";

		if ($this->getSession(CLIENT_USER_ID)=="")
			$ret  =  0;
		else
			$ret  =  1;
			
		return $ret;
	}
	
	function isAdminLoggedin()
	{
		$ret  =  0;
		if (isset($_SESSION[SESSION_ADMIN_PREFIX . ADMIN_USER_ID]) && $_SESSION[SESSION_ADMIN_PREFIX . ADMIN_USER_ID] !=  "")
			$ret  =  1;
		else
			$ret  =  0;
			
		return $ret;
	}
		
	function padstring($str,$intChars)
	{
		$ret = "";
		if (strlen($str)>$intChars-3)
		{
			$ret = substr($str,0,$intChars-3);
			$ret = str_pad($ret, $intChars, ".", STR_PAD_RIGHT);  
		}
		else
		{
			$ret = $str;
		}
			
		return $ret;
	}
	
	function submitTo($valDest)
	{		  
		print "<html><head></head><body>";
		print "<form name = \"frmSubmit\" action = \"".$valDest. "\">"."\r\n";
		print "</form>"."\r\n";
		print "<script>"."\r\n";
		print "document.frmSubmit.submit();\r\n";
		print "</script>"."\r\n";
		print "</body></html>";	
	}
	
	function getPostedValuesAsHidden($strp = "0", $arexclude  =  array(""))
	{
		$hiddenVars = "";
		
		foreach($_POST as $k  =>  $v)
		{
			$name  =  $k;
			$value  =  $v;
			
			if (in_array($name, $arexclude))
				continue;
			
			if ($name == "err")
				continue; 
			
			if (is_array($_POST[$k]))
			{
				$value  =  implode(",",$_POST[$k]);
			}
			if ($strp=="1")	
			{
				$hiddenVars =  $hiddenVars . $this->getHiddenString($name,stripslashes($value));
			}
			else
			{
				$hiddenVars =  $hiddenVars . $this->getHiddenString($name,trim($value));
			}
			
		}
		return $hiddenVars;
	}

	function submitPostedValues($valdest,$hvars = "")
	{
		print "<html><head></head><body>";
		print "<form name = \"frmSubmit\" action = \"".$valdest. "\" method = 'POST'>"."\r\n";
		print $hvars;
		print "</form>"."\r\n";
		print "<script>"."\r\n";
		print "document.frmSubmit.submit();\r\n";
		print "</script>"."\r\n";
	 	print "</body></html>";	  
	}	
	
	
	function getHiddenString($vname,$strval)
	{
		// return "<input type = 'hidden' name = '" . trim($vname) . "' value = \"". htmlspecialchars($this->setVal($strval)) ."\">\r\n";
		//return "<input type = 'hidden' name = '" . trim($vname) . "' value = \"". htmlspecialchars($this->setValInput($strval)) ."\">\r\n";
		return "<input type = 'hidden' name = '" . trim($vname) . "' value = \"". htmlspecialchars($strval) ."\">\r\n";
	}
	
	function submitVal1($valDest,$strval)
	{
		print "<html><head></head><body>";
		print "<form name = \"frmSubmit\" action = \"".$valDest. "\" method = 'POST'>"."\r\n";
		print "<input type = 'hidden' name = 'err' value = '". $strval ."'>";
		print "</form>"."\r\n";
		print "<script>"."\r\n";
		print "document.frmSubmit.submit();\r\n";
		print "</script>"."\r\n";
		print "</body></html>";	
	}
	
	function getCurrentPageName()
	{
		$arPg = explode("/",$_SERVER['PHP_SELF']);
		$lastIndex = count($arPg)-1;
		$pgName = substr($arPg[$lastIndex],0,strlen($arPg[$lastIndex])-4);
		
		return $pgName.".php";
	}

	function getReferralPagename()
	{
		$arPg = split("/",$_SERVER['HTTP_REFERER']);
		$lastIndex = count($arPg)-1;
		//$pgName = substr($arPg[$lastIndex],0,strlen($arPg[$lastIndex])-4);
		$pgname  =  $arPg[$lastIndex];
		
		return $pgname;
	}

	function getReferralServerName()
	{
		$arPg = split("/",$_SERVER['HTTP_REFERER']);
		//$firstIndex = count($arPg)-1;
		$pgName = trim($arPg[0]);
		
		return $pgName;
	}
	
	function getFileContent($filename,$findstring = "",$replacestringS = "")
	{
		$filedata1  =  "";	
		$lines  =  file($filename);
		foreach ($lines as $line_num  =>  $line) 
		{
			$filedata1 = $filedata1.$line;
		}
		
		return str_replace($findstring,$replacestringS,$filedata1);
	}
	
	function isDuplicate($strtable,$strfield,$strval,$strpkfield = "",$strpkval = "",$strcond = "")
	{
		$retVal = false;

		if ($strcond !=  "")
		{
			$strcond = " And " . $strcond;
		}
		
		if ($strpkfield !=  "" && $strpkval !=  "")
		{
			$sQuery  =  "SELECT *  FROM ". DB_PREFIX . $strtable ." WHERE " . $strfield ." = '" . $strval ."' AND ".$strpkfield . "<> '".$strpkval."' ". $strcond;
		}
		else
		{
			$sQuery  =  "SELECT *  FROM ". DB_PREFIX . $strtable ." WHERE " . $strfield ." = '" . $strval ."'". $strcond;
		}
		
		$rs  =  $this->runQuery($sQuery);
		$total_record  =  mysql_num_rows($rs);
		
		if ($total_record>0)
		{
			$retVal = true;	
		}
		else
		{
			$retVal = false;
		}
	
		mysql_free_result($rs);
		return $retVal;	
	}	

	function setVal($str)
	{	
		if (!is_null($str) && $str  !=  "")
		{		
			/*$str  =  str_replace("&amp;","&",$str);
			$str  =  str_replace("&quot;","\"",$str);
			$str  =  str_replace("&#039;","'",$str);
			$str  =  str_replace("&lt;","<",$str);
			$str  =  str_replace("&gt;",">",$str);
	
			$str  =  str_replace("\\","",$str);
			$str  =  str_replace("&","&amp;",$str);
			$str  =  str_replace("\"","&quot;",$str);
			$str  =  str_replace("'","&#039;",$str);
			$str  =  str_replace("<","&lt;",$str);
			$str  =  str_replace(">","&gt;",$str);*/
			
			// commented as it replaces other fonts too and replaces with ? (question marks) 
			/*$str  =  str_replace("�", "\"", $str); 
			$str  =  str_replace("�", "\"", $str); 
			$str  =  str_replace("�", "'", $str); 

			$str  =  str_replace("“", "\"", $str); 
			$str  =  str_replace("�?", "\"", $str); 
			$str  =  str_replace("’", "'", $str); */

			$str  =  mysql_real_escape_string($str);
			
			// inserted on 27-03-2012
			$str  =  mb_convert_encoding($str,"UTF-8",mb_detect_encoding(trim($str)));
			//$str  = trim($str);
		}
	
		return $str;
	}
	function setValInput($str)
	{	
		if (!is_null($str) && $str  !=  "")
		{		
			$str  =  str_replace("&amp;","&",$str);
			$str  =  str_replace("&quot;","\"",$str);
			$str  =  str_replace("&#039;","'",$str);
			$str  =  str_replace("&lt;","<",$str);
			$str  =  str_replace("&gt;",">",$str);
	
			$str  =  str_replace("\\","",$str);
			$str  =  str_replace("&","&amp;",$str);
			$str  =  str_replace("\"","&quot;",$str);
			$str  =  str_replace("'","&#039;",$str);
			$str  =  str_replace("<","&lt;",$str);
			$str  =  str_replace(">","&gt;",$str);			
		}
	
		return $str;
	}
	
	function getVal($str)
	{	
		if (!is_null($str) && $str  !=  "")
		{
			$str  =  str_replace("&","&amp;",$str);
			$str  =  str_replace("\"","&quot;",$str);
			$str  =  str_replace("'","&#039;",$str);
			$str  =  str_replace("<","&lt;",$str);
			$str  =  str_replace(">","&gt;",$str);
	
			//$str  =  str_replace("\\","",$str);
			$str  =  str_replace("&amp;","&",$str);
			$str  =  str_replace("&quot;","\"\"",$str);
			$str  =  str_replace("&#039;","'",$str);
			$str  =  str_replace("&lt;","<",$str);
			$str  =  str_replace("&gt;",">",$str);		
		}
	
		return $str;
	}
	
	function readValue(&$input_value, $default_value=NULL)
	{
		if (isset($input_value))
			return stripslashes($input_value);
		else
			return stripslashes($default_value);
	}
	
	function readValueSubmission(&$input_value, $default_value=NULL)
	{
		if (isset($input_value))
			return stripslashes(htmlspecialchars($input_value));
		else
			return stripslashes(htmlspecialchars($default_value));
	}
	
	function readValueSubmissionDt(&$input_value, $default_value=NULL)
	{
		if (isset($input_value))
			return addslashes(htmlspecialchars($input_value));
		else
			return addslashes(htmlspecialchars($default_value));
	}
	
	function readValueDetail(&$input_value, $default_value=NULL)
	{
		if (isset($input_value))
			return html_entity_decode(htmlentities($input_value));
		else
			return html_entity_decode(htmlentities($default_value));
	}
	
	function readValueHTML(&$input_value, $default_value=NULL)
	{
		if (isset($input_value))
			return stripslashes(htmlspecialchars($input_value));
		else
			return stripslashes(htmlspecialchars($default_value));
	}
	
	function setHtmlValue($ctl,$value)
	{ 
		if (!empty($value) && !is_null($value) && $value !=  '') 
		{
			$strScrpt = "<script language = \"javascript\" type = \"text/javascript\">";
			$strScrpt .= $ctl . ".value  =  \"" .$value ."\";";
			//$strScrpt .= "alert(".$ctl. ".value)";
			$strScrpt .= "</script>";
		}
		else 
		{
			$strScrpt  =  "";
		}
			echo($strScrpt);
	}
	
	function startTran()
	{
		mysql_query("SET AUTOCOMMIT = 0")  or die(mysql_error());
		mysql_query("START TRANSACTION")  or die(mysql_error());
	}
	
	function endTran()
	{
		mysql_query("COMMIT")  or die(mysql_error());
		mysql_query("SET AUTOCOMMIT = 1")  or die(mysql_error());
	}
	
	function rollbackTran()
	{
		mysql_query("ROLLBACK")  or die(mysql_error());
		mysql_query("SET AUTOCOMMIT = 1")  or die(mysql_error());
	}
		
	function dateAdd($strDate,$intAddVal,$strAddPara = "d",$strFormat = "Y/m/d H:i:s",$strIFormat = "d/m/Y",$strSep = "/")
	{
	// strIFormat : Only Date Format
	// strSep : Only Date Seperater
	
	$arDate = split(" ",$strDate);
	
	$IDate  =  $arDate[0];
	$ITime  =  $arDate[1];
	
	if (count($arDate)>2)
	{
		$ITime = $arDate[1] . " " . $arDate[2];
	}	
	
		$d = "";
		$m = "";
		$y = "";
		
		if ($strFormat=="" || is_null($strFormat)==true)
		{
			$strFromat = 'm/d/Y';			
		}
		
		$s  =  split($strSep,$IDate);
		//print $s[0] . "," . $s[1] . "," . $s[2];
		switch($strIFormat)
		{
			case "Y/m/d":
				$d = $s[2];
				$m = $s[1];
				$y = $s[0];
				break;
			case "d/m/Y":
				$d = $s[0];
				$m = $s[1];
				$y = $s[2];
				break;
			case "m/d/Y":
				$d = $s[1];
				$m = $s[0];
				$y = $s[2];
				break;
		}
		
		$strTime = $ITime;
		if ($ITime=="")
		{
			$strTime = date("H:i:s");
		}
	
		$t  =  split(":",date("H:i:s",strtotime($strTime)));
		
		$h = $t[0];
		$n = $t[1];
		$s = $t[2];
		
		$valH = 0;
		$valI = 0;
		$valS = 0;
		
		$valD = 0;
		$valM = 0;
		$valY = 0;
		
		switch(strtolower($strAddPara))
		{
			case "y":
				$valY = $intAddVal;
				break;
			case "m":
				$valM = $intAddVal;
				break;
			case "d":
				$valD = $intAddVal;
				break;
			case "h":
				$valH = $intAddVal;
				break;
			case "i":
				$valI = $intAddVal;
				break;
			case "s":
				$valS = $intAddVal;
				break;
		}
		
		$dt  =  mktime($h+$valH,$n+$valI,$s+$valS,$m+$valM,$d+$valD,$y+$valY);
		$dt1  =  date($strFormat,$dt)	;
		return $dt1;
	}
		
	function fetchMailDetail($email_type,$client_id=0)
	{
		$sQuery = "SELECT * from ".DB_PREFIX."email_templates WHERE email_type='".$email_type."' AND client_id='".$client_id."' ";
		$rs  =  $this->runQuery($sQuery);
		
		if(mysql_num_rows($rs) > 0)
		{}
		else
		{
			$sQuery = "SELECT * from ".DB_PREFIX."email_templates WHERE email_type='".$email_type."' AND client_id='0' ";
			$rs  =  $this->runQuery($sQuery);
		}
		
		$rw  =  mysql_fetch_array($rs);
		return $rw;
	}	
	
	function fetchSuperAdminEmailID($user_type_id)
	{
		$sQuery = "SELECT user_email from ".DB_PREFIX."user_type ut, ".DB_PREFIX."user u WHERE ut.user_type_id=u.user_type_id ";
		$rs  =  $this->runQuery($sQuery);
		$rw  =  mysql_fetch_array($rs);
		return $rw;
	}
		
	function sendMail($from_name, $from_email, $to_name, $to_email, $subject, $body, $altbody  =  "", $arr_cc  =  array(), $arr_bcc  =  array(), $file = "")
	{
		$siteconfig  =  new siteConfig();
		
		$mail  =  new PHPMailer();		
		
		//comment below line for live
		$mail->IsSMTP();
		// $mail->IsMail(); 
		
		$mail->SMTPAuth  =  false;
		
		$mail->From        =  $from_email;
		$mail->FromName    =  $from_name;
		
		$mail->Subject     =  $subject;
		
		if ($altbody  !=   "")
			$mail->AltBody  =  $altbody; 
		else
			$mail->AltBody  =  "To view the message, please use an HTML compatible email viewer!";
	

		$mail->MsgHTML($body);
		
		//if ($siteconfig->siteconfig_mode == 1)	// If site is in testing mode then send all mails to specified testing e-mail address
		//	$mail->AddAddress($siteconfig->siteconfig_recipientemail, "");
		//else
			$mail->AddAddress($to_email, $to_name);
		
		//AddCC($address, $name  =  '')
		if (is_array($arr_cc))
		{
			if (count($arr_cc) > 0)
			{
				while(list($key, $val)  =  each($arr_cc))
				{
					if (trim($key)  !=   "")
					{
						$mail->AddCC($key, (trim($val) == "" ? "" : $val));					
					}					
				}
			}
		}		
		
		//AddBCC($address, $name  =  '')
		if (is_array($arr_bcc))
		{
			if (count($arr_bcc) > 0)
			{
				while(list($key, $val)  =  each($arr_bcc))
				{
					if (trim($key)  !=   "")
					{
						$mail->AddBCC($key, (trim($val) == "" ? "" : $val));					
					}					
				}
			}
		}		
		if (trim($file) !=  "")
			$mail->AddAttachment($file);
			
		return $mail->Send();	// Uncomment this line AND comment below line to send e-mail
		//return true;
	}	
	
	function phpMailer ($email_to, $subject, $message, $email_to_name = '', $email_from = '', $email_from_name = 'Election Impact', $email_cc = '', $email_cc_name = '', $email_bcc = '', $email_bcc_name = '', $html_mail = true) {
       
	   $transactional_mailing = 1;
	   
	   if($transactional_mailing == 1)
	   {
	   
			// the location of the wsdl file
			$wsdlLocation = TRANSACTIONAL_MAIL_SERVER_PATH;
			
			$username = STRONGMAIL_USERNAME;
			$password = STRONGMAIL_PASSWORD;
			$mailingName = 'ElectionImpactDefaultMailTextHtml';
			
			ini_set("soap.wsdl_cache_enabled", "0"); 

			
			$client = new SoapClient($wsdlLocation, array('trace' => 1));
			//EmailAddress::UniqueId::FirstName::LastName::Username::Password::URL::FromName::FromEmail::ReplyEmail::BounceEmail::SubjectLine::MailBody 
						
			$sMessageBody = file_get_contents(EMAIL_TEMPLATE_COMMON);
			$sMessageBody = str_replace("{message_body}",$message,$sMessageBody);
			$sMessageBody = str_replace('{SERVER_ADMIN_HOST}',SERVER_ADMIN_HOST,$sMessageBody);		
							
			$sMessageBody = str_replace("\n","",$sMessageBody);
$records = "$email_to::''::$email_to_name::''::''::''::''::Election Impact::$email_from::support@votenet.com::support@votenet.com::$subject::$sMessageBody";

			$params = array(
				'Credentials'=>array(
					'UserName'=>$username,
					'Password'=>$password
				),
				'MailingName'=>$mailingName,
				'Records'=>$records
			);
			
			
			// make our call to the SOAP client
			$result = $client->Send($params);
			
			//response
			if (is_soap_fault($result)) 
			{
				// trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring})", E_USER_ERROR);
				return 0;
			} else {
				return 1;
			}
	   }
	   else
	   {
				$sMessageBody = file_get_contents(EMAIL_TEMPLATE_COMMON);
				$sMessageBody = str_replace("{message_body}",$message,$sMessageBody);
				$sMessageBody = str_replace('{SERVER_ADMIN_HOST}',SERVER_ADMIN_HOST,$sMessageBody);		
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers.= 'From: '.$email_from . "\r\n" .
					'Reply-To: '.$email_from . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

				mail($email_to, $subject, $sMessageBody, $headers);
				
				return 1;
		}		        
    }
	
	function formatDateTime($strDate,$strFormat,$strIFormat = "d/m/Y",$strSep = "/")
	{	
		$arDate = split(" ",$strDate);
		$IDate  = "";
		$ITime  = "";

		$IDate  =  $arDate[0];
		if (count($arDate)>1)
		{
			$ITime  =  $arDate[1];
		}
		if (count($arDate)>2)
		{
			$ITime = $arDate[1] . " " . $arDate[2];
		}
		
		$d = "";
		$m = "";
		$y = "";
		
		if ($strFormat=="" || is_null($strFormat)==true)
		{
			$strFromat = 'm/d/Y';		
		}
		
		$s  =  split($strSep,$IDate);
		
		switch($strIFormat)
		{
			case "Y-m-d":
			case "Y/m/d":
				$d = $s[2];
				$m = $s[1];
				$y = $s[0];
				break;
			case "d/m/Y":
				$d = $s[0];
				$m = $s[1];
				$y = $s[2];
				break;
			case "m/d/Y":
				$d = $s[1];
				$m = $s[0];
				$y = $s[2];
				break;
		}
		
		$strTime = $ITime;
		
		if ($ITime=="")
		{
			$strTime = date("H:i:s");
		}
	
		$t  =  split(":",date("H:i:s",strtotime($strTime)));
		
		$h = $t[0];
		$n = $t[1];
		$s = $t[2];
		

		//print $h."-".$n."-".$s."-".$m."-".$d."-".$y;
		$dt  =  mktime($h,$n,$s,$m,$d,$y);
		$dt1  =  date($strFormat,$dt)	;
		return $dt1;
	}
	
	function dateTimeFormat($strDate,$strFormat = '%M %d, %Y')
	{
		$sQuery = "SELECT DATE_FORMAT('".$strDate."','". $strFormat ."')";
		$rs  =  $this->runQuery($sQuery);
		$rw  =  mysql_fetch_array($rs);
		return $rw[0];
	}
	
	function dateTimeFormatMonth($strDate,$strFormat = '%M %d, %Y')
	{
		$sQuery = "SELECT DATE_FORMAT( str_to_date( '".$strDate."', '%m/%d/%Y' ) , '". $strFormat ."' )";
		$rs  =  $this->runQuery($sQuery);
		$rw  =  mysql_fetch_array($rs);
		return $rw[0];
	}
	
	function dateTimeFormatYearChk($strDate,$strFormat = '%M %d, %Y')
	{
		$sQuery = "SELECT DATE_FORMAT( str_to_date( '".$strDate."', '%Y-%m-%d' ) , '". $strFormat ."' )";
		$rs  =  $this->runQuery($sQuery);
		$rw  =  mysql_fetch_array($rs);
		return $rw[0];
	}
	
	function dateTimeFormatMonthAMPM($strDate,$strFormat = '%M %d, %Y')
	{
		$sQuery = "SELECT DATE_FORMAT( str_to_date( '".$strDate."', '%Y-%m-%d %H:%i:%s' ) , '". $strFormat ."' )";
		$rs  =  $this->runQuery($sQuery);
		$rw  =  mysql_fetch_array($rs);
		return $rw[0];
	}
	
	function dateToTimestamp($strDate,$strIFormat = "d/m/Y",$strSep = "/")
	{	
		$arDate = split(" ",$strDate);
		$IDate  = "";
		$ITime  = "";

		$IDate  =  $arDate[0];
		if (count($arDate)>1)
		{
			$ITime  =  $arDate[1];
		}
		if (count($arDate)>2)
		{
			$ITime = $arDate[1] . " " . $arDate[2];
		}
		
		$d = "";
		$m = "";
		$y = "";
		
		$s  =  split($strSep,$IDate);
		
		switch($strIFormat)
		{
			case "Y-m-d":
			case "Y/m/d":
				$d = $s[2];
				$m = $s[1];
				$y = $s[0];
				break;
			case "d/m/Y":
				$d = $s[0];
				$m = $s[1];
				$y = $s[2];
				break;
			case "m/d/Y":
				$d = $s[1];
				$m = $s[0];
				$y = $s[2];
				break;
		}
		
		$strTime = $ITime;
		
		if ($ITime=="")
		{
			$strTime = date("H:i:s");
		}
	
		$t  =  split(":",date("H:i:s",strtotime($strTime)));
		
		$h = $t[0];
		$n = $t[1];
		$s = $t[2];
		
		//print $h."-".$n."-".$s."-".$m."-".$d."-".$y;
		return mktime($h,$n,$s,$m,$d,$y);
	}

	function now()
	{
		return date("Y-m-d H:i:s");
	}
	
	function currentDate()
	{
		/*$sQuery = "SELECT now() as currentDate";
		$res = mysql_query($sQuery);
		$rs = mysql_fetch_assoc($res);
		return $rs['currentDate'];*/
		return date("Y-m-d H:i:s");
	}
	
	function debug($str,$exit = "n")
	{
		print $str;
		if ($exit=="y")
			exit();			
	}
	
	function display($aVar, $doExit = 0, $showType = 0)
	{
		if ($showType == 0)
		{
			print "<pre>";
			print_r($aVar);
			print "</pre>";
			if ($doExit == 1)
			{
				exit();
			}
		}
		elseif ($showType == 1)
		{
			print "<pre>";
			var_dump($aVar);
			print "</pre>";
			if ($doExit == 1)
			{
				exit();
			}
		}
	}

	/**
	 * Execute any query in the site & return the resource of result
	 *
	 * @param string $sQuery
	 * @return Result Resource
	 */
	function runQuery($sQuery)
	{
		$rResult  =  mysql_query($sQuery)  or die(mysql_error());
		return $rResult;
	}
	
	function checkPostMethod($redirect)
	{
		if (strtolower(trim($_SERVER['REQUEST_METHOD']))  !=   "post")
		{	
			header ('Location: '. $redirect);
			exit();
		}
	}	
	
	function checkReferral($refferal, $redirect)
	{
		if (strtolower(trim($this->getReferralPagename()))  !=   strtolower(trim($refferal)))
		{	
			header ('Location: '. $redirect);
			exit();
		}
	}
	
	function showError($msg)
	{
		$ret  =  "";
		$ret  =  str_replace("\\","",$msg);
		$ret  =  str_replace("&quot;","",$ret);
		
		return $ret;
	}
	
	function validateDeletedIds($id, $tables)
	{
		$deletable  =  true;
		
		foreach ($tables as $table)
		{			
			$condition  =  "";
			if (isset($table['condition']))
				$condition  =  $table['condition'];
				
			$sQuery  =  "SELECT count(*) AS count FROM ".DB_PREFIX.$table['table']." WHERE ". $table['field']." = ".$id." ".$condition;
			$rs  =  $this->runQuery($sQuery);
			while ($tmp  =  mysql_fetch_assoc($rs))
			{
				if ($tmp['count']>0) $deletable  =  false;
			}
		}
		
		return $deletable;
	}
	
	function _changeKeys($arr, $sep)
	{
		$return  =  array();
		
		if (is_array($arr))
		{
			foreach($arr as $key => $value)
			{
				array_push($return,$sep.$value.$sep);
			}
		}		
			
		return $return;	
	}
	
	function _extractPostValues($request, $fields)
	{
		$return  =  array();
	
		if (is_array($request))
		{	
			if (is_array($fields))
			{
				foreach($fields as $key => $value)		
				{			
					if (array_key_exists($value, $request))
						$return[$value]  =  trim($request[$value]);
					else
						$return[$value]  =  '';
				}
			}
		}
		
		return $return;
	}
	
	function timestamp()
	{
		return date("Y") . date("m") . date("d") . date("H") . date("i") . date("s");
	}
	
	function checkMatchingValue($value, $table, $matchfield, $retrunfield)
	{
		$sQuery  =  "SELECT ".$retrunfield." FROM ".$table." WHERE ".$matchfield." LIKE '".$value."'";
		$rs  =  $this->runQuery($sQuery);
		
		if (is_resource($rs) && mysql_num_rows($rs)==1)
		{
			$row  =  mysql_fetch_assoc($rs);
			return $row[$retrunfield];
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)>1)
		{
			return "more then one value";
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)==0)
		{
			return "no matching value";
		}
		else 
		{
			return false;
		}
	}
	
	function checkMatchingValueNew($value, $table, $matchfield, $firstfield,$otherfld)
	{
		$sQuery  =  "SELECT * FROM ".$table." WHERE ".$matchfield." LIKE '".$value."' AND makeid = $firstfield AND modelid = $otherfld ";
		$rs  =  $this->runQuery($sQuery);
		
		if (is_resource($rs) && mysql_num_rows($rs)==1)
		{
			$row  =  mysql_fetch_assoc($rs);
			return true;
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)>1)
		{
			return "more then one value";
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)==0)
		{
			return "no matching value";
		}
		else 
		{
			return false;
		}
	}
	
	function checkMatchingValueGetId($value, $table, $matchfield, $retrunfield, $firstfield,$otherfld)
	{
		$sQuery  =  "SELECT $retrunfield FROM ".$table." WHERE ".$matchfield." LIKE '".$value."' AND makeid = $firstfield AND modelid = $otherfld ";
		$rs  =  $this->runQuery($sQuery);
		
		if (is_resource($rs) && mysql_num_rows($rs)==1)
		{
			$row  =  mysql_fetch_assoc($rs);
			return $row[$retrunfield];
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)>1)
		{
			return "more then one value";
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)==0)
		{
			return "no matching value";
		}
		else 
		{
			return false;
		}
	}
	
	function checkMatchingValueColor($value, $table, $matchfield, $firstfield,$otherfld,$interior)
	{
		
		$sQuery  =  "SELECT * FROM ".$table." WHERE ".$matchfield." LIKE '".$value."' AND makeid = $firstfield AND modelid = $otherfld AND (colortype = $interior or colortype = 2)";
		$rs  =  $this->runQuery($sQuery);

		if (is_resource($rs) && mysql_num_rows($rs)==1)
		{
			$row  =  mysql_fetch_assoc($rs);
			return true;
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)>1)
		{
			return "more then one value";
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)==0)
		{
			return "no matching value";
		}
		else 
		{
			return false;
		}
	}
	
	function checkMatchingValueGetIdColor($value, $table, $matchfield, $retrunfield, $firstfield,$otherfld,$interior)
	{
		$sQuery  =  "SELECT $retrunfield FROM ".$table." WHERE ".$matchfield." LIKE '".$value."' AND makeid = $firstfield AND modelid = $otherfld AND (colortype = $interior or colortype = 2)";
		$rs  =  $this->runQuery($sQuery);
		
		if (is_resource($rs) && mysql_num_rows($rs)==1)
		{
			$row  =  mysql_fetch_assoc($rs);
			return $row[$retrunfield];
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)>1)
		{
			return "more then one value";
		}
		elseif (is_resource($rs) && mysql_num_rows($rs)==0)
		{
			return "no matching value";
		}
		else 
		{
			return false;
		}
	}

	function storeDbCompatiblevalue($str)
	{
		$str  =  str_replace("'","&#039;",$str);
		return $str;
	}
	
	function checkAccess($filename, $module, $redirectto = "")
	{
		if ($this->getSession(ADMIN_USER_ID)==1 || $this->getSession(ADMIN_USER_TYPE_ID)==3)	// Allow all menu to Super Admin
			return true;
		else
			$sQuery  =  "SELECT m.* FROM ".DB_PREFIX."menu m, ".DB_PREFIX."user_menu um WHERE m.menu_id = um.menu_id AND um.user_id = ".$this->getSession(ADMIN_USER_ID)." AND m.menu_page_name = '".$filename."' ";
			
			
//			$sQuery  =  "SELECT m.* FROM ".DB_PREFIX."menu m, ".DB_PREFIX."user_menu um WHERE m.menu_id = um.menu_id AND um.user_id = ".$this->getSession(ADMIN_USER_ID)." AND m.menu_page_name = '".$filename."' AND m.menu_module = '".$module."'";
			
		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			return true;
		}
		
		if (trim($redirectto) !=  "")
		{
			$msgobj  =  new message();
			$msgobj->sendMsg($redirectto,"",44);
		}
		else
			return false;
			
	}
	
	function checkAccessContest($filename, $module, $redirectto = "")
	{	
		if ($this->getSession(ADMIN_USER_TYPE_ID)==3)	// Allow all menu to Super Admin
			return true;
		else
			$sQuery  =  "SELECT am.* FROM ".DB_PREFIX."menu am, ".DB_PREFIX."user_menu um WHERE am.menu_id = um.menu_id AND um.user_id = ".$this->getSession(ADMIN_USER_ID)." AND am.menu_page_name = '".$filename."' ";
		
		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			return true;
		}
		
		if (trim($redirectto) !=  "")
		{
			$msgobj  =  new message();
			$msgobj->sendMsg($redirectto,"",44);
		}
		else
			return false;
			
	}
	
	function checkAccessAdmin($filename, $module, $redirectto = "")
	{	
		if ($this->getSession(SYSTEM_ADMIN_USER_ID)==1)	// Allow all menu to Super Admin
			return true;
		else
			$sQuery  =  "SELECT am.* FROM ".DB_PREFIX."admin_menu am, ".DB_PREFIX."admin_user_menu um WHERE am.admin_menu_id = um.admin_menu_id AND um.user_id = ".$this->getSession(SYSTEM_ADMIN_USER_ID)." AND am.admin_menu_page_name = '".$filename."' ";
		
		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			return true;
		}
		
		if (trim($redirectto) !=  "")
		{
			$msgobj  =  new message();
			$msgobj->sendMsg($redirectto,"",44);
		}
		else
			return false;
			
	}
	
	function getMenuLink($filename, $module, $linktext, $querystring = "", $icon = "",$li_required = false, $sep  =  "",$target = "_self")
	{
		$menu_link  =  "";
		$icon_text  =  "";
	
		if ($this->getSession(ADMIN_USER_ID) == 1 || $this->getSession(ADMIN_USER_TYPE_ID) == 3)	// Allow all menu to Super Admin
			$sQuery  =  "SELECT m.* FROM ".DB_PREFIX."menu m WHERE m.menu_page_name = '".$filename."'";
		else if(strtolower($linktext) == "edit" || strtolower($linktext) == "create")
			$sQuery  =  "SELECT m.* FROM ".DB_PREFIX."menu m, ".DB_PREFIX."user_menu um WHERE m.menu_id = um.menu_id AND um.user_id = ".$this->getSession(ADMIN_USER_ID)." AND m.menu_page_name = '".$filename."' AND m.menu_module = '".$module."' AND m.menu_name = '".$linktext."'";
		else	
			$sQuery  =  "SELECT m.* FROM ".DB_PREFIX."menu m, ".DB_PREFIX."user_menu um WHERE m.menu_id = um.menu_id AND um.user_id = ".$this->getSession(ADMIN_USER_ID)." AND m.menu_page_name = '".$filename."' AND m.menu_module = '".$module."'";

		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			if (trim($icon) !=  "")
				$icon_text  =  "<img src = '".MENU_ICONS.$icon."' title = '".$linktext."' alt = '".$linktext."' />&nbsp;";
			if ($li_required)
				$menu_link  =  $icon_text." <li><a href = '".$filename.$querystring."' title = '".$linktext."' target = '".$target."'>".$linktext."</a></li>";
			else
				$menu_link  =  $icon_text."<a href = '".$filename.$querystring."' title = '".$linktext."' target = '".$target."'>".$linktext."</a>";

			$menu_link .=  $sep;
		}
		
		return $menu_link;
	}
	
	function getClientMenuLink($filename, $module, $linktext, $querystring = "", $icon = "",$li_required = false, $sep  =  "",$target = "_self")
	{
		$menu_link  =  "";
		$icon_text  =  "";
		
		if ($this->getSession(ADMIN_USER_TYPE_ID) == 3)	// Allow all menu to Super Admin
			$sQuery  =  "SELECT am.* FROM ".DB_PREFIX."menu am WHERE am.menu_page_name = '".$filename."'";
		else if(strtolower($linktext) == "edit" || strtolower($linktext) == "create")	
			$sQuery  =  "SELECT am.* FROM ".DB_PREFIX."menu am, ".DB_PREFIX."user_menu um WHERE am.menu_id = um.menu_id AND um.user_id = ".$this->getSession(ADMIN_USER_ID)." AND am.menu_page_name = '".$filename."' AND am.menu_module  = '".$module."' AND am.menu_name = '".$linktext."'";
		else
			$sQuery  =  "SELECT am.* FROM ".DB_PREFIX."menu am, ".DB_PREFIX."user_menu um WHERE am.menu_id = um.menu_id AND um.user_id = ".$this->getSession(ADMIN_USER_ID)." AND am.menu_page_name = '".$filename."' AND am.menu_module  = '".$module."'";

		//echo $sQuery."<br>"; 
		//exit;
			
		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			if (trim($icon) !=  "")
				$icon_text  =  "<img src = '".MENU_ICONS.$icon."' title = '".$linktext."' alt = '".$linktext."' />&nbsp;";
			if ($li_required)
				$menu_link  =  $icon_text." <li><a href = '".$filename.$querystring."' title = '".$linktext."' target = '".$target."'>".$linktext."</a></li>";
			else
				$menu_link  =  $icon_text."<a href = '".$filename.$querystring."' title = '".$linktext."' target = '".$target."'>".$linktext."</a>";

			$menu_link .=  $sep;
		}
		
		return $menu_link;
	}
	
	function getAdminMenuLink($filename, $module, $linktext, $querystring = "", $icon = "",$li_required = false, $sep  =  "",$target = "_self")
	{
		$menu_link  =  "";
		$icon_text  =  "";
		$condition = "";
		if($linktext == "Edit" || $linktext == "Create")
			$condition = " AND am.admin_menu_name = '".$linktext."' ";
			 
		if ($this->getSession(SYSTEM_ADMIN_USER_ID) == 1)	// Allow all menu to Super Admin
			$sQuery  =  "SELECT am.* FROM ".DB_PREFIX."admin_menu am WHERE am.admin_menu_page_name = '".$filename."'".$condition;
		else
			$sQuery  =  "SELECT am.* FROM ".DB_PREFIX."admin_menu am, ".DB_PREFIX."admin_user_menu um WHERE am.admin_menu_id = um.admin_menu_id AND um.user_id = ".$this->getSession(SYSTEM_ADMIN_USER_ID)." AND am.admin_menu_page_name = '".$filename."' AND am.admin_menu_module = '".$module."'".$condition;

		//echo $sQuery."<br>"; 
		//exit;
			
		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			if (trim($icon) !=  "")
				$icon_text  =  "<img src = 'images/".$icon."' title = '".$linktext."' alt = '".$linktext."' />&nbsp;";
			if ($li_required)
				$menu_link  =  $icon_text." <li><a href = '".$filename.$querystring."' title = '".$linktext."' target = '".$target."'>".$linktext."</a></li>";
			else
				$menu_link  =  $icon_text."<a href = '".$filename.$querystring."' title = '".$linktext."' target = '".$target."'>".$linktext."</a>";

			$menu_link .=  $sep;
		}
		
		return $menu_link;
	}
	
	function getFirstAdminMenu($user_id,$menu_table = 'menu')
	{
		$page  =  "";
		
		if ($user_id==1)	// Allow all menu to Super Admin
			$sQuery  =  "SELECT am.* FROM " . DB_PREFIX . "admin_menu am WHERE am.admin_menu_parent_id = 0 AND am.admin_menu_isactive = 1 AND am.admin_menu_isvisible = 1 order by admin_menu_order ";
		else
			$sQuery  =  "SELECT am.* FROM " . DB_PREFIX . "admin_menu am, " . DB_PREFIX . "admin_user_menu um WHERE am.admin_menu_parent_id = 0 AND am.admin_menu_isactive = 1 AND am.admin_menu_isvisible = 1 AND am.admin_menu_id = um.admin_menu_id AND um.user_id = ".$user_id." order by admin_menu_order ";

		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			$rw  =  mysql_fetch_array($rs);
			
			$page  =  $this->getFirstAdminSubmenu($rw["admin_menu_id"], $user_id);
			
			if (trim($page)=="")	// If there is no sub menu for top level menu then use its own link
				$page  =  $rw["admin_menu_page_name"];
		}
		
		return $page;
	}
	
	function getFirstAdminSubmenu($menu_id, $user_id)
	{
		$page  =  "";
		if ($user_id==1)	// Allow all menu to Super Admin
			$sQuery  =  "SELECT am.admin_menu_page_name FROM " . DB_PREFIX . "admin_menu am WHERE am.admin_menu_parent_id = ".$menu_id." AND am.admin_menu_isactive = 1 AND am.admin_menu_isvisible = 1 order by admin_menu_isdefault desc,admin_menu_order asc";
		else
			$sQuery  =  "SELECT am.admin_menu_page_name FROM " . DB_PREFIX . "admin_menu am, " . DB_PREFIX . "admin_user_menu um WHERE am.admin_menu_parent_id = ".$menu_id." AND am.admin_menu_isactive = 1 AND am.admin_menu_isvisible = 1 AND am.admin_menu_id = um.admin_menu_id AND um.user_id = ".$user_id." order by admin_menu_isdefault desc,admin_menu_order asc";
			
		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			$rw  =  mysql_fetch_array($rs);
			$page  =  $rw["admin_menu_page_name"];
		}
		
		return $page;
	}
	
	function getFirstMenu($user_id,$menu_table = 'menu')
	{
		$page  =  "";
		
		if ($user_id==1 || ($this->getSession(ADMIN_USER_TYPE_ID)==USER_TYPE_SUPER_CLIENT_ADMIN))	// Allow all menu to Super Admin
			$sQuery  =  "SELECT m.* FROM " . DB_PREFIX . "menu m WHERE m.menu_parent_id = 0 AND m.menu_isactive = 1 AND m.menu_isvisible = 1 order by menu_order ";
		else
			$sQuery  =  "SELECT m.* FROM " . DB_PREFIX . "menu m, " . DB_PREFIX . "user_menu um WHERE m.menu_parent_id = 0 AND m.menu_isactive = 1 AND m.menu_isvisible = 1 AND m.menu_id = um.menu_id AND um.user_id = ".$user_id." order by menu_order";

		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			$rw  =  mysql_fetch_array($rs);
			
			$page  =  $this->getFirstSubmenu($rw["menu_id"], $user_id);
			
			if (trim($page)=="")	// If there is no sub menu for top level menu then use its own link
				$page  =  $rw["menu_page_name"];
		}
		
		return $page;
	}
	
	function getFirstSubmenu($menu_id, $user_id)
	{
		$page  =  "";
		if ($user_id==1 || ($this->getSession(ADMIN_USER_TYPE_ID)=="3"))	// Allow all menu to Super Admin
			$sQuery  =  "SELECT m.menu_page_name FROM " . DB_PREFIX . "menu m WHERE m.menu_parent_id = ".$menu_id." AND m.menu_isactive = 1 AND m.menu_isvisible = 1 order by menu_isdefault desc,menu_order asc";
		else
			$sQuery  =  "SELECT m.menu_page_name FROM " . DB_PREFIX . "menu m, " . DB_PREFIX . "user_menu um WHERE m.menu_parent_id = ".$menu_id." AND m.menu_isactive = 1 AND m.menu_isvisible = 1 AND m.menu_id = um.menu_id AND um.user_id = ".$user_id." order by menu_isdefault desc,menu_order asc";
		$rs  =  $this->runQuery($sQuery);
		
		if (mysql_num_rows($rs)>0)
		{
			$rw  =  mysql_fetch_array($rs);
			$page  =  $rw["menu_page_name"];
		}
		
		return $page;
	}
	
	function isRecordExists($strtable, $strfield, $strval, $strcond  =  "")
	{
		$retVal  =  false;		
		
		if (trim($strfield)  !=   "" && trim($strval)  !=   "")
		{
			$sQuery  =  "SELECT count(*) total FROM ". DB_PREFIX . $strtable ." WHERE " . $strfield ." = '" . $strval ."' ";
		}
		
		if ($strcond  !=   "")
		{
			$sQuery .=  " " . $strcond;
		}	
		
		$rs  =  $this->runQuery($sQuery);
		$total_record  =  mysql_num_rows($rs);
		
		if ($total_record > 0)
		{
			while ($row  =  mysql_fetch_assoc($rs))
			{
				if ($row['total'] > 0)
					$retVal = true;						
			}
		}
	//echo $sQuery;print_r($retVal);exit;
		mysql_free_result($rs);
		return $retVal;	
	}	
	
	function isRecordExistsReport($strtable, $strfield, $strval, $strcond  =  "")
	{
		$retVal  =  false;		
		
		if (trim($strfield)  !=   "" && trim($strval)  !=   "")
		{
			$sQuery  =  "SELECT count(*) total FROM ". REPORT_DB_PREFIX . $strtable ." WHERE " . $strfield ." = '" . $strval ."' ";
		}
		
		if ($strcond  !=   "")
		{
			$sQuery .=  " " . $strcond;
		}	
		
		$rs  =  $this->runQuery($sQuery);
		$total_record  =  mysql_num_rows($rs);
		
		if ($total_record > 0)
		{
			while ($row  =  mysql_fetch_assoc($rs))
			{
				if ($row['total'] > 0)
					$retVal = true;						
			}
		}
	//echo $sQuery;print_r($retVal);exit;
		mysql_free_result($rs);
		return $retVal;	
	}	
	
	function getCurrentModule($pagename, $find = "", $replace = "")
	{
		$ret  =  str_replace($find.".php", $replace, $pagename);
		
		$ret  =  str_replace("audience_listing", "", $ret);
		// $ret  =  str_replace("list", "", $ret);
		$ret  =  str_replace("addedit", "", $ret);	
		
		if(strpos($ret,"details")=== false && strpos($ret,"detailed")=== false)
			$ret  =  str_replace("detail", "", $ret);				
		$ret  =  str_replace("access", "", $ret);								

		return $ret;
	}
	
	function fillCombo($table, $sql = "", $value, $display, $selected, $condition)
	{	
		if (trim($sql) == "")
		{
			$sQuery  =  "SELECT $value, $display FROM ".DB_PREFIX."$table WHERE 1 ";
			
			if ($condition  !=   "")
			{
				$sQuery .=  " " .$condition . " ";
			}			
			
			$sQuery .=  " order by ". $display;			
		}
		else
		{
			$sQuery  =  $sql;			
		}		
		
		$rs  =  $this->runQuery($sQuery);
	
		if (mysql_num_rows($rs)>0)
		{
			while ($row  =  mysql_fetch_array($rs))
			{
				print "<option value = '". $row[$value] . "' ";
	
				if ($selected == $row[$value]) { print "selected = \"selected\""; }
				print ">" . $row[$display] . "</option>";
			}	
			
			mysql_free_result($rs);
		}	
	}
	
	/// functions to get site statistic
	function getTotalFromTable($table,$condition)
	{
		$sQuery  =  "SELECT count(*)as cnt FROM ".DB_PREFIX.$table." WHERE 1 = 1 ".$condition;
		$rs  =  $this->runQuery($sQuery);
		$rw  =  mysql_fetch_array($rs);
		return $rw["cnt"];
	}	
	
	function drawHeading($heading, $img = "", $sub_heading_html = "")
	{
		if (trim($img) !=  "")
			$img_html  =  '<td width = "48"><img src = "images/icons/'.$img.'" align = "absmiddle" title = "'.$heading.'" alt = "'.$heading.'" class = "subpage-title-image" /></td>';
		else
			$img_html  =  "";
		$html  =  '<div class = "subpage-title">
					<table cellpadding = "0" cellspacing = "0" width = "100%">
						<tr>
							<td align = "left">'.$img_html.'</td>
							<td align = "left" valign = "top">
							<h1>'.$heading.'</h1>
							'.$sub_heading_html.'
							</td>
						</tr>
					</table>
				</div>';
		return $html;
	}
	
	function getCurrentPageUrl()
	{
		$page_url  =  'http';
		
		if (strpos($_SERVER['SERVER_PROTOCOL'],"https") !== false) 
		{
			$page_url .=  "s";
		}
		$page_url .=  "://";
		if ($_SERVER["SERVER_PORT"]  !=   "80")
		{
			$page_url .=  $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else
		{
			$page_url .=  $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		
		return $page_url;
	}
	
	function reportAbuseLink($section, $title, $url  =  "")
	{
		if ($this->isClientLoggedin()==1)
		{
			if (trim($url)=="")
				$url  =  $this->getCurrentPageUrl();
		
			$html  =  "<form action = \"report_abuse.php\" method = \"post\">
						<input type = \"hidden\" id = \"url\" name = \"url\" value = \"".$url."\" />
						<input type = \"hidden\" id = \"section\" name = \"section\" value = \"".$section."\" />
						<input type = \"hidden\" id = \"title\" name = \"title\" value = \"".$title."\" />
						<input type = \"submit\" class = \"btn-report-abuse\" value = \"Report Abuse\" />
					</form>";
			print $html;
		}
	}
	
	function checkOwner($user_id)
	{
		$ret  =  false;
		if ($this->isClientLoggedin()==1)
			$current_user_id  =  $this->getSession(CLIENT_USER_ID);
		else
			$current_user_id  =  0;
		
		if ($user_id == $current_user_id)
			$ret  =  true;
			
		return $ret;
	}

	function getReferralFileName()
	{
		$filename  =  "";
		if (isset($_SERVER['HTTP_REFERER']))
		{
			$arPg = split("/",$_SERVER['HTTP_REFERER']);
			$lastIndex = count($arPg)-1;
			//$pgName = substr($arPg[$lastIndex],0,strlen($arPg[$lastIndex])-4);
			$pgname  =  $arPg[$lastIndex];
			$arrfl  =  split("\?",$pgname);
			$filename  =  $arrfl[0];
		}
		return $filename;
	}
	
	function generateRandomKey($str)
	{
		$key  =  rand(11111111111111111, 9999999999999999);
		$key  =  md5($str).$key;
		
		return $key;
	}
	
	function generateRandomNumber($length=6,$level=2){
		
		   list($usec, $sec) = explode(' ', microtime());
		   srand((float) $sec + ((float) $usec * 100000));
		
		   $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
		   $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		   $validchars[3] = "0123456789@#$&abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$&";
		
		   $number  = "";
		   $counter   = 0;
		
		   while ($counter < $length) {
			 $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);
		
			 // All character must be different
			 if (!strstr($number, $actChar)) {
				$number .= $actChar;
				$counter++;
			 }
		   }
		
		   return $number;
		
	}

	
	function isEmail($email) 
	{
		return eregi("^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$", $email);
	}
	
	function checkFieldAccess($user_id, $field, $id = "")
	{
		include_once("clsuser_access.php");
		
		$objuser_access  =  new user_access();
		
		$ret  =  false;
	
		$current_user_id  =  $this->getSession(CLIENT_USER_ID);
		
		if (trim($current_user_id) == "")
			$current_user_id  =  0;
		
		$condition  =  " AND user_id = '".$user_id."' AND user_access_field = '".$field."'";
		
		if (trim($id) !=  "")
			$condition .=  " AND user_access_field_id = '".$id."'";
		
		$arr  =  $objuser_access->fetchAllAsArray("","",$condition);
		
		if (count($arr)>0)
		{	
			if ($arr[0]["user_access_type"]==1)
			{
				if ($this->is_my_connection($user_id) || $user_id == $current_user_id)
					$ret  =  true;
			}
			else
				$ret  =  true;
		}
		else
			$ret  =  true;
		
		return $ret;
	}
	
	function displayAccessDenied($message = "")
	{
		$html  =  '<table border = "0" width = "100%" style = "background:url(images/message.jpg) no-repeat;height:120px;">
                      	<tr>
                        	<td valign = "top" align = "left" width = "64" rowspan = "2" style = "padding:20px;">
                          	<img src = "images/icons/stop-64.png" />
                          </td>
                        </tr>
                        <tr>
                        	<td align = "left" valign = "top" style = "padding:15px 0px;">
                          	<table width = "100%" cellpadding = "5">
                            	<tr>
			                          <td valign = "top" align = "left" style = "color:#c30303;font-size:18px;font-weight:bold;">Access Denied.</td>
                              </tr>
                              <tr>
                              	<td style = "">
			                          	'.$message.'
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>';
		return $html;
	}
	
	function checkDirStructure($source, $structure, $create_if_not_exist  =  false)
	{
		$ret  =  true;
		
		$arr_dir  =  explode("/", $structure);
		
		for ($i = 0;$i<count($arr_dir);$i++)
		{
			if (!file_exists($source.$arr_dir[$i]))
			{
				$ret  =  false;
				if ($create_if_not_exist==true)
					if (mkdir($source.$arr_dir[$i], 0777))
					{
						$source  =  $source.$arr_dir[$i]."/";
					}
					else
					{
						break;
					}
			}
			else
				$source  =  $source.$arr_dir[$i]."/";
		}
		
		return $ret;
	}
	
	function displayFilesize($path)
	{
		$display_str  =  "";
		
		if (file_exists($path))
		{
			$size  =  filesize($path);
			
			if ($size >=  1024 && $size < 1048576)
				$display_str  =  round(($size/1024),2)." KB";
			else if ($size >=  1048576)
				$display_str  =  round(($size/1048576),2)." MB";
			else
				$display_str  =  $size." Bytes";
		}
		
		return $display_str;
	}
	
	function getFileName($path, $original_filename)
	{
		//$original_filename  =  $final_filename  =  preg_replace('`[^a-z0-9-_.]`i','',$filename);
		$final_filename  =  $original_filename;
		// rename file if it already exists by prefixing an incrementing number
		$file_counter  =  1;
		
		// loop until an available filename is found
		while (file_exists( DOCUMENTS.$objdocument->document_file_path.$final_filename ))
			$final_filename  =  $file_counter++.'_'.$original_filename; 
		
		return $final_filename;
	}	
	
	function getRealIpAddr()
	{
	    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    return $ip;
	}
	
	/**
	 * Get access flag for detail pages in listing
	 *
	 * @param string $pageUrl
	 * @param string $pageName
	 * @param int $fColSpan
	 * @param int $sColSpan
	 */
	function getAccess($pageUrl, $pageName, $fColSpan, $sColSpan=NULL)
	{
		$aAccess = array();

		if ($this->checkAccessAdmin($pageUrl, $pageName))
		{
			$aAccess[0] = 1;
			
		}
		else 
		{
			$aAccess[0] = 0;
			
			$fColSpan = --$fColSpan;
			
			if (!empty($sColSpan)) 
			{
				$sColSpan = $sColSpan--;	
			}
		}
		
		$aAccess[1] = $fColSpan;
		
		$aAccess[2] = $sColSpan;	
		
		return $aAccess;
		
	}
	
	function getAccessClient($pageUrl, $pageName, $fColSpan, $sColSpan=NULL)
	{
		$aAccess = array();

		if ($this->checkAccessContest($pageUrl, $pageName))
		{
			$aAccess[0] = 1;
			
		}
		else 
		{
			$aAccess[0] = 0;
			
			$fColSpan = --$fColSpan;
			
			if (!empty($sColSpan)) 
			{
				$sColSpan = $sColSpan--;	
			}
		}
		
		$aAccess[1] = $fColSpan;
		
		$aAccess[2] = $sColSpan;	
		
		return $aAccess;
		
	}
	
	function chkSiteOfflineClient()
	{
		$sQuery  =  "SELECT site_config_isonline,site_config_offline_message FROM " . DB_PREFIX . "site_config WHERE site_config_id = '1'";
		$rs  =  $this->runQuery($sQuery);
		$res = mysql_fetch_array($rs);
		if($res["site_config_isonline"]==1)
		{
			header("Location:".SERVER_CLIENT_HOST."offline.php");
			exit();
		}
	}
	
	/**
	 * Add Latest visited URL of any user
	 *
	 * @param int $userId
	 */
	function addLatestVisit($userId,$entityID,$maxRecoreds=10)
	{	
		$adminNotToAddVisit = array("dashboard.php","index.php","","/",
									"logout.php","admin_menu_list.php",
									"admin_menu.php","admin_menu_list.php",
									"resource_addedit.php","resource_list.php",
									"menu.php","menu_list.php",
									"entry_fee_transaction_addedit.php",
									"voter_user_import_db.php","stats_report_export.php","top_source_report_export.php",
									"voter_registration_export.php", "state_by_state_report_export.php", "date_wise_report_export.php", "monthly_report_export.php","active_days_report_export.php", "active_times_export_report.php"
									);
		
		$currentURL = basename($_SERVER['REQUEST_URI']);
		
		/**
		 * Check if request is not comming from dashboard, index(login) & logout
		 */
		
		if (!in_array($currentURL,$adminNotToAddVisit) && strpos($currentURL,"delete")=== false && strpos($currentURL,"cancel")=== false && strpos($currentURL,"admin_menu.php")=== false && strpos($currentURL,"menu.php")=== false && strpos($currentURL,"entry_fee_transaction_addedit.php")=== false && strpos($currentURL,"dashboard.php")=== false && strpos($currentURL,"resource_addedit.php")=== false && strpos($currentURL,"voter_user_import_db.php")=== false) 
		{
			$aUrls = $this->getLatestVisits($userId);
			
			$visitCount = count($aUrls);
			
			/**
			 * Check if already 10 records are there in visited URL, 
			 * if available then delete oldest record
			 */
			
			if(is_array($aUrls))
			{
				$aVisitedURLs = array();
			
				for($i=0;$i<count($aUrls);$i++)
				{
					$aVisitedURLs[] = $aUrls[$i]['visited_url'];
				}
				if (in_array($currentURL, $aVisitedURLs)) 
				{
					$sDeleteQuery  =  "DELETE FROM " . DB_PREFIX . "user_last_url_visits WHERE user_id = '".$userId."' AND visited_url = '".$currentURL."'";	
					
					$rs  =  $this->runQuery($sDeleteQuery);	

					// recalculate if the record is deleted.
					$aUrls = $this->getLatestVisits($userId);
					$visitCount = count($aUrls);
				}
			}
			
			if ($visitCount >= $maxRecoreds) 
			{
				$sDeleteQuery  =  "DELETE FROM " . DB_PREFIX . "user_last_url_visits WHERE user_id = '".$userId."' ORDER BY visited_date ASC LIMIT 1";	
				
				$rs  =  $this->runQuery($sDeleteQuery);
			}
			
			/**
			 * Insert current URL in visited URL table
			 */
			$sInsertQuery  =  "INSERT INTO ".DB_PREFIX."user_last_url_visits 
						
								(user_id, visited_url, visited_date) 
								
								values('".$userId."', '".$currentURL."','".currentScriptDate()."')";
			
			$rs  =  $this->runQuery($sInsertQuery);
		
		}
	}
	
	function getLatestVisits($userId,$limit=0)
	{
		//$sSelectQuery  =  "SELECT * FROM " . DB_PREFIX . "user_last_url_visits WHERE user_id = '".$userId."' ORDER BY visit_id DESC";
		//$sSelectQuery  =  "SELECT  DISTINCT(SUBSTR( visited_url, 1, (LOCATE( '.', visited_url ) -1 ))) as visited_url FROM " . DB_PREFIX . "user_last_url_visits WHERE user_id = '".$userId."' ORDER BY visit_id DESC";
		$sSelectQuery  =  "SELECT  DISTINCT( visited_url ) as visited_url FROM " . DB_PREFIX . "user_last_url_visits WHERE user_id = '".$userId."' ORDER BY visit_id DESC";
		if (is_numeric($limit) && $limit > 0)
			$sSelectQuery .= " limit $limit";
		
		
	//echo $sSelectQuery;
		$rs  =  $this->runQuery($sSelectQuery);
		
		$visitCount = mysql_num_rows($rs);
		
		if ($visitCount) 
		{
			$records = mysql_fetch_assoc($rs);	
			$i = 0;
			while ($records)
			{
				$aUrls[$i]['visited_url'] = $records['visited_url'];
				//$aUrls[$i]['baseurl'] = $records['baseurl'];
				//$aUrls[$i]['entity_id'] = $records['entity_id'];
				$records = mysql_fetch_assoc($rs);
				$i++;	
			}
			
			return $aUrls;
		}
		
	}
	
	function addOrdinalNumberSuffix($num) {    
		if (!in_array(($num % 100),array(11,12,13))){       
			switch ($num % 10) {        // Handle 1st, 2nd, 3rd         
				case 1:  return $num.'<sup>st</sup>';         
				case 2:  return $num.'<sup>nd</sup>';         
				case 3:  return $num.'<sup>rd</sup>';       
			}  }     
			return $num.'<sup>th</sup>';   
	} 
	
	function createFullAddress($address1,$address2,$city,$state,$zip,$country)
	{
		$addressString = '';
		if(trim($address1)!='') {
			$addressString.= trim($address1).", <br /> "; }
		if(trim($address2)!='') {
			$addressString.= trim($address2).", <br /> ";	}
		if(trim($city)!='') {
			$addressString.= trim($city)."<br /> ";	}
		if(trim($state)!='') {
			$addressString.= trim($state)." ".trim($zip)."<br /> ";	}
		if($country!=0) {
			$addressString.= $this->getContryNameById($country); }
		
		return $addressString;
			
	}
	
	/**
	 * Get all files in specific directory
	 *
	 * @param varchar $directory
	 * @return file array
	 */
	function getFileList ($directory) 
  	{

	    // create an array to hold directory list
	    $results = array();
	
	    // create a handler for the directory
	    $handler = opendir($directory);
	
	    // open directory and walk through the filenames
	    while ($file = readdir($handler)) {
	
	      // if file isn't this directory or its parent, add it to the results
	      if ($file != "." && $file != "..") {
	        $results[] = $file;
	      }
	
	    }
	
	    // tidy up: close the handler
	    closedir($handler);
	
	    // done!
	    return $results;
	
  	}

	/**
	* Truncates text.
	*
	* Cuts a string to the length of $length and replaces the last characters
	* with the ending if the text is longer than length.
	*
	* @param string  $text String to truncate.
	* @param integer $length Length of returned string, including ellipsis.
	* @param string  $ending Ending to be appended to the trimmed string.
	* @param boolean $exact If false, $text will not be cut mid-word
	* @param boolean $considerHtml If true, HTML tags would be handled correctly
	* @return string Trimmed string.
	*/
    function truncate_html($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false) {
        if ($considerHtml) {
            // if the plain text is shorter than the maximum length, return the whole text
            if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
           
            // splits all html-tags to scanable lines
            preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
   
            $total_length = strlen($ending);
            $open_tags = array();
            $truncate = '';
           
            foreach ($lines as $line_matchings) {
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
                if (!empty($line_matchings[1])) {
                    // if it's an "empty element" with or without xhtml-conform closing slash (f.e. <br/>)
                    if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                        // do nothing
                    // if tag is a closing tag (f.e. </b>)
                    } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                        // delete tag from $open_tags list
                        $pos = array_search($tag_matchings[1], $open_tags);
                        if ($pos !== false) {
                            unset($open_tags[$pos]);
                        }
                    // if tag is an opening tag (f.e. <b>)
                    } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                        // add tag to the beginning of $open_tags list
                        array_unshift($open_tags, strtolower($tag_matchings[1]));
                    }
                    // add html-tag to $truncate'd text
                    $truncate .= $line_matchings[1];
                }
               
                // calculate the length of the plain text part of the line; handle entities as one character
                $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
                if ($total_length+$content_length> $length) {
                    // the number of characters which are left
                    $left = $length - $total_length;
                    $entities_length = 0;
                    // search for html entities
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                        // calculate the real length of all entities in the legal range
                        foreach ($entities[0] as $entity) {
                            if ($entity[1]+1-$entities_length <= $left) {
                                $left--;
                                $entities_length += strlen($entity[0]);
                            } else {
                                // no more characters left
                                break;
                            }
                        }
                    }
                    $truncate .= substr($line_matchings[2], 0, $left+$entities_length);
                    // maximum lenght is reached, so get off the loop
                    break;
                } else {
                    $truncate .= $line_matchings[2];

                    $total_length += $content_length;
                }
               
                // if the maximum length is reached, get off the loop
                if($total_length>= $length) {
                    break;
                }
            }
        } else {
            if (strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = substr($text, 0, $length - strlen($ending));
            }
        }
       
        // if the words shouldn't be cut in the middle...
        if (!$exact) {
            // ...search the last occurance of a space...
            $spacepos = strrpos($truncate, ' ');
            if (isset($spacepos)) {
                // ...and cut the text in this position
                $truncate = substr($truncate, 0, $spacepos);
            }
        }
       
        // add the defined ending to the text
        $truncate .= $ending;
       
        if($considerHtml) {
            // close all unclosed html-tags
            foreach ($open_tags as $tag) {
                $truncate .= '</' . $tag . '>';
            }
        }
       
        return $truncate;
       
	}
	
	function downloadFile( $fullPath )
	{
		// Must be fresh start
		if( headers_sent() )
			die('Headers Sent');
		
		// Required for some browsers
		if(ini_get('zlib.output_compression'))
			ini_set('zlib.output_compression', 'Off');
		
		// File Exists?
		if( file_exists($fullPath) )
		{
			// Parse Info / Get Extension
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			
			// Determine Content Type
			switch ($ext) 
			{
				case "js"	: $ctype="application/x-javascript"; break;
				case "json"	: $ctype="application/json"; break;
				
				case "jpg"	:
				case "jpeg"	:
				case "jpe"	: $ctype="image/jpg"; break;
				
				case "gif"	: $ctype="image/gif"; break;
				case "png"	: $ctype="image/png"; break;
				case "bmp"	: $ctype="image/bmp"; break;
				case "tiff"	: $ctype="image/tiff"; break;
				
				case "css"	: $ctype="text/css"; break;
				
				case "xml"	: $ctype="application/xml"; break;
				
				case "doc"	:
				case "docx"	: $ctype="application/msword"; break;
				
				case "xls"	:
				case "xlt"	:
				case "xlm"	:
				case "xld"	:
				case "xla"	:
				case "xlc"	:
				case "xlw"	:
				case "xll"	: $ctype="application/vnd.ms-excel"; break;
				
				case "ppt"	:
				case "pps"	: $ctype="application/vnd.ms-powerpoint"; break;
				
				case "rtf"	: $ctype="application/rtf"; break;
				
				case "pdf"	: $ctype="application/pdf"; break;
				
				case "html"	:
				case "htm"	:
				case "php"	: $ctype="text/html"; break;
				
				case "txt"	: $ctype="text/plain"; break;
				
				case "mpeg"	:
				case "mpg"	:
				case "mpe"	: $ctype="video/mpeg"; break;
				
				case "mp3"	: $ctype="audio/mpeg3"; break;
				
				case "wav"	: $ctype="audio/wav"; break;
				
				case "aiff"	:
				case "aif"	: $ctype="audio/aiff"; break;
				
				case "avi"	: $ctype="video/msvideo"; break;
				
				case "wmv"	: $ctype="video/x-ms-wmv"; break;
				
				case "mov"	: $ctype="video/quicktime"; break;
				
				case "zip"	: $ctype="application/zip"; break;
				
				case "tar"	: $ctype="application/x-tar"; break;
				
				case "swf"	: $ctype="application/x-shockwave-flash"; break;
				
				default		: $ctype="application/force-download";
			}
			
			header("Pragma: public"); // required
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false); // required for certain browsers
			header("Content-Type: $ctype");
			header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".$fsize);
			ob_clean();
			flush();
			readfile( $fullPath );			
		} 
		else
			die('File Not Found');		
	}
	
	/**
	 * Function to sort multidimensional array
	 * @params 	[1] array $aTemp - An array which you want to sort, 
	 * 			[2] string $sKey - Key Value by which you want sort an array 
	 *
	 */
	function multisort($aTemp, $sKey)
	{
		$GLOBALS["sKey"]=$sKey;
		
		function cmp($a, $b)
		{
			$sKey = $GLOBALS['sKey'];
			
			if ($a == $b) 
			{
				return 0;
			}
			return (strtotime($a[$sKey]) < strtotime($b[$sKey])) ? -1 : 1;
		}
		
		usort($aTemp, "cmp");
		
		return $aTemp;
	}
	
	function addSponsorsInEmails($contest_id)
	{
		$strquery="SELECT c.issponsors_in_email FROM ".DB_PREFIX."contest c WHERE 1=1 AND c.contest_id='".$contest_id."' ";
		$rs=mysql_query($strquery);
		$res = mysql_fetch_assoc($rs);
		
		$strquery="SELECT s.sponsors_name,s.sponsors_logo FROM ".DB_PREFIX."sponsors s WHERE 1=1 AND s.contest_id='".$contest_id."' ";
		$rs=mysql_query($strquery);
		
		$i = 0;
		$sponsors = "";
		if($res["issponsors_in_email"]==1)
		{
			$sponsors = "<table><tr>";
			while($artf_sponsors= mysql_fetch_array($rs))
			{	
				if($i%5==0)
				{
					$sponsors.= "</tr><tr>";
				}
				
				$imageSize = getimagesize(SERVER_ROOT."common/files/sponsors/".$artf_sponsors['sponsors_logo']);
				
				if($imageSize[0]>$imageSize[1])
				{
					$sponsors.= "<td align='center'><img src='".SERVER_HOST."common/files/sponsors/".$artf_sponsors['sponsors_logo']."' alt='".$artf_sponsors['sponsors_name']."'  title='".$artf_sponsors['sponsors_name']."' width='120'/></td>";
				}
				else
				{
					$sponsors.= "<td align='center'><img src='".SERVER_HOST."common/files/sponsors/".$artf_sponsors['sponsors_logo']."' alt='".$artf_sponsors['sponsors_name']."'  title='".$artf_sponsors['sponsors_name']."' height='90'/></td>";
				}
				$i++;
			}
			$sponsors.= "</tr></table>";
		}
		return $sponsors;
	}
	
	function checkPaymentStatusByClientId($client_id)
	{
		$sql="select * from ".DB_PREFIX."client_payment where client_id='".$this->plan_id."' order by client_payment_id desc";
		$res=mysql_query($sql);
		$data=mysql_fetch_assoc($res);
		
		return $data['payment_status'];
	}
}
function currentScriptDate()
{
	// date_default_timezone_set('America/New_York');
	return date("Y-m-d H:i:s");
}

function currentScriptDateOnly()
{
	// date_default_timezone_set('America/New_York');
	return date("Y-m-d");
}

function createRandomCode() 
{
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";

    srand((double)microtime()*1000000);

    $i = 0;

    $randomcode = '' ;
	
	while ($i <= 7) 
	{
	    $num = rand() % 33;
	    $tmp = substr($chars, $num, 1);
	    $randomcode = $randomcode . $tmp;
	    $i++;
	}

	return $randomcode;
}

function createVoterUsername() 
{
    $voter_username = "PublicVoter_".mktime()."_".str_replace(".","_",$_SERVER['REMOTE_ADDR']);
	return $voter_username;
}

function getLowerDate($date1, $date2)
{
	if(strtotime($date1) > strtotime($date2))
		return $date2;
	else
		return $date1;
}

function ismobile()
{	
	$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		return true;
	
	if(strpos($_SERVER['HTTP_USER_AGENT'],'iPad'))
		return true;
	return false;
}

function findDomainName()
{
	$domain = $_REQUEST['domain'];
	$pos = strpos($_SERVER['HTTP_HOST'], CURRENT_DOMAIN);
	if($pos===false)
	{
		$domain = $_SERVER['HTTP_HOST'];
	}
	else
	{ 
		$domain = $_REQUEST['domain'];
	}
	
	return $domain;
}
?>