<?php 
	define("htmltable","<table cellspacing=\"0\" cellpadding=\"6\" border=\"0\" ><tr><td height=\"30\" align=\"left\" class=\"tah11grn\" bgcolor=\"#FFFFFF\"><b> #strtitle </b><br> #strsubtitle</td></tr></table>");

	class message
	{
		function display_msg()
		{
			if (isset($_SESSION['err']))
			{
				$err=$_SESSION['err'];
				unset($_SESSION['err']);
				unset($_SESSION["errno"]);
			}
			if ( !isset($err)) { $err = ""; }
			echo stripslashes($err);
		}
		
		function clear_msg()
		{
			if (isset($_SESSION['err']))
			{
				unset($_SESSION['err']);
			}
		}
		
		function send_msg($valdest,$strfrm,$strtype,$strval="",$hvars="",$newmsg="",$formattbl="")
		{
			$iserror = 0;
			$strtitle="";
			$strsubtitle ="";
			
			switch($strtype)
			{
				case "1":
					$strtitle="Login Failed." ;
					$strsubtitle="Incorrect email or password entered.";
					$iserror = 1;
					break;
				case "2":
					$strtitle= "Login." ;
					$strsubtitle="You are not authorized without login or session expired.";
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
					$strsubtitle="Thank you. Please provide email and password to re-login.";
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
					$strtitle= "Please select atleast one." ;
					$strsubtitle= "You need to select atleast one ". $strfrm ."." ;
					$iserror = 1;
					break;
				case "10":
					$strtitle= "Login Successful." ;
					$strsubtitle="You are logged in successfully.";
					$iserror = 0;
					break;
				case "11":
					$strtitle= "Logout Successful." ;
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
					$strsubtitle="Your ". $strfrm ." has been changed successfully.";
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
				$strsubtitle="Incorrect user name or password entered, please try again.";
				$iserror = 1;
				break;
			case "20":
				$strtitle="Login Information." ;
				$strsubtitle="Password sent successfully. please check your mailbox.";
				$iserror = 0;
				break;
			case "21":
				$strtitle="Registration" ;
				$strsubtitle=$strfrm ."Congratulation! Your registration has been done successfully.";
				$iserror = 0;
				break;
			case "22":
				$strtitle= "Choose Worker" ;
				$strsubtitle= "Mail has been sent to selected freelancer for job offer.";
				$iserror = 0;
				break;
			case "23":
				$strtitle= "Customer Reviews" ;
				$strsubtitle= "Thank you for your feedback.";
				$iserror = 0;
				break;
			case "24":
				$strtitle= "Forgot Password" ;
				$strsubtitle= "Email was not found, please try again.";
				$iserror = 1;
				break;
			case "25":
				$strtitle= "Saved Successfully." ;
				$strsubtitle=$strfrm ." details have been saved successfully.";
				$iserror = 0;
				break;
			case "26":
				$strtitle= "Available Jobs";
				$strsubtitle= "Quota for job is fulfilled. Sorry! you will not be able to accept this job.";
				$iserror = 1;
				break;
			case "28":
				$strtitle= "Shopping Basket";
				$strsubtitle= "Shopping basket has been updated successfully.";
				$iserror = 0;
				break;
			case "29":
				$strtitle= "Shopping Basket";
				$strsubtitle= "Selected item has been removed successfully.";
				$iserror = 0;
				break;
			case "30":
				$strtitle="Login Information." ;
				$strsubtitle="Invalid e-mail address.";
				$iserror = 1;
				break;
			case "31":
				$strtitle= "Inappropriate Review";
				$strsubtitle= "Your comments have been submitted to administrator. Thank you for your comments.";
				$iserror = 0;
				break;
			case "32":
				$strtitle="Error uploading file." ;
				$strsubtitle="Unable to save ".$strfrm ." details.";
				$iserror = 1;
				break;
			case "33":
				$strtitle= "Order Status" ;
				$strsubtitle= $strfrm ."Order status has been successfully set.";
				$iserror = 0;
				break;
			case "34":
				$strtitle= "Cancel Job." ;
				$strsubtitle= " Selected Job has been cancelled successfully.";
				$iserror = 0;
				break;
			case "35":
				$strtitle= "Featured product status updated successfully." ;
				$strsubtitle= $strfrm ." featured product status updated successfully.";
				$iserror = 0;
				break;
			case "36":
				$strtitle="Thank you." ;
				$strsubtitle="We will be in touch with you soon.";
				$iserror = 0;
				break;
			case "37":
				$strtitle="Create Account" ;
				$strsubtitle="Creating an account with iglasses2u.com will allow you to shop faster, check your current orders and review your previous orders.";
				$iserror = 0;
				break;
			case "38":
				$strtitle="Mail successfully sent." ;
				$strsubtitle=" ";
				$iserror = 0;
				break;
			case "39":
				$strtitle="Error sending mail." ;
				$strsubtitle=" ";
				$iserror = 1;
				break;
			case "40":
				$strtitle="Join Now" ;
				$strsubtitle="Your account has been created successfully.";
				$iserror = 0;
				break;
			case "41":
				$strtitle="Profile" ;
				$strsubtitle="Your profile has been updated successfully.";
				$iserror = 0;
				break;
			case "42":
				$strtitle="Contact Us" ;
				$strsubtitle="Thank you for contacting us.";
				$iserror = 0;
				break;
			case "43":
				$strtitle="Apply Now" ;
				$strsubtitle="Thank you for apply. We get back to you within 24 hours.";
				$iserror = 0;
				break;			
			case "44":
				$strtitle="Access Denied" ;
				$strsubtitle="You are not allowed to access this page.";
				$iserror = 1;
				break;
			case "45":
				$strtitle="Forgot password" ;
				$strsubtitle="Your login details have been mailed to you, please check your inbox.";
				$iserror = 0;
				break;
			case "46":
				$strtitle="Invalid Url" ;
				$strsubtitle="Your entered url is not valid to view.";
				$iserror = 1;
				break;
			case "47":
					$strtitle= "Customer Completed Work Image." ;
					$strsubtitle= $strfrm ." completed work image has been removed successfully.";
					$iserror = 0;
					break;
			case "48":
					$strtitle= "Barter Item" ;
					$strsubtitle= "Mail has been successfully sent. Thank you for bargaining with barter3.com.";
					$iserror = 0;
					break;
			case "49":
					$strtitle= "Feedback" ;
					$strsubtitle= "Thank you for valuable feedback.";
					$iserror = 0;
					break;
			case "50":
					$strtitle= "Open for All" ;
					$strsubtitle= "Select job is now opened for all. All freelancers are notified by email.";
					$iserror = 0;
					break;
			case "51":
				$strtitle="Booking" ;
				$strsubtitle="Thank you for booking. We will contact you soon.";
				$iserror = 0;
				break;
			case "52":
				$strtitle="Representative" ;
				$strsubtitle="Thank you for contacting us. We answer all queries within 24 hours.";
				$iserror = 0;
				break;
			case "53":
				$strtitle="Captcha Security" ;
				$strsubtitle="Please enter Valid Captcha Security Code.";
				$iserror = 1;
				break;			
			case "54":
				$strtitle="Personal Order Message" ;
				$strsubtitle="Personal Message successfully added to the Order.";
				$iserror = 0;
				break;
			case "55":
				$strtitle= "Login" ;
				$strsubtitle= "You can not checkout without login.";
				$iserror = 1;
				break;
			case "56":
				$strtitle="Cancel Order" ;
				$strsubtitle="Order has been cancelled and an email has been sent to administrator.";
				$iserror = 0;
				break;
			case "57":
				$strtitle="Contact Us" ;
				$strsubtitle="Sorry your Captcha detail is incorrect.";
				$iserror = 0;
				break;
			case "58":
				$strtitle= "Product Image" ;
				$strsubtitle= $strfrm ." Image must be in image format.";
				$iserror = 1;
				break;
				
			case "59":
				$strtitle= "Login Inactive" ;
				$strsubtitle= "Your account is Inactive, please contact Site Admin.";
				$iserror = 1;
				break;
				
			case "60":
				$strtitle= "Cancel order" ;
				$strsubtitle= "Sorry, your order is already dispatched. So, it can not be canceled.";
				$iserror = 1;
				break;
			
			case "61":
				$strtitle= "Contact Us" ;
				$strsubtitle= "Thank you for your interest in Election Impact Demo. Please check your mail for demo link.";
				$iserror = 0;
				break;
			
			}
			
			if ($formattbl=="")
			{
				$msgcmn = new common();
				
				if($GLOBALS['scope']!="admin")
				{
					if ($iserror==1){
						$strmain=$msgcmn->get_file_content("template/error-msg.html");
					}
					else {
						$strmain=$msgcmn->get_file_content("template/info-msg.html");
					}
				}
				else
				{
					if ($iserror==1){
						$strmain=$msgcmn->get_file_content("templates/error-msg.html");
						$strmain = str_replace("##image##", ADMIN_THEME . "images/cancel.jpg", $strmain);
					}
					else {
						$strmain=$msgcmn->get_file_content("templates/info-msg.html");
						$strmain = str_replace("##image##", ADMIN_THEME . "images/check.jpg", $strmain);
					}
				}
			}
			else
			{
				$strmain=$formattbl;
			}			
			$strret=$strmain;
			if( strtolower($newmsg)=="set")
			{
				$strtitle=$this->setstring($strfrm);
				$strsubtitle=$this->setstring($strtype);
					
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
			
			$strret = str_replace("#strtitle",$strtitle,$strret);
			$strret = str_replace("#strsubtitle",$strsubtitle, $strret);
		
			$vname="err";
			
			if($strval !="")
			{
				$strret=$strval;
			}
			$_SESSION["errno"] = $strtype;
			$_SESSION["err"] = $strret;
			if (trim($valdest)!="")
			{
				header("Location: ".$valdest);
				exit;
			}
		}
		
		function setstring($str)
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