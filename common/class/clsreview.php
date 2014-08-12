<?php
class review extends common
{
	//Property
	var $judge_shortlist_id;
	var $contest_id;
	var $judge_round_id;
	var $user_id;
	var $voter_id;
	var $entry_id;
	var $isshortlist;
	var $ishide;
	var $pagingType;
	
	var $vote_id;
	var $vote_start_date;
	var $vote_end_date;
	var $vote_iscomplete;
	
	var $vote_detail_id;
	var $score;
	
	var $vote_review_id;
	var $judge_round_question_id;
	var $question_id;
	var $vote_review;	
	
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;

	var $checkedids;
	var $uncheckedids;
	
	var $question_score;
	var $score_question_id;
	
	function review()
	{
		$this->judge_shortlist_id = 0;
		$this->contest_id = 0;
		$this->judge_round_id = 0;
		$this->user_id = 0;
		$this->voter_id = 0;
		$this->entry_id = 0;
		$this->isshortlist = 0;
		$this->ishide = 0;
		
		$this->vote_id = 0;
		$this->vote_start_date = "";
		$this->vote_end_date = "";
		$this->vote_iscomplete = 0;
		
		$this->vote_detail_id = 0;
		$this->score = 0;
		
		$this->vote_review_id = 0;
		$this->judge_round_question_id = 0;
		$this->question_id = 0;
		$this->vote_review = "";	
		
		$this->question_score = 0;
		$this->score_question_id = 0;		
	}
	
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="entry_date")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and entry_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", entry_date desc";
		}
		
		$strQuery="SELECT entry_id,entry_status,DATE_FORMAT(entry_date,'%W, %M %d, %Y at %h:%i %p') as entry_date,DATE_FORMAT(status_date,'%W, %M %d, %Y at %h:%i %p') as status_date,concat(".DB_PREFIX."user.user_firstname,' ',".DB_PREFIX."user.user_lastname) as userName FROM ".DB_PREFIX."entry,".DB_PREFIX."user WHERE 1=1 AND ".DB_PREFIX."user.user_id=".DB_PREFIX."entry.user_id  AND contest_id='".$this->contest_id."' " . $condition . $order;
		$rs=mysql_query($strQuery);
		return $rs;
	}
	
	//Function to retrieve recordset of table
	//Fetch records of judgement both from Judge and Voters
	function fetchRecordSetReport($id="",$condition_arr="",$order="contest_id")
	{		
		$condition = $condition_arr[0];
		$condition1 = $condition_arr[1];
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and contest_id=". $id .$condition;
		$condition1 = " and contest_id=". $id .$condition1;
		}
		
		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", judgementdate desc";
		}
		
		$strQuery=" (SELECT v.vote_id,vote_end_date,concat(ur.user_firstname,' ',ur.user_lastname) as judgeName,ct.contest_title,ct.contest_id,vd.entry_id,vd.score,vd.created_date as judgementdate,vd.vote_detail_id 
					FROM ".DB_PREFIX."vote v,".DB_PREFIX."contest ct,".DB_PREFIX."user ur,".DB_PREFIX."vote_detail vd,
						 ".DB_PREFIX."judge_round jr
					WHERE 1=1 AND 
						  v.contest_id=ct.contest_id AND 
						  v.vote_id=vd.vote_id AND 
						  v.user_id=ur.user_id AND 
						  v.user_id!=0 AND 
						  contest_status=1 AND 
						  jr.contest_id=ct.contest_id AND
						  ct.entry_start_date<='".currentScriptDate()."' AND
						  ct.winner_announce_date>'".currentScriptDate()."' AND
						  jr.judge_round_id=v.judge_round_id AND
					      jr.start_date<='".currentScriptDate()."' AND
						  jr.end_date>'".currentScriptDate()."' ".$condition . " ) 
				UNION (SELECT v.vote_id,vote_end_date,concat(ur.voter_firstname,' ',ur.voter_lastname) as judgeName,ct.contest_title,ct.contest_id,vd.entry_id,vd.score,vd.created_date as judgementdate,vd.vote_detail_id 
					FROM ".DB_PREFIX."vote v,".DB_PREFIX."contest ct,".DB_PREFIX."voter ur,".DB_PREFIX."vote_detail vd,
						 ".DB_PREFIX."judge_round jr 
					WHERE 1=1 AND 
						  v.contest_id=ct.contest_id AND 
						  v.vote_id=vd.vote_id AND 
						  ur.voter_id=v.voter_id AND 
						  v.voter_id!=0 AND 
						  contest_status=1 AND 
						  jr.contest_id=ct.contest_id AND
						  ct.entry_start_date<='".currentScriptDate()."' AND
						  ct.winner_announce_date>'".currentScriptDate()."' AND
						  jr.judge_round_id=v.judge_round_id AND
					      jr.start_date<='".currentScriptDate()."' AND
						  jr.end_date>'".currentScriptDate()."' ".$condition1." ) 
				  ".$order;
		
		$rs=mysql_query($strQuery);
		return $rs;
	}
	
	
	function fetchRecordSetJudgeReport($id="",$condition_arr="",$order="contest_id")
	{		
		$condition = $condition_arr[0];
		$condition1 = $condition_arr[1];
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and ct.contest_id=". $id .$condition;
		$condition1 = " and ct.contest_id=". $id .$condition1;
		}
		
		
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", judgementdate desc";
		}
		
		$strQuery=" (SELECT v.vote_id,vote_end_date,concat(ur.user_firstname,' ',ur.user_lastname) as judgeName,(SELECT concat(urv.user_firstname,' ',urv.user_lastname) FROM ".DB_PREFIX."user urv,".DB_PREFIX."entry er WHERE er.entry_id=vd.entry_id AND er.user_id=urv.user_id) as entrantName,(SELECT DATE_FORMAT(entry_date,'%W, %M %d, %Y at %h:%i %p') FROM ".DB_PREFIX."entry er WHERE er.entry_id=vd.entry_id) as entrantDate,ct.contest_title,ct.contest_id,vd.entry_id,vd.score,vd.created_date as judgementdate,vd.vote_detail_id 
					FROM ".DB_PREFIX."vote v,".DB_PREFIX."contest ct,".DB_PREFIX."user ur,".DB_PREFIX."vote_detail vd,
						 ".DB_PREFIX."judge_round jr
					WHERE 1=1 AND 
						  v.contest_id=ct.contest_id AND 
						  v.vote_id=vd.vote_id AND 
						  v.user_id=ur.user_id AND 
						  v.user_id!=0 AND 
						  contest_status=1 AND 
						  jr.contest_id=ct.contest_id AND
						  jr.judge_round_id=v.judge_round_id
					      ".$condition . " ) 
				UNION (SELECT v.vote_id,vote_end_date,concat(ur.voter_firstname,' ',ur.voter_lastname) as judgeName,(SELECT concat(urv.user_firstname,' ',urv.user_lastname) FROM ".DB_PREFIX."user urv,".DB_PREFIX."entry er WHERE er.entry_id=vd.entry_id AND er.user_id=urv.user_id) as entrantName,(SELECT DATE_FORMAT(entry_date,'%W, %M %d, %Y at %h:%i %p') FROM ".DB_PREFIX."entry er WHERE er.entry_id=vd.entry_id) as entrantDate,ct.contest_title,ct.contest_id,vd.entry_id,vd.score,vd.created_date as judgementdate,vd.vote_detail_id 
					FROM ".DB_PREFIX."vote v,".DB_PREFIX."contest ct,".DB_PREFIX."voter ur,".DB_PREFIX."vote_detail vd,
						 ".DB_PREFIX."judge_round jr 
					WHERE 1=1 AND 
						  v.contest_id=ct.contest_id AND 
						  v.vote_id=vd.vote_id AND 
						  ur.voter_id=v.voter_id AND 
						  v.voter_id!=0 AND 
						  contest_status=1 AND 
						  jr.contest_id=ct.contest_id AND
						  jr.judge_round_id=v.judge_round_id
					      ".$condition1." )
				  ".$order;
		
		$rs=mysql_query($strQuery);
		return $rs;
	
	}
	
	function fetchRecordsOfScoreWithVoteId()
	{
		$strQuery=" SELECT question_score,score_question
					FROM ".DB_PREFIX."vote_score_questions vsq,".DB_PREFIX."judge_score_questions jsq
					WHERE 1=1 AND 
						  vsq.score_question_id=jsq.score_question_id AND 
						  vsq.vote_detail_id='".$this->vote_detail_id."' AND
						  vsq.vote_id='".$this->vote_id."'";
		
		$rs=mysql_query($strQuery);
		
		$arrList = array();
		$i = 0;
		
		while($res = mysql_fetch_assoc($rs))
		{
			$arrList[$i]['score_question'] = $res['score_question'];
			$arrList[$i]['question_score'] = $res['question_score'];
			$i++;
		}
	
		return $arrList;
	} 
	
	//Function to retrieve recordset of table
	function fetchRecordSetReportAll($id="",$condition="",$order="contest_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and contest_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", contest_id desc";
		}
		
		$condition1 = str_replace("user_firstname","voter_firstname",$condition);
		$condition1 = str_replace("user_lastname","voter_lastname",$condition1);
		
		$strQuery=" ( SELECT vote_id,vote_end_date,
							concat(ur.user_firstname,' ',ur.user_lastname) as judgeName,
							ct.contest_title,ct.contest_id 
							
					   FROM 
					   ".DB_PREFIX."vote v,".DB_PREFIX."contest ct,
					   ".DB_PREFIX."user ur 
					   
					   WHERE 
					   1=1 AND 
					   v.contest_id=ct.contest_id AND 
					   v.user_id=ur.user_id AND 
					   v.user_id!=0 AND contest_status=1
					   ".$condition . " 
					  )
					   
					  UNION 
					  
					  ( SELECT vote_id,vote_end_date,
					  			concat(ur.voter_firstname,' ',ur.voter_lastname) as judgeName,
					  			ct.contest_title,ct.contest_id 
					  	FROM 
					  	".DB_PREFIX."vote v,".DB_PREFIX."contest ct,
					  	".DB_PREFIX."voter ur 
					  	
					  	WHERE 
					  	1=1 AND 
					  	v.contest_id=ct.contest_id AND 
					  	ur.voter_id=v.voter_id AND 
					  	v.voter_id!=0 AND 
					  	contest_status=1
					  	".$condition1." ) "
						.$order;
						
		$rs=mysql_query($strQuery);
		return $rs;
	}
	
	function setAllValues($id="",$condition="")
	{
		$order = '';
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and vote_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", vote_id desc";
		}
	
		$strQuery=" (SELECT vote_id,vote_end_date,concat(ur.user_firstname,' ',ur.user_lastname) as judgeName,ct.contest_title FROM ".DB_PREFIX."vote v,".DB_PREFIX."contest ct,".DB_PREFIX."user ur WHERE 1=1 AND v.contest_id=ct.contest_id AND v.user_id=ur.user_id AND v.user_id!=0 AND contest_status=1 AND vote_iscomplete=1 ".$condition . $order." ) UNION (SELECT vote_id,vote_end_date,concat(vr.voter_firstname,' ',vr.voter_lastname) as judgeName,ct.contest_title FROM ".DB_PREFIX."vote v,".DB_PREFIX."contest ct,".DB_PREFIX."voter vr WHERE 1=1 AND v.contest_id=ct.contest_id AND vr.voter_id=v.voter_id AND v.voter_id!=0 AND contest_status=1 AND vote_iscomplete=1 ".$condition . $order." ) ";
		$rs=mysql_query($strQuery);
		
		if($artf_judge= mysql_fetch_array($rs))
		{
			$this->judgeName = $artf_judge["judgeName"];
			$this->contest_title = $artf_judge["contest_title"];
		}
	}
	
	function fetchVoteDetails($condition="")
	{
		$strQuery="SELECT concat(ur.user_firstname,' ',ur.user_lastname) as entrantName, score FROM ".DB_PREFIX."vote_detail vd,".DB_PREFIX."user ur,".DB_PREFIX."entry en WHERE 1=1 AND vd.vote_id='".$this->vote_id."' AND en.entry_id=vd.entry_id AND en.user_id=ur.user_id ";
		$rs=mysql_query($strQuery);
		
		$arrList = array();
		$i = 0;
		
		while($res = mysql_fetch_assoc($rs))
		{
			$arrList[$i]['entrantName'] = $res['entrantName'];
			$arrList[$i]['score'] = $res['score'];
			$i++;
		}
		
		return $arrList;
	}
	
	function deleteVotingDetail()
	{
		$sqlQuery = " DELETE FROM ".DB_PREFIX."vote_review WHERE vote_detail_id in (SELECT vote_detail_id FROM ".DB_PREFIX."vote_detail WHERE vote_id = '".$this->vote_id."' )";
		mysql_query($sqlQuery);
		
		$sqlQuery = " DELETE FROM ".DB_PREFIX."vote_detail WHERE vote_id = '".$this->vote_id."' ";
		mysql_query($sqlQuery);
		
		$sqlQuery = " DELETE FROM ".DB_PREFIX."vote WHERE vote_id = '".$this->vote_id."' ";
		mysql_query($sqlQuery);
	}
	
	function deleteVoteDetailInfo()
	{
		$sqlQuery = " DELETE FROM ".DB_PREFIX."vote_review WHERE vote_detail_id = '".$this->vote_detail_id."' ";
		mysql_query($sqlQuery);
		
		$sqlQuery = " DELETE FROM ".DB_PREFIX."vote_detail WHERE vote_detail_id = '".$this->vote_detail_id."' ";
		mysql_query($sqlQuery);
		
		$sqlQuery = " SELECT * FROM ".DB_PREFIX."vote_detail WHERE vote_id = '".$this->vote_id."' ";
		$rs = mysql_query($sqlQuery);
		
		if(mysql_num_rows($rs)==0)
		{
			$sqlQuery = " DELETE FROM ".DB_PREFIX."vote WHERE vote_id = '".$this->vote_id."' ";
			mysql_query($sqlQuery);
		}
		
		$sqlQuery = " DELETE FROM ".DB_PREFIX."vote_score_questions WHERE vote_id = '".$this->vote_id."' ";
		mysql_query($sqlQuery);
	}
	
	//Function to retrieve recordset of table
	function fetchRecordSetNew($id="",$condition="",$order="entry_date")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and entry_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", entry_date desc";
		}
		
		$strQuery="SELECT entry_id,entry_status,DATE_FORMAT(entry_date,'%W, %M %d, %Y at %h:%i %p') as entry_date,DATE_FORMAT(status_date,'%W, %M %d, %Y at %h:%i %p') as status_date,concat(".DB_PREFIX."user.user_firstname,' ',".DB_PREFIX."user.user_lastname) as userName FROM ".DB_PREFIX."entry,".DB_PREFIX."user WHERE 1=1 AND ".DB_PREFIX."user.user_id=".DB_PREFIX."entry.user_id  AND contest_id='".$this->contest_id."' " . $condition . $order;
		$rs=mysql_query($strQuery);
		return $rs;
	}
	
	function addReview()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."judge_shortlist 
					
					(contest_id, judge_round_id, user_id, voter_id, entry_id, isshortlist, ishide,
					created_date, created_by, updated_date, updated_by) 
					values(
							'".$this->contest_id."', '".$this->judge_round_id."', 
							'".$this->user_id."', '".$this->voter_id."',
							'".$this->entry_id."', '".$this->isshortlist."', '".$this->ishide."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
	
		$this->runquery($sQuery);
		$this->judge_shortlist_id  =  mysql_insert_id();
		return mysql_insert_id();
	}
	
	function addEachQuestionsScore()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."vote_score_questions 
					(score_question_id, vote_id, vote_detail_id, question_score, created_by,created_date, updated_by, updated_date) 
		  values('".$this->score_question_id."','".$this->vote_id."','".$this->vote_detail_id."','".$this->question_score."',
				 '".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
	}
	
	function deleteReview($condition="")
	{
		$sQuery  =  "DELETE FROM ".DB_PREFIX."judge_shortlist 
					WHERE contest_id='".$this->contest_id."'
						  AND judge_round_id = '".$this->judge_round_id."' 
						  ".$condition."
						 AND entry_id = '".$this->entry_id."'";
	
		$this->runquery($sQuery);
	}
	
	function fetchCurrentUser()
	{
		if($this->getSession(SYSTEM_JUDGE_USER_TYPE_ID)==6)
		{
			return "user";
		}
		else
		{
			return "voter";
		}
	}
	
	function fetchVoteIsAdded()
	{
		$fetchCondition = $this->fetchCurrentUser()."_id = ".$this->getSession(SYSTEM_JUDGE_USER_ID);
		$sQuery  =  "SELECT v.vote_id FROM ".DB_PREFIX."vote v,".DB_PREFIX."vote_detail vd WHERE ".$fetchCondition." AND v.contest_id='".$this->contest_id."' AND v.judge_round_id='".$this->judge_round_id."' AND v.vote_id=vd.vote_id ";
		$rs = mysql_query($sQuery);

		if(mysql_num_rows($rs)>0)
		{
			while($res = mysql_fetch_assoc($rs))
			{
				$this->vote_id = $res['vote_id'];
			}
		}
		return mysql_num_rows($rs);
	}
	
	function isVoted()
	{
		$fetchCondition = $this->fetchCurrentUser()."_id = ".$this->getSession(SYSTEM_JUDGE_USER_ID);
		$sQuery  =  "SELECT v.vote_id FROM ".DB_PREFIX."vote v,".DB_PREFIX."vote_detail vd WHERE ".$fetchCondition." AND v.contest_id='".$this->contest_id."' AND v.judge_round_id='".$this->judge_round_id."' AND vd.entry_id='".$this->entry_id."' AND v.vote_id=vd.vote_id ";
		$rs = mysql_query($sQuery);
		if(mysql_num_rows($rs)>0)
		{
			while($res = mysql_fetch_assoc($rs))
			{
				$this->vote_id = $res['vote_id'];
			}
		}
		return mysql_num_rows($rs);
	}
	
	function addVote()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."vote 
					
					(contest_id, judge_round_id, user_id, voter_id, vote_start_date, vote_end_date, vote_iscomplete,
					created_date, created_by, updated_date, updated_by) 
					values(
							'".$this->contest_id."', '".$this->judge_round_id."', 
							'".$this->user_id."', '".$this->voter_id."',
							'".currentScriptDate()."', '".currentScriptDate()."', '".$this->vote_iscomplete."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
	
		$this->runquery($sQuery);
		$this->vote_id  =  mysql_insert_id();
		
		$fetchCondition = $this->fetchCurrentUser()."_id = ".$this->getSession(SYSTEM_JUDGE_USER_ID);
		$sQuery  =  "UPDATE ".DB_PREFIX."vote SET ".$fetchCondition." WHERE vote_id = '".$this->vote_id."'";
		$this->runquery($sQuery);		
		
		return $this->vote_id;
	}
	
	function updateVote()
	{
		$sQuery  =  "UPDATE ".DB_PREFIX."vote SET
					vote_end_date = '".currentScriptDate()."', 
					vote_iscomplete = '".$this->vote_iscomplete."',
					updated_date = '".currentScriptDate()."',
					updated_by = '".$this->updated_by."' where vote_id='".$this->vote_id."'";
	
		$this->runquery($sQuery);
	}
	
	function addVoteDetail()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."vote_detail 
					
					(vote_id, entry_id, score,
					created_date, created_by, updated_date, updated_by) 
					values(
							'".$this->vote_id."', '".$this->entry_id."', 
							'".$this->score."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
	
		$this->runquery($sQuery);
		$this->vote_detail_id  =  mysql_insert_id();
		return mysql_insert_id();
	}
	
	function addVoteReview()
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."vote_review 
					
					(vote_detail_id, judge_round_question_id, question_id, vote_review,
					created_date, created_by, updated_date, updated_by) 
					values(
							'".$this->vote_detail_id."', '".$this->judge_round_question_id."', 
							'".$this->question_id."', '".$this->vote_review."',
							'".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
	
		$this->runquery($sQuery);
		$this->vote_review_id  =  mysql_insert_id();
		return mysql_insert_id();
	}
	
	///////////////////   Fetch score by Voting Style   ////////////////////////
	
	function fetchMaxRankedGiven()
	{
		$fetchCondition = $this->fetchCurrentUser()."_id = ".$this->getSession(SYSTEM_JUDGE_USER_ID);
		$sQuery  =  "SELECT MAX(vd.score) as maxRanked FROM ".DB_PREFIX."vote v,".DB_PREFIX."vote_detail vd WHERE ".$fetchCondition." AND v.contest_id='".$this->contest_id."' AND v.judge_round_id='".$this->judge_round_id."' AND v.vote_id=vd.vote_id GROUP BY vd.vote_id ";
		$rs = mysql_query($sQuery);
		
		$maxRanked = 0;
		if(mysql_num_rows($rs)>0)
		{
			$res = mysql_fetch_assoc($rs);
			$maxRanked = $res['maxRanked'];
		}
		return $maxRanked;
	}
	
	function fetchRankedGiven($maxScore=0)
	{
		$fetchCondition = $this->fetchCurrentUser()."_id = ".$this->getSession(SYSTEM_JUDGE_USER_ID);
		$sQuery  =  "SELECT vd.score FROM ".DB_PREFIX."vote v,".DB_PREFIX."vote_detail vd WHERE ".$fetchCondition." AND v.contest_id='".$this->contest_id."' AND v.judge_round_id='".$this->judge_round_id."' AND v.vote_id=vd.vote_id";
		$rs = mysql_query($sQuery);
		
		$strMaxRanked = '';
		if(mysql_num_rows($rs)>0)
		{	
			while($res = mysql_fetch_assoc($rs))
			{
				$strMaxRanked.= $maxScore-($res['score']-1).",";
			}
		}
		return $strMaxRanked;
	}
	
	function showMessage($type,$totEntries,$totVoted)
	{
		$message = "";
		
		$callEVType = "entries";
		$callEType = "entries";
		if($totVoted==1)
		{
			$callEVType = "entry";
		}
		if($totEntries-$totVoted==1)
		{
			$callEType = "entry";
		}
		
		if($type==1)
		{
			$message = str_replace("#votedEntries#",$totVoted,REMAINMSG);
			$message = str_replace("#remainingEntries#",$totEntries-$totVoted,$message);
			$message = str_replace("#callEVType#",$callEVType,$message);
			$message = str_replace("#callEType#",$callEType,$message);
		}
		if($type==2)
		{	
			$message = str_replace("#votedEntries#",$totVoted,CANNOTVOTEMSG);
			$message = str_replace("#callEVType#",$callEVType,$message);
			$message = str_replace("#callEType#",$callEType,$message);
		}
		if($type==3)
		{
			$message = str_replace("#votedEntries#",$totVoted,VOTEDMSG);
			$message = str_replace("#callEVType#",$callEVType,$message);
			$message = str_replace("#callEType#",$callEType,$message);
		}
		if($type==4)
		{
			$message = str_replace("#remainingEntries#",$totEntries-$totVoted,NOTVOTEDMSG);
			$message = str_replace("#callEVType#",$callEVType,$message);
			$message = str_replace("#callEType#",$callEType,$message);
		}
		if($type==5)
		{
			$message = str_replace("#remainingEntries#",$totEntries-$totVoted,NOTVOTEDMSGMAX);
			$message = str_replace("#callEVType#",$callEVType,$message);
			$message = str_replace("#callEType#",$callEType,$message);
		}
		
		
		return $message;
	}
}
?>