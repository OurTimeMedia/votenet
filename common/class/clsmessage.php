<?php 
define("htmltable","<table cellspacing=\"0\" cellpadding=\"6\" border=\"0\" ><tr><td height=\"30\" align=\"left\" class=\"tah11grn\" bgcolor=\"#FFFFFF\"><b> #strtitle </b><br> #strsubtitle</td></tr></table>");

class message
{
	var $scop;
	function message()
	{
		$this->scop=$GLOBALS["scope"];
	}

	function displayMsg()
	{
		if (isset($_SESSION['err']))
		{
			$err=$_SESSION['err'];
			unset($_SESSION['err']);
			unset($_SESSION["is_error"]);
			unset($_SESSION["error_no"]);
			unset($_SESSION["strsubtitle"]);
		}
		if ( !isset($err)) { $err = ""; }
			echo stripslashes($err);
	}
	
	function getDisplayErrorMsg()
	{
		if (isset($_SESSION['err']))
		{
			$err=$_SESSION['err'];
		}
		if ( !isset($err)) { $err = ""; }
			return stripslashes($err);
	}
	
	function getScriptErrorMsg()
	{
		if (isset($_SESSION['strsubtitle']))
		{
			$err=$_SESSION['strsubtitle'];
			unset($_SESSION['err']);
			unset($_SESSION["is_error"]);
			unset($_SESSION["error_no"]);
			unset($_SESSION["strsubtitle"]);
		}
		if ( !isset($err)) { $err = ""; }
			return stripslashes($err);
	}
	
	function clearMsg()
	{
		if (isset($_SESSION['err']))
		{
			unset($_SESSION['err']);
			unset($_SESSION["is_error"]);
			unset($_SESSION["error_no"]);
			unset($_SESSION["strsubtitle"]);
		}
	}
	
	function sendMsg($valdest,$strfrm,$strtype,$strval="",$hvars="",$newmsg="",$formattbl="")
	{
		$iserror = 0;
		$strtitle="";
		$strsubtitle ="";
	
		switch($strtype)
		{	
			case "1":
				$strtitle="Login Failed." ;
				$strsubtitle="Incorrect username or password entered.";
				$iserror = 1;
				break;
			case "2":
				$strtitle= "Login Failed." ;
				$strsubtitle="You are not authorized to access this section or your current session has expired. Please login again.";
				$iserror = 1;
				break;
			case "3":
				$strtitle= "Added Successfully." ;
				$strsubtitle=$strfrm ." details have been added successfully.";
				$iserror = 0;
				break;
			case "4":
				$strtitle= "Updated Successfully." ;
				$strsubtitle=$strfrm ." details have been updated successfully.";
				$iserror = 0;
				break;
			case "5":
				$strtitle= "Deleted Successfully." ;
				$strsubtitle=$strfrm ." details have been deleted successfully.";
				$iserror = 0;
				break;
			case "6":
				$strtitle= "You have successfully logged out." ;
				$strsubtitle="Thank you. Please provide username and password to re-login.";
				$iserror = 0;
				break;
			case "7":
				$strtitle= "Already Exists."  ;
				$strsubtitle=str_replace("'","&rsquo;",$strfrm) ." already exists, please enter unique  ". str_replace("'","&rsquo;",$strfrm) . ".";
				$iserror = 1;
				break;
			case "8":
				$strtitle= "No record found";
				$strsubtitle="No ". $strfrm ." found to be updated.";
				$iserror = 0;
				break;
			case "9":
				$strtitle= "Please select at least one." ;
				$strsubtitle= "You need to select at least one ". $strfrm ."." ;
				$iserror = 1;
				break;
			case "10":
				$strtitle= "Login Successfully." ;
				$strsubtitle="You are logged in successfully.";
				$iserror = 0;
				break;
			case "11":
				$strtitle= "Logout Successfully." ;
				$strsubtitle="You have logged out successfully.";
				$iserror = 0;
				break;
			case "12":
				$strtitle= "Incorrect Information.";
				$strsubtitle="Your ". $strfrm ." is not correct.";
				$iserror = 1;
				break;
			case "13":
				$strtitle= $strfrm ." Changed." ;
				$strsubtitle="Your ". $strfrm ." changed successfully.";
				$iserror = 0;
				break;
			case "14":
				$strtitle= $strfrm ."Registration Failed." ;
				$strsubtitle="You have entered wrong security number.";
				$iserror = 1;
				break;
			case "15":
				$strtitle= "Active/Inactive status updated successfully." ;
				$strsubtitle= $strfrm ." Active/Inactive status updated successfully.";
				$iserror = 0;
				break;
			case "16":
				$strtitle= "Change password" ;
				$strsubtitle= "Your " .$strfrm ." is not correct.";
				$iserror = 1;
				break;
			case "17":
				$strtitle= "Registered successfully." ;
				$strsubtitle= $strfrm . " have been registered successfully.";
				$iserror = 0;
				break;
		case "18":
				$strtitle= "Invalid File" ;
				$strsubtitle= "Could not upload the file.";
				$iserror = 0;
				break;
		case "19":
			$strtitle="Login Failed." ;
			$strsubtitle="Incorrect Username or e-mail address entered.";
			$iserror = 1;
			break;
		case "20":
			$strtitle="Login Information." ;
			$strsubtitle="Password sent successfully.";
			$iserror = 0;
			break;
		case "21":
			$strtitle="" ;
			$strsubtitle=$strfrm ." ";
			$iserror = 0;
			break;
		case "22":
		    $strtitle= "" ;
			$strsubtitle= $strfrm . " must be inactive.";
			$iserror = 1;
			break;
		case "23":
		    $strtitle= "" ;
		    $strsubtitle= " ";
			$iserror = 0;
			break;
		case "24":
		    $strtitle= "" ;
		    $strsubtitle= " ";
			$iserror = 0;
			break;
		case "25":
		    $strtitle= "" ;
		    $strsubtitle= "";
			$iserror = 0;
			break;
		case "26":
		    $strtitle= "";
		    $strsubtitle= " ";
			$iserror = 0;
			break;
		case "27":
		    $strtitle= "";
		    $strsubtitle= " ";
			$iserror = 0;
			break;
		case "28":
		    $strtitle= "";
		    $strsubtitle= "";
			$iserror = 0;
			break;
		case "29":
		    $strtitle= "";
		    $strsubtitle= "";
			$iserror = 0;
			break;
		case "30":
			$strtitle="Login Information." ;
			$strsubtitle="Invalid e-mail address.";
			$iserror = 1;
			break;
		case "31":
		    $strtitle= "";
		    $strsubtitle= $strfrm ." ";
				$iserror = 0;
			break;
		case "32":
			$strtitle="Error uploading file." ;
			$strsubtitle="Unable to save ".$strfrm ." details.";
			$iserror = 1;
			break;
		case "33":
			$strtitle= "" ;
			$strsubtitle= $strfrm ."";
			$iserror = 0;
			break;
		case "34":
			$strtitle="" ;
			$strsubtitle="";
			$iserror = 1;
			break;
		case "35":
			$strtitle="" ;
			$strsubtitle="";
			$iserror = 0;
			break;
		case "36":
			$strtitle="" ;
			$strsubtitle="";
			$iserror = 0;
			break;
		case "37":
			$strtitle="" ;
			$strsubtitle="";
			$iserror = 0;
			break;
		case "38":
			$strtitle="Mail successfully sent." ;
			$strsubtitle= $strfrm;
			$iserror = 0;
			break;
		case "39":
			$strtitle="Error sending mail." ;
			$strsubtitle=" ";
			$iserror = 1;
			break;
		case "40":
			$strtitle="" ;
			$strsubtitle=" ";
			$iserror = 0;
			break;
		case "41":
			$strtitle="" ;
			$strsubtitle=" ";
			$iserror = 1;
			break;
		case "42":
			$strtitle="" ;
			$strsubtitle=" ";
			$iserror = 1;
			break;
		case "43":
			$strtitle="Access Denied" ;
			$strsubtitle="You are not allowed to access admin panel";
			$iserror = 1;
			break;
		case "44":
			$strtitle="Access Denied" ;
			$strsubtitle="You are not allowed to access this page";
			$iserror = 1;
			break;
		case "45":
			$strtitle="" ;
			$strsubtitle="";
			$iserror = 1;
			break;
		case "46":
			$strtitle="Invalid Url" ;
			$strsubtitle="Your entered url is not valid to view.";
			$iserror = 1;
			break;
		case "47":
			$strtitle= "Unable to delete.";
			$strsubtitle= $strfrm ." is referenced in other details.";
			$iserror = 1;
			break;	
		case "48":
			$strtitle= "Unable to delete.";
			$strsubtitle= "Super user cannot be deleted.";
			$iserror = 1;
			break;	
		case "49":
			$strtitle= "Payment processing error.";
			$strsubtitle= $strfrm;
			$iserror = 1;
			break;	
		case "50":
			$strtitle= "Started Following.";
			$strsubtitle= $strfrm;
			$iserror = 0;
			break;	
		case "51":
			$strtitle= "Stopped Following.";
			$strsubtitle= $strfrm;
			$iserror = 0;
			break;	
		case "52":
			$strtitle="Message sent." ;
			$strsubtitle="Invitation has been sent to your selected contacts.";
			$iserror = 0;
			break;
		case "53":
			$strtitle = "Error." ;
			$strsubtitle = $strfrm;
			$iserror = 1;
			break;
		case "54":
			$strtitle="Login Failed." ;
			$strsubtitle="Incorrect e-mail or password entered.";
			$iserror = 1;
			break;
		case "55":
			$strtitle="Import Failed." ;
			$strsubtitle="Unable to get contacts.";
			$iserror = 1;
			break;
		case "56":
			$strtitle="Maximum Limit Reached." ;
			$strsubtitle="You have reached maximum limit of ".$strfrm ;
			$iserror = 1;
			break;
		case "57":
			$strtitle= "Follower Blocked.";
			$strsubtitle= $strfrm;
			$iserror = 0;
			break;	
		case "58":
			$strtitle= "Follower Unblocked.";
			$strsubtitle= $strfrm;
			$iserror = 0;
			break;	
		case "59":
			$strtitle= "No segment found.";
			$strsubtitle= "Please first create segment to assign to your connections.";
			$iserror = 1;
			break;	
		case "60":
			$strtitle= "Already connected.";
			$strsubtitle= "You are already connected to <strong>".$strfrm."</strong>.";
			$iserror = 1;
			break;	
		case "61":
			$strtitle= "Connected successfully.";
			$strsubtitle= "You are successfully connected to <strong>".$strfrm."</strong>.";
			$iserror = 0;
			break;	
		case "62":
			$strtitle= "Unable to invite any contacts.";
			$strsubtitle= "Please enter other contacts to invite.".$strfrm;
			$iserror = 1;
			break;	
		case "63":
			$strtitle= "Thank You." ;
			$strsubtitle= "You have been registered successfully.";
			$iserror = 0;
			break;
		case "64":
			$strtitle= "Already connected.";
			$strsubtitle= "You are already connected to organization <strong>".$strfrm."</strong>.";
			$iserror = 1;
			break;	
		case "65":
			$strtitle= "Connected successfully.";
			$strsubtitle= "You are successfully connected to organization <strong>".$strfrm."</strong>.";
			$iserror = 0;
			break;	
		case "66":
			$strtitle= "Status updated successfully.";
			$strsubtitle= "Your event invitation response updated successfully.";
			$iserror = 0;
			break;	
		case "67":
			$strtitle= "Disconnected successfully.";
			$strsubtitle= "You are successfully disconnected from <strong>".$strfrm."</strong>.";
			$iserror = 0;
			break;	
		case "68":
			$strtitle="Login Failed." ;
			$strsubtitle="The email you entered does not belong to any account.";
			$iserror = 1;
			break;
		case "69":
			$strtitle="Login Failed." ;
			$strsubtitle="The password you entered is incorrect. Please try again...";
			$iserror = 1;
			break;
		case "70":
			$strtitle="Login Failed." ;
			$strsubtitle="Your account is inactive.";
			$iserror = 1;
			break;
		case "71":
			$strtitle="Unable to connect." ;
			$strsubtitle="Invalid invitation key.";
			$iserror = 1;
			break;
		case "72":
			$strtitle="Unable to update status.";
			$strsubtitle="You rare not invited to this event.";
			$iserror = 1;
			break;
		case "73":
			$strtitle= "Private/Public status updated successfully." ;
			$strsubtitle= $strfrm ." Private/Public status updated successfully.";
			$iserror = 0;
			break;
		case "74":
			$strtitle="You are not authorised user.";
			$strsubtitle="You are not authorised user.";
			$iserror = 1;
			break;
		case "75":
			$strtitle="Your account has been blocked by an administrator.";
			$strsubtitle="Your account has been blocked by an administrator.";
			$iserror = 1;
			break;
		case "76":
			$strtitle= "Unblocked Successfully." ;
			$strsubtitle=$strfrm ." have been unblocked successfully.";
			$iserror = 0;
			break;
		case "77":
			$strtitle= "Invalid IP Address." ;
			$strsubtitle=$strfrm ." is not valid.";
			$iserror = 1;
			break;
		case "78":
			$strtitle= "Blocked Successfully." ;
			$strsubtitle=$strfrm ." have been blocked successfully.";
			$iserror = 0;
			break;
		case "79":
			$strtitle= "Canceled Successfully." ;
			$strsubtitle=$strfrm ." have been canceled successfully.";
			$iserror = 0;
			break;
		case "80":
			$strtitle= "Sent Successfully." ;
			$strsubtitle=$strfrm ." has been sent successfully.";
			$iserror = 0;
			break;
		case "81":
			$strtitle= "Unable to Send." ;
			$strsubtitle="Error generated while Sending Mail.";
			$iserror = 1;
			break;
		case "82":
			$strtitle= "Unable to Send." ;
			$strsubtitle="Invalid Username. This Username does not exist.";
			$iserror = 1;
			break;
		case "84":
				$strtitle= "Registered Successfully." ;
				$strsubtitle="Your account has been created successfully. You will receive a welcome email soon.";
				$iserror = 0;
				break;
		case "85":
			$strtitle= "Unable to delete.";
			$strsubtitle= "Contest can not be Deleted";
			$iserror = 1;
			break;	
		case "86":
			$strtitle="Access Denied" ;
			$strsubtitle="You are not allowed to access contest panel";
			$iserror = 1;
			break;
		case "87":
			$strtitle="Unauthorized Access" ;
			$strsubtitle="Unauthorized access";
			$iserror = 1;
			break;
		case "88":
			$strtitle="Payment Approved" ;
			$strsubtitle="Payment Collected Successfully";
			$iserror = 0;
			break;
		case "89":
			$strtitle="Payment Declined" ;
			$strsubtitle="Your Payment Declined";
			$iserror = 1;
			break;
		case "90":
				$strtitle= "Entry created Successfully." ;
				$strsubtitle="Your entry has been added successfully.";
				$iserror = 0;
				break;
		case "91":
				$strtitle= "Can not proceed." ;
				$strsubtitle="You can not proceed further!.";
				$iserror = 1;
				break;
		case "92":
				$strtitle= "Hide Successfully" ;
				$strsubtitle="Entry hide successfully.";
				$iserror = 0;
				break;
		case "93":
				$strtitle= "Vote is added." ;
				$strsubtitle="Your vote is added.";
				$iserror = 0;
				break;
		case "94":
				$strtitle= "Fields set." ;
				$strsubtitle="Fields are set successfully.";
				$iserror = 0;
				break;				
		case "95":
				$strtitle= LANG_LOGIN_FAILED ;
				$strsubtitle="You do not have access to next judge rounds.";
				$iserror = 0;
				break;
		case "96":
				$strtitle= LANG_LOGIN_FAILED ;
				$strsubtitle="The judging round starts on ".$strfrm.". Please login on ".$strfrm." to vote in this round.";
				$iserror = 0;
				break;				
		case "97":
				$strtitle= "Unhide Successfully" ;
				$strsubtitle="Entry unhide successfully.";
				$iserror = 0;
				break;
		case "98":
				$strtitle= "Removed Successfully" ;
				$strsubtitle="Entry removed successfully.";
				$iserror = 0;
				break;		
		case "99":
				$strtitle= "File Undefined" ;
				$strsubtitle="File not found!";
				$iserror = 1;
				break;
		case "100":
				$strtitle="Login Failed." ;
				$strsubtitle="Your account is inactive. Contact the administrator to activate your account.";
				$iserror = 1;
				break;	
		case "101":
				$strtitle="Login Failed." ;
				$strsubtitle="The judging round has completed. You cannot login now.";
				$iserror = 1;
				break;	
		case "102":
				$strtitle="Login Failed." ;
				$strsubtitle="You do not have access to the next judging round.";
				$iserror = 1;
				break;	
		case "103":
				$strtitle="Login Failed." ;
				$strsubtitle="You cannot login now, all judging rounds are over.";
				$iserror = 1;
				break;	
		case "104":
				$strtitle= "Deleted Successfully." ;
				$strsubtitle=$strfrm ." has been deleted from list of blocked users.";
				$iserror = 0;
				break;		
		case "105":
				$strtitle= LANG_REGISTER_SUCCESS ;
				$strsubtitle=LANG_REGISTER_SUCCESS_VERIFICATION_MSG;
				$iserror = 0;
				break;	
		case "106":
				$strtitle= ACCOUNT_VERIFICATION;
				$strsubtitle=VERIFICATION_LINK_NOT_VALID;
				$iserror = 0;
				break;
		case "107":
				$strtitle= ACCOUNT_VERIFICATION;
				$strsubtitle=VERIFICATION_LINK_VALID_SUCCESSFULLY;
				$iserror = 0;
				break;	
		case "108":
				$strtitle=LANG_LOGIN_FAILED;
				$strsubtitle=NOT_VERIFY_EMAIL_ADDRESS;
				$iserror = 1;
				break;		
		case "109":
				$strtitle= "Invalid Zip Code" ;
				$strsubtitle= "";
				$iserror = 1;
				break;				
		case "110":
				$strtitle= "Your account is no longer active. Please email <a href=\"mailto:support@votenet.com\" style=\"font-size: 13px; color: #A71111; font-weight:bold;\">support@votenet.com</a> for assistance." ;
				$strsubtitle= "";
				$iserror = 1;
				break;
		case "111":
				$strtitle= "Invalid Zip Code/State" ;
				$strsubtitle= "";
				$iserror = 1;
				break;		
		}

		if ($formattbl=="")
		{
			$msgcmn = new common();
			
			
			if ($iserror==1)
				$strmain=$msgcmn->getFileContent(SERVER_ROOT."common/templates/error_msg.html");
			else
				$strmain=$msgcmn->getFileContent(SERVER_ROOT."common/templates/info_msg.html");
		}
		else
		{
			$strmain=$formattbl;
		}			
		$strret=$strmain;
		if( strtolower($newmsg)=="set")
		{
			$strtitle=$this->setString($strfrm);
			$strsubtitle=$this->setString($strtype);
				
		}
		if ($iserror == 1)
		{
			$strtitle = $strtitle;
			$strsubtitle = $strsubtitle;
		}
		else
		{
			$strtitle = $strtitle;
			$strsubtitle = $strsubtitle;
		}
		
		$strret = str_replace("##imgpath##",SERVER_HOST,$strret);
		$strret = str_replace("#strtitle",$strtitle,$strret);
		$strret = str_replace("#strsubtitle",$strsubtitle, $strret);
	
		$vname="err";
		
		if($strval !="")
		{
			$strret=$strval;
		}
		
		$_SESSION["err"] = $strret;
		$_SESSION["is_error"]=$iserror;
		$_SESSION["error_no"]=$strtype;
		$_SESSION["strsubtitle"] = $strsubtitle;
		if (trim($valdest)!="")
		{	
			header("Location: ".$valdest);
			exit;
		}
	}
	
	function setString($str)
	{	
		if (!is_null($str) && $str !="")
		{
			$str = str_replace("&amp;","&",$str);
			$str = str_replace("&quot;","\"",$str);
			$str = str_replace("&#039;","'",$str);
			$str = str_replace("&lt;","<",$str);
			$str = str_replace("&gt;",">",$str);
	
			$str = str_replace("\\","",$str);
			$str = str_replace("&","&amp;",$str);
			$str = str_replace("\"","&quot;",$str);
			$str = str_replace("'","&#039;",$str);
			$str = str_replace("<","&lt;",$str);
			$str = str_replace(">","&gt;",$str);
			
		}
	
		return $str;
	}
	
}
?>