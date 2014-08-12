<?php
class scheduler extends common
{
	//Property
	var $email_send_cron_id;
	var $email_send_date;
	var $email_send_end_date;
	
	var $email_send_cron_detail_id;
	var $email_type;
	var $email_templates_name;
	var $email_send_detail_date;
	var $total_mails;
	
	function scheduler()
	{
		$this->email_send_cron_id = 0;
		$this->email_send_date = "";
		$this->email_send_end_date = "";
		
		$this->email_send_cron_detail_id = 0;
		$this->email_send_cron_id = 1;
		$this->email_type = "";
		$this->email_templates_name = "";
		$this->email_send_detail_date = "";
		$this->total_mails = 0;
	}
	
	function addEmailSendCron()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."email_send_cron
					( email_send_date ) values
					( '".currentScriptDate()."' )";
		
		$this->runquery($sQuery);
		$this->email_send_cron_id  =  mysql_insert_id();
		return mysql_insert_id();
	}
	
	function updateEmailSendCron()
	{
		$sQuery  =  "UPDATE ".DB_PREFIX."email_send_cron SET
					email_send_end_date = '".currentScriptDate()."' WHERE email_send_cron_id='".$this->email_send_cron_id."' ";
		$this->runquery($sQuery);
	}
	
	function addEmailSendCronDetail()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."email_send_cron_detail
					( email_send_cron_id, email_type, email_templates_name, email_send_detail_date, total_mails ) values
					( '".$this->email_send_cron_id."', '".$this->email_type."', '".$this->email_templates_name."', '".currentScriptDate()."', '".$this->total_mails."' )";
		
		$this->runquery($sQuery);
		$this->email_send_cron_detail_id  =  mysql_insert_id();
		return mysql_insert_id();
	}
	
	//Function to retrieve records of contest
	function fetchContestRecords($condition = "",$order = "contest_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$sQuery = "SELECT contest_id,client_id,contest_title,domain,winner_announce_date FROM ".DB_PREFIX."contest WHERE 1 = 1 AND contest_status='1' " . $condition . " ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);
		
		return $rs;
	}
	
	//Function to retrieve Contest entry submission completion advance notification to Entrant User
	function fetchEntrantsForAdvanceInfo($condition = "",$order = "user_id")
	{
		$arrlist  =  array();
		$i  =  0;
		
		$condition = explode("||##||",$condition);
		
		$sQuery = "SELECT u.user_id,u.client_id,u.user_username,u.user_firstname,u.user_lastname,u.user_email FROM ".DB_PREFIX."user u WHERE 1 = 1 AND u.user_id not in(select user_id from ".DB_PREFIX."entry e WHERE 1 " . $condition[1] . " ) " . $condition[0] . " ORDER BY ".$order;
		$rs  =  $this->runquery($sQuery);
		
		return $rs;
	}
	
	
	//Function to retrieve Contest entry submission completion notification to Entrant User 
	//Function to retrieve Date of declaration for Contest Winner notification to All Users
	function fetchEntrantsForCompletionInfo($condition = "",$order = "user_id")
	{
		$arrlist  =  array();
		$i  =  0;
		
		$sQuery = "SELECT u.user_id,u.client_id,u.user_username,u.user_firstname,u.user_lastname,u.user_email FROM ".DB_PREFIX."user u,".DB_PREFIX."entry e WHERE 1 = 1 AND u.user_id=e.user_id " . $condition . " ORDER BY ".$order;
		$rs  =  $this->runquery($sQuery);

		return $rs;
	}
	
	
	//Function to retrive Contest Judging stage start notification to Judge User
	function fetchJudgeRoundsOfContest($condition = "",$order = "contest_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$sQuery = "SELECT jr.judge_round_id,jr.contest_id,jr.is_user,jr.is_voter,jr.is_public,ct.client_id,ct.contest_title,ct.domain FROM ".DB_PREFIX."judge_round jr,".DB_PREFIX."contest ct WHERE 1 = 1 AND ct.contest_id=jr.contest_id " . $condition . " ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);

		return $rs;
	}
	
	
	//Function to retrive Contest Pre Defined Judge User of Judge Round
	function fetchJudgeRoundPreDefinedJudge($condition = "",$order = "judge_round_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$sQuery = "SELECT u.user_id,u.client_id,u.user_username,u.user_firstname,u.user_lastname,u.user_email FROM ".DB_PREFIX."judge_round_user jru,".DB_PREFIX."user u WHERE 1 = 1 AND jru.user_id=u.user_id " . $condition . " ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);

		return $rs;
	}
	
	
	//Function to retrive Contest Pre Defined Voter User of Judge Round
	function fetchJudgeRoundPreDefinedVoters($condition = "",$order = "voter_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$sQuery = "SELECT v.voter_id,v.client_id,v.voter_username,v.voter_firstname,v.voter_lastname,v.voter_email FROM ".DB_PREFIX."judge_round_voter_group jrv,".DB_PREFIX."voter_group vg,".DB_PREFIX."voter v WHERE 1 = 1 AND jrv.voter_group_id=vg.voter_group_id AND v.voter_group_id=vg.voter_group_id " . $condition . " ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);
		
		return $rs;
	}
	
	
	//Function to retrive Contest Public Voter User of Judge Round
	function fetchJudgeRoundPublicVoters($condition = "",$order = "voter_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$sQuery = "select v.voter_id,v.client_id,v.voter_username,v.voter_firstname,v.voter_lastname,v.voter_email from ".DB_PREFIX."voter v WHERE 1 " . $condition . " ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);
		
		return $rs;
	}
	
	
	//Function to retrive Contest Judgment completion advance notification to Judge User
	function fetchJudgeRoundCompletionPreDefinedJudge($condition = "",$order = "judge_round_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$condition = explode("||##||",$condition);
	
		$sQuery = "SELECT u.user_id,u.client_id,u.user_username,u.user_firstname,u.user_lastname,u.user_email FROM ".DB_PREFIX."judge_round_user jru,".DB_PREFIX."user u WHERE 1 = 1 AND jru.user_id=u.user_id " . $condition[0] . " AND u.user_id not in (select user_id from ".DB_PREFIX."vote vt WHERE 1 " . $condition[1] . " )  ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);
		
		return $rs;
	}
	
	
	//Function to retrive Contest Pre Defined Voter User of Judge Round
	function fetchJudgeRoundCompletionPreDefinedVoters($condition = "",$order = "voter_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$condition = explode("||##||",$condition);
	
		$sQuery = "SELECT v.voter_id,v.client_id,v.voter_username,v.voter_firstname,v.voter_lastname,v.voter_email FROM ".DB_PREFIX."judge_round_voter_group jrv,".DB_PREFIX."voter_group vg,".DB_PREFIX."voter v WHERE 1 = 1 AND jrv.voter_group_id=vg.voter_group_id AND v.voter_group_id=vg.voter_group_id AND user_type_id='".USER_TYPE_VOTER_USER."' " . $condition[0] . " AND v.voter_id not in (select voter_id from ".DB_PREFIX."vote vt WHERE 1 " . $condition[1] . " )  ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);
		
		return $rs;
	}
	
	
	//Function to retrive Contest Public Voter User of Judge Round
	function fetchJudgeRoundCompletionPublicVoters($condition = "",$order = "voter_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$condition = explode("||##||",$condition);
	
		$sQuery = "select v.voter_id,v.client_id,v.voter_username,v.voter_firstname,v.voter_lastname,v.voter_email from ".DB_PREFIX."voter v WHERE 1 AND user_type_id='".USER_TYPE_PUBLIC_VOTER_USER."' " . $condition[0] . " AND v.voter_id not in (select voter_id from ".DB_PREFIX."vote vt WHERE 1 " . $condition[1] . " ) ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);
		
		return $rs;
	}
	
	
	
	//Function to retrive Contest Judgment completion notification to Judge User 
	function fetchJudgeRoundCompletePreDefinedJudge($condition = "",$order = "judge_round_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$condition = explode("||##||",$condition);
	
		$sQuery = "SELECT u.user_id,u.client_id,u.user_username,u.user_firstname,u.user_lastname,u.user_email FROM ".DB_PREFIX."judge_round_user jru,".DB_PREFIX."user u WHERE 1 = 1 AND jru.user_id=u.user_id " . $condition[0] . " AND u.user_id in (select user_id from ".DB_PREFIX."vote vt WHERE 1 " . $condition[1] . " )  ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);
		return $rs;
	}
	
	
	//Function to retrive Contest Pre Defined Voter User of Judge Round
	function fetchJudgeRoundCompletePreDefinedVoters($condition = "",$order = "voter_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$condition = explode("||##||",$condition);
	
		$sQuery = "SELECT v.voter_id,v.client_id,v.voter_username,v.voter_firstname,v.voter_lastname,v.voter_email FROM ".DB_PREFIX."judge_round_voter_group jrv,".DB_PREFIX."voter_group vg,".DB_PREFIX."voter v WHERE 1 = 1 AND jrv.voter_group_id=vg.voter_group_id AND v.voter_group_id=vg.voter_group_id AND user_type_id='".USER_TYPE_VOTER_USER."' " . $condition[0] . " AND v.voter_id in (select voter_id from ".DB_PREFIX."vote vt WHERE 1 " . $condition[1] . " )  ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);

		return $rs;
	}
	
	
	//Function to retrive Contest Public Voter User of Judge Round
	function fetchJudgeRoundCompletePublicVoters($condition = "",$order = "voter_id")
	{
		$arrlist  =  array();
		$i  =  0;
	
		$condition = explode("||##||",$condition);
	
		$sQuery = "select v.voter_id,v.client_id,v.voter_username,v.voter_firstname,v.voter_lastname,v.voter_email from ".DB_PREFIX."voter v WHERE 1 AND user_type_id='".USER_TYPE_PUBLIC_VOTER_USER."' " . $condition[0] . " AND v.voter_id in (select voter_id from ".DB_PREFIX."vote vt WHERE 1 " . $condition[1] . " ) ORDER BY ".$order;
		
		$rs  =  $this->runquery($sQuery);

		return $rs;
	}
		
}
?>