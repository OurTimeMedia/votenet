<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<body>
<?php
require_once("include/common_includes.php");
require_once("include/general_includes.php");
require_once (COMMON_CLASS_DIR ."clsclient.php");
require_once (COMMON_CLASS_DIR ."clsstate.php");

if((isset($_REQUEST['txtzipcode']) && $_REQUEST['txtzipcode'] != "" || isset($_REQUEST['selstate']) && $_REQUEST['selstate'] != "")&& isset($_REQUEST['txtemail']) && $_REQUEST['txtemail'] != "")
{	
	$objState=new state();
	
	if(isset($_REQUEST['txtzipcode']) && $_REQUEST['txtzipcode'] != "")
	{
		$condition = " and ".DB_PREFIX."state_zipcode.zip_code='".$_REQUEST['txtzipcode']."'";
		
		if(isset($_REQUEST['selstate']) && $_REQUEST['selstate'])
			$condition.= " and ".DB_PREFIX."state.state_id='".$_REQUEST['selstate']."'";
		
		$homestate = $objState->findhomestate($condition);
		
		if(count($homestate) > 0)
		{
			$condition = "  and ".DB_PREFIX."state.state_id=".$homestate[0]['state_id'];
			$statedetail = $objState->fetchAllAsArrayLanguage(1,$condition);
			
			$cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
			$cmn->setSession('Home_State', $statedetail[0]['state_name']);
			$cmn->setSession('Home_ZipCode', $_REQUEST['txtzipcode']);	
			$cmn->setSession('voter_email', $_REQUEST['txtemail']);	
			
			header("Location: registrationform1.php");
			exit;
		}
		else
		{		
			$msg->sendMsg("index.php","Zipcode ",111);		
		}
	}	
	else if(isset($_REQUEST['selstate']) && $_REQUEST['selstate'] != "")
	{
		$condition = "  and ".DB_PREFIX."state.state_id=".$_REQUEST['selstate'];
		$statedetail = $objState->fetchAllAsArrayLanguage(1,$condition);
		
		if(count($statedetail) > 0)
		{
			$cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
			$cmn->setSession('Home_State', $statedetail[0]['state_name']);
			$cmn->setSession('voter_email', $_REQUEST['txtemail']);
			
			header("Location: registrationform1.php");
			exit;
		}
		else
		{		
			$msg->sendMsg("index.php","State ",111);		
		}
	}	
}
else if((isset($_REQUEST['zipcode']) && $_REQUEST['zipcode'] != "" || isset($_REQUEST['state']) && $_REQUEST['state'] != "")&& isset($_REQUEST['txtemail']) && $_REQUEST['txtemail'] != "")
{	
	$objState=new state();
	
	if(isset($_REQUEST['zipcode']) && $_REQUEST['zipcode'] != "")
	{
		$condition = " and ".DB_PREFIX."state_zipcode.zip_code='".$_REQUEST['zipcode']."'";
		
		if(isset($_REQUEST['state']) && $_REQUEST['state'])
			$condition.= " and ".DB_PREFIX."state.state_code='".$_REQUEST['state']."'";
		
		$homestate = $objState->findhomestate($condition);
		
		if(count($homestate) > 0)
		{
			$condition = "  and ".DB_PREFIX."state.state_id=".$homestate[0]['state_id'];
			$statedetail = $objState->fetchAllAsArrayLanguage(1,$condition);
			
			$cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
			$cmn->setSession('Home_State', $statedetail[0]['state_name']);
			$cmn->setSession('Home_ZipCode', $_REQUEST['zipcode']);	
			$cmn->setSession('voter_email', $_REQUEST['txtemail']);	
			
			?>
				<form id="f" name="f" action="registrationform11.php">
			</form>
			<script type="text/javascript">
			alert("dddd");
			//location.href="http://www.google.com";
			document.f.submit();
			alert("dddd");
			</script>
			<form action="http://www.google.com">
			</form>
			<?php
			echo "After DDDD";
			exit;
		}
		else
		{		
			$msg->sendMsg("index.php","Zipcode ",111);		
		}
	}	
	else if(isset($_REQUEST['state']) && $_REQUEST['state'] != "")
	{
		$condition = "  and ".DB_PREFIX."state.state_code='".$_REQUEST['state']."'";
		$statedetail = $objState->fetchAllAsArrayLanguage(1,$condition);
		
		if(count($statedetail) > 0)
		{
			$cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
			$cmn->setSession('Home_State', $statedetail[0]['state_name']);
			$cmn->setSession('voter_email', $_REQUEST['txtemail']);
			
			?>
			<script type="text/javascript">
			alert("ssssss");
			location.href="registrationform11.php";
			</script>
			<?php
		}
		else
		{		
			$msg->sendMsg("index.php","State ",111);		
		}
	}	
}
else
{	
	$msg->sendMsg("index.php","Zip Code or State",111);
}
?>
</body>
</html>