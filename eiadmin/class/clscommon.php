<?php
	class common
	{
		function login_admin($user_name,$password)
		{	
			$qry="SELECT user_id, user_role_id, CONCAT(first_name, ' ', last_name) full_name, user_name,password FROM " . DB_PREFIX . "user where user_active = 'y' AND LOWER(user_name) = '". strtolower($user_name) ."' AND password='". $password ."'";
			$rs=mysql_query($qry)  or die(mysql_error());
			$ret='0';
			if($rw=mysql_fetch_array($rs))
			{
				$ret='1';
				$pas=strcmp($password,$rw["password"]);
				$us=strcmp(strtolower($user_name),strtolower($rw["user_name"]));
				if($pas==0 && $us==0)
				{
					$this->set_session(ADMIN_USER_ID, $this->getval($rw["user_id"]));
					$this->set_session(ADMIN_USER_NAME, $this->getval($rw["user_name"]));
					$this->set_session(ADMIN_NAME, $this->getval($rw["full_name"]));
					$this->set_session(ADMIN_USER_ROLE, $this->getval($rw["user_role_id"]));
					return $ret;
				}
				else
					return false;
			}
			return $ret;
		}
	
		function logout_admin()
		{	
			$ret='1';
			$this->remove_session(ADMIN_USER_ID);
			$this->remove_session(ADMIN_USER_NAME);
			$this->remove_session(ADMIN_NAME);
			$this->remove_session(ADMIN_USER_ROLE);
			$this->remove_session(REDIRECT_PAGE);
			unset($_SESSION[PAGE_STATE]);
			return $ret;
		}
		
		function login_user($email,$password)
		{
			$strquery="select * from " . DB_PREFIX . "customer where LOWER(email)='". strtolower(trim($email)) ."' and password='". trim($password) ."'";

			$rs=mysql_query($strquery)  or die(mysql_error());
			$ret='0';
	
			if($rw=mysql_fetch_array($rs))
			{
				$pas=strcmp($password,$rw["password"]);
				$us=strcmp(strtolower($email),strtolower($rw["email"]));
				
				if($rw['customer_active'] =='y')
				{
					if($pas==0 && $us==0)
					{
						$ret='1';
						$this->set_session(CLIENT_USERID,$rw["customer_id"]);
						$this->set_session(CLIENT_USERNAME,$rw["first_name"]);
					}
				}
				elseif($rw['customer_active']	== 'n')
				{
					return 'inactive';
				}
				else
					return false;
				//setcookie(COOKIE_NAME, 'usr='.$rw["first_name"].'&hash='.$rw["customer_id"], time() + COOKIE_TIME);
			}
			
			return $ret;
		}
	
		function logout_user()
		{	
			$ret='1';
			$this->remove_session(CLIENT_USERID);
			$this->remove_session(CLIENT_USERNAME);
			$this->remove_session(CLIENT_REDIRECT_PAGE);
			
			setcookie(COOKIE_NAME, "", time()-3600);
			session_destroy();
			return $ret;
		}
		
		function set_session($key,$value)
		{
			if($GLOBALS["scope"]!="admin")
			{
				$_SESSION[SESSION_CLIENT_PREFIX . $key]=$value;
			}
			else
			{
				$_SESSION[SESSION_ADMIN_PREFIX . $key]=$value;
			}
		}
		
		function remove_session($key)
		{
			if($GLOBALS["scope"]!="admin")
			{
				$_SESSION[SESSION_CLIENT_PREFIX . $key]="";
			}
			else
			{
				$_SESSION[SESSION_ADMIN_PREFIX . $key]="";
			}
		}
		
		function get_session($key)
		{
			$retval="";
			if($GLOBALS["scope"]!="admin")
			{
				if (!empty($_SESSION[SESSION_CLIENT_PREFIX . $key]))
					$retval=$_SESSION[SESSION_CLIENT_PREFIX . $key];
			}
			else
			{
				$retval=$_SESSION[SESSION_ADMIN_PREFIX . $key];
			}
			return $retval;
		}
		
		function is_authorized($link="index.php", $redirectionpage="")
		{
			$msgobj=new message();
			if ($this->get_session(ADMIN_USER_ID)=="")
			{
				$this->set_session(REDIRECT_PAGE, $redirectionpage);
				$strfrm="";
				$msgerr=trim($msgobj->send_msg($link,$strfrm,2));
				exit();
			}
		}
		function check_admin_login()
		{
			if(strripos($_SERVER['PHP_SELF'],"index")>0 && strlen($this->get_session(ADMIN_USER_ID))>0)
				{
				
					header("location: dashboard.php");
					exit();
				}
		}
	    function check_login()
		{
			if(strripos($_SERVER['PHP_SELF'],"login")>0 && strlen($this->get_session(CLIENT_USERID))>0)
				{
					header("location: my_account.php");
					exit();
				}
		}
		function is_authorized_client($link="index.php", $redirectionpage="")
		{
			$msgobj=new message();
			
			if ($this->get_session(CLIENT_USERID)=="")
			{
				$this->set_session(CLIENT_REDIRECT_PAGE, $redirectionpage);
				$this->set_session(CLIENT_REDIRECT_PAGE, $redirectionpage);
					
				header("location: " . $link);
				exit();
			}
		}
		
		function is_client_loggedin()
		{
			$ret = 0;
	
			if (!isset($_SESSION[SESSION_CLIENT_PREFIX . CLIENT_USERID]))
				$_SESSION[SESSION_CLIENT_PREFIX . CLIENT_USERID] = "";
	
			if ($this->get_session(CLIENT_USERID)=="")
				$ret = 0;
			else
				$ret = 1;
			
			return $ret;
		}
		
		function is_admin_loggedin()
		{
			$ret = 0;
			if (isset($_SESSION[SESSION_ADMIN_PREFIX . ADMIN_USER_ID]) && $_SESSION[SESSION_ADMIN_PREFIX . ADMIN_USER_ID]!="")
				$ret = 1;
			else
				$ret = 0;
				
			return $ret;
		}
			
		function padstring($str,$intChars)
		{
			$ret="";
			if(strlen($str)>$intChars-3)
			{
				$ret=substr($str,0,$intChars-3);
				$ret=str_pad($ret, $intChars, ".", STR_PAD_RIGHT);  
			}
			else
			{
				$ret=$str;
			}
				
			return $ret;
		}
		
		function submit_to($valDest)
		{		  
			print "<html><head></head><body>";
			print "<form name=\"frmSubmit\" action=\"".$valDest. "\">"."\r\n";
			print "</form>"."\r\n";
			print "<script>"."\r\n";
			print "document.frmSubmit.submit();\r\n";
			print "</script>"."\r\n";
			print "</body></html>";	
		}
		
		function getpostedvaluesashidden($strp="0", $arexclude = array(""))
		{
			$hiddenVars="";
			
			foreach($_POST as $k => $v)
			{
				$name = $k;
				$value = $v;
				
				if (in_array($name, $arexclude))
					continue;
				
				if ($name == "err")
					continue; 
				
				if (is_array($_POST[$k]))
				{
					$value = implode(",",$_POST[$k]);
				}
				if($strp=="1")	
				{
					$hiddenVars= $hiddenVars . $this->gethiddenstring($name,stripslashes($value));
				}
				else
				{
					$hiddenVars= $hiddenVars . $this->gethiddenstring($name,trim($value));
				}
			}
			
			return $hiddenVars;
		}
	
		function submitpostedvalues($valdest,$hvars="")
		{
			print "<html><head></head><body>";
			print "<form name=\"frmSubmit\" action=\"".$valdest. "\" method='POST'>"."\r\n";
			print $hvars;
			print "</form>"."\r\n";
			print "<script>"."\r\n";
			print "document.frmSubmit.submit();\r\n";
			print "</script>"."\r\n";
			print "</body></html>";	  
			//exit();
		}	
		
		function gethiddenstring($vname,$strval)
		{
			return "<input type='hidden' name='" . trim($vname) . "' value=\"". $this->setval($strval) ."\">\r\n";
		}
		
		function submit_val1($valDest,$strval)
		{
			print "<html><head></head><body>";
			print "<form name=\"frmSubmit\" action=\"".$valDest. "\" method='POST'>"."\r\n";
			print "<input type='hidden' name='err' value='". $strval ."'>";
			print "</form>"."\r\n";
			print "<script>"."\r\n";
			print "document.frmSubmit.submit();\r\n";
			print "</script>"."\r\n";
			print "</body></html>";
		}
		
		function getcurrentpagename()
		{
			$arPg=split("/",$_SERVER['PHP_SELF']);
			$lastIndex=count($arPg)-1;
			$pgName=substr($arPg[$lastIndex],0,strlen($arPg[$lastIndex])-4);
			
			return $pgName.".php";
		}
	
		function getreferralpagename()
		{
			$arPg=split("/",$_SERVER['HTTP_REFERER']);
			$lastIndex=count($arPg)-1;
			//$pgName=substr($arPg[$lastIndex],0,strlen($arPg[$lastIndex])-4);
			$pgname = $arPg[$lastIndex];
			
			return $pgname;
		}
	
		function getreferralservername()
		{
			$arPg=split("/",$_SERVER['HTTP_REFERER']);
			//$firstIndex=count($arPg)-1;
			$pgName=trim($arPg[0]);
			
			return $pgName;
		}
		
		function get_file_content($filename,$findstring="",$replacestringS="")
		{
			$filedata1 = "";	
			$lines = file($filename);
			foreach ($lines as $line_num => $line) 
			{
				$filedata1=$filedata1.$line;
			}
			
			return str_replace($findstring,$replacestringS,$filedata1);
		}
		
		function is_duplicate($strtable,$strfield,$strval,$strpkfield="",$strpkval="",$strcond="")
		{
			$retVal=false;
			
			if($strcond!="")
			{
				$strcond=" And " . $strcond;
			}
			if($strpkfield!="" && $strpkval!="")
			{
				$qry = "select *  from ". DB_PREFIX . $strtable ." where " . $strfield ."='" . $strval ."' and ".$strpkfield . "<> '".$strpkval."' ". $strcond;
			}
			else
			{
				$qry = "select *  from ". DB_PREFIX . $strtable ." where " . $strfield ."='" . $strval ."'". $strcond;
			}
			
			$rs = mysql_query($qry) or die(mysql_error());
			$total_record = mysql_num_rows($rs);
			if($total_record>0)
			{
				$retVal=true;	
			}
			else
			{
				$retVal=false;
			}
		
			mysql_free_result($rs);
			return $retVal;	
		}	
		
		function setval($str)
		{	
			if (!get_magic_quotes_gpc()) {
					$str = addslashes(trim($str));
			} else {
				$str = trim($str);
			}
			mysql_real_escape_string($str);
			$badWords = array("/delete/i", "/update/i","/union/i","/insert/i","/--/i","/shutdown/i"); //,"/http/i"
			$str = preg_replace($badWords, "", $str);
			$str = preg_replace("/(select)(.*?)(from)/i", " ", $str);
			$str = preg_replace("/(<script)(.*?)(<\/script>)/i", " ", $str);
			$str = preg_replace("/(<embed)(.*?)(<\/embed>)/i", " ", $str);
			$str = preg_replace("/(show)(.*?)(table)/i", " ", $str);
			$str = preg_replace("/(show)(.*?)(fields)/i", "", $str);
			return $str;
		}
		
		function getval($str)
		{	
			return stripslashes(trim($str));
		}
		
		function set_html_value($ctl,$value)
		{ 
			if (!empty($value) && !is_null($value) && $value!='') 
			{
				$strScrpt="<script language=\"javascript\" type=\"text/javascript\">";
				$strScrpt .=$ctl . ".value = \"" .$value ."\";";
				//$strScrpt .="alert(".$ctl. ".value)";
				$strScrpt .="</script>";
			}
			else 
			{
				$strScrpt = "";
			}
				echo($strScrpt);
		}
		
		function start_tran()
		{
			mysql_query("SET AUTOCOMMIT=0")  or die(mysql_error());
			mysql_query("START TRANSACTION")  or die(mysql_error());
		}
		
		function end_tran()
		{
			mysql_query("COMMIT")  or die(mysql_error());
			mysql_query("SET AUTOCOMMIT=1")  or die(mysql_error());
		}
		
		function rollback_tran()
		{
			mysql_query("ROLLBACK")  or die(mysql_error());
			mysql_query("SET AUTOCOMMIT=1")  or die(mysql_error());
		}
			
		function dateAdd($strDate,$intAddVal,$strAddPara="d",$strFormat="Y/m/d H:i:s",$strIFormat="d/m/Y",$strSep="/")
		{
		// strIFormat : Only Date Format
		// strSep : Only Date Seperater
		
		$arDate=split(" ",$strDate);
		
		$IDate = $arDate[0];
		$ITime = $arDate[1];
		
		if(count($arDate)>2)
		{
			$ITime=$arDate[1] . " " . $arDate[2];
		}	
		
			$d="";
			$m="";
			$y="";
			
			if($strFormat=="" || is_null($strFormat)==true)
			{
				$strFromat='m/d/Y';			
			}
			
			$s = split($strSep,$IDate);
			//print $s[0] . "," . $s[1] . "," . $s[2];
			switch($strIFormat)
			{
				case "Y/m/d":
					$d=$s[2];
					$m=$s[1];
					$y=$s[0];
					break;
				case "d/m/Y":
					$d=$s[0];
					$m=$s[1];
					$y=$s[2];
					break;
				case "m/d/Y":
					$d=$s[1];
					$m=$s[0];
					$y=$s[2];
					break;
			}
			
			$strTime=$ITime;
			if($ITime=="")
			{
				$strTime=date("H:i:s");
			}
		
			$t = split(":",date("H:i:s",strtotime($strTime)));
			
			$h=$t[0];
			$n=$t[1];
			$s=$t[2];
			
			$valH=0;
			$valI=0;
			$valS=0;
			
			$valD=0;
			$valM=0;
			$valY=0;
			
			switch(strtolower($strAddPara))
			{
				case "y":
					$valY=$intAddVal;
					break;
				case "m":
					$valM=$intAddVal;
					break;
				case "d":
					$valD=$intAddVal;
					break;
				case "h":
					$valH=$intAddVal;
					break;
				case "i":
					$valI=$intAddVal;
					break;
				case "s":
					$valS=$intAddVal;
					break;
			}
			
			$dt = mktime($h+$valH,$n+$valI,$s+$valS,$m+$valM,$d+$valD,$y+$valY);
			$dt1 = date($strFormat,$dt)	;
			return $dt1;
		}
			
		function formatdatetime($strDate,$strFormat,$strIFormat="d/m/Y",$strSep="/")
		{	
			$arDate=split(" ",$strDate);
			$IDate ="";
			$ITime ="";
	
			$IDate = $arDate[0];
			if(count($arDate)>1)
			{
				$ITime = $arDate[1];
			}
			if(count($arDate)>2)
			{
				$ITime=$arDate[1] . " " . $arDate[2];
			}
			
			$d="";
			$m="";
			$y="";
			
			if($strFormat=="" || is_null($strFormat)==true)
			{
				$strFromat='m/d/Y';		
			}
			
			$s = split($strSep,$IDate);
			
			switch($strIFormat)
			{
				case "Y-m-d":
				case "Y/m/d":
					$d=$s[2];
					$m=$s[1];
					$y=$s[0];
					break;
				case "d/m/Y":
					$d=$s[0];
					$m=$s[1];
					$y=$s[2];
					break;
				case "m/d/Y":
					$d=$s[1];
					$m=$s[0];
					$y=$s[2];
					break;
			}
			
			$strTime=$ITime;
			
			if($ITime=="")
			{
				$strTime=date("H:i:s");
			}
		
			$t = split(":",date("H:i:s",strtotime($strTime)));
			
			$h=$t[0];
			$n=$t[1];
			$s=$t[2];
			
			$dt = mktime($h,$n,$s,$m,$d,$y);
			$dt1 = date($strFormat,$dt)	;
			return $dt1;
		}
		
		function now()
		{
			return date("Y-m-d H:i:s");
		}
		
		function today()
		{
			return date("Y-m-d");
		}
		
		function debug($str,$exit="n")
		{
			print $str;
			if ($exit=="y")
				exit();			
		}
		
		function display($aVar, $doExit=0, $showType=0)
		{
			if ($showType == 0)
			{
				print "<pre>";
				print_r($aVar);
				print "</pre>";
				if($doExit == 1)
				{
					exit();
				}
			}
			elseif ($showType == 1)
			{
				print "<pre>";
				var_dump($aVar);
				print "</pre>";
				if($doExit == 1)
				{
					exit();
				}
			}
		}
	
		function runquery($qry)
		{
			$rs=mysql_query($qry);
			return $rs;
		}
		
		function checkpostmethod($redirect)
		{
			if(strtolower(trim($_SERVER['REQUEST_METHOD'])) != "post")
			{	
				header ('Location: '. $redirect);
				exit();
			}
		}	
		
		function checkreferral($refferal, $redirect)
		{
			if (strtolower(trim($this->getreferralpagename())) != strtolower(trim($refferal)))
			{	
				header ('Location: '. $redirect);
				exit();
			}
		}
		
		function showerror($msg)
		{
			$ret = "";
			$ret = str_replace("\\","",$msg);
			$ret = str_replace("&quot;","",$ret);
			
			return $ret;
		}
		
		function validatedeletedids($id, $tables)
		{
			$deletable = true;
			foreach ($tables as $table)
			{
				$qry = "SELECT count(*) AS count FROM ".DB_PREFIX.$table['table']." WHERE ". $table['field']."=".$id;
				
				$rs = mysql_query($qry);
				while ($tmp = mysql_fetch_assoc($rs))
				{
					if ($tmp['count']>0) $deletable = false;
				}
	
			}
			return $deletable;
		}
		
		function changekeys($arr, $sep)
		{
			$return = array();
			
			if (is_array($arr))
			{
				foreach($arr as $key=>$value)
				{
					array_push($return,$sep.$value.$sep);
				}
			}			
			return $return;	
		}
		
		function extractpostvalues($request, $fields)
		{
			$return = array();
		
			if(is_array($request))
			{	
				if (is_array($fields))
				{
					foreach($fields as $key=>$value)		
					{			
						if (array_key_exists($value, $request))
							$return[$value] = trim($request[$value]);
						else
							$return[$value] = '';
					}
				}
			}
			
			return $return;
		}
		
		function timestamp()
		{
			return date("Y") . date("m") . date("d") . date("H") . date("i") . date("s");
		}
		
		function checkmatchingvalue($value, $table, $matchfield, $retrunfield)
		{
			$qry = "SELECT ".$retrunfield." FROM ".$table." WHERE ".$matchfield." LIKE '".$value."'";
			$rs = $this->runquery($qry);
			
			if(is_resource($rs) && mysql_num_rows($rs)==1)
			{
				$row = mysql_fetch_assoc($rs);
				return $row[$retrunfield];
			}
			elseif(is_resource($rs) && mysql_num_rows($rs)>1)
			{
				return "more then one value";
			}
			elseif(is_resource($rs) && mysql_num_rows($rs)==0)
			{
				return "no matching value";
			}
			else 
			{
				return false;
			}
		}
		
		function get_zipcodefilterquery($zip_code,$dist_val)
		{
		
			$dist_condition ="";
			$zip_lat = "";
			$zip_long = "";
			$dist_range ="";
			$dist_operator = "<=";
			
			if($dist_val != "")
			{
			
				$dist_range = " and ROUND(distence) " . $dist_operator . $dist_val;
				
				$qryZip = "select latitude,longitude from ( select '" .$zip_code ."' as zipcode,(select latitude from zip_codes where zip='" .$zip_code ."') as latitude,(select longitude from zip_codes where zip='" .$zip_code ."') as longitude) as a ";
				
				$rsZip	=	$this->runquery($qryZip);
				if($arZip = mysql_fetch_array($rsZip))
				{
					$zip_lat =$arZip["latitude"];
					$zip_long=$arZip["longitude"];
				}
			
			//exit("-->" . $dist_val);
				
				$dist_condition = " and co.userid in (select userid from (
				select *,(6371.0*acos(
				
				(sin(0.01745329252*". $zip_lat .")*sin(0.01745329252*latitude))
				+ 
				(
				cos(0.01745329252*". $zip_lat .")*cos(0.01745329252*latitude)* 
				cos((0.01745329252*(". $zip_long ."))-(0.01745329252*(longitude)))
				)
				)) as distence from
				( select cu.userid,cu.zipcode,(select latitude from zip_codes where zip=cu.zipcode) as latitude,(select longitude from zip_codes where zip=cu.zipcode) as longitude from car_user cu) as a
				where latitude is not null and longitude is not null) as b
				where 1=1 ". $dist_range ." )";
				
				if($zip_lat=='' || is_null($zip_lat))
				{
					$dist_condition = " and co.userid in (0)";
				}
			
				if($zip_long=='' || is_null($zip_long))
				{
					$dist_condition = " and co.userid in (0)";
				}
			
				
			}elseif($zip_code !="")
			{
				$dist_condition = " and co.userid in ( select userid from car_user where zipcode='" . $zip_code . "' )";
			}
	
			return($dist_condition);	
		}
		
		function store_db_compatiblevalue($str)
		{
			$str = str_replace("'","&#039;",$str);
			return $str;
		}
		
		function fillcombo($table, $sql="", $value, $display, $selected)
		{
		if (trim($sql) == "")
			$qry = "SELECT $value, $display FROM $table WHERE 1 order by $display ";
		else
			$qry = $sql;
	
		$res = mysql_query($qry) or die(mysql_error());
	
		if(mysql_num_rows($res)>0)
		{
			while ($row = mysql_fetch_array($res))
			{
				print "<option value='". $this->getval($row[$value]) . "' ";
	
				if ($selected == $row[$value]) { print "selected=\"selected\""; }
				print ">" . $this->getval($row[$display]) . "</option>";
			}	
			
			mysql_free_result($res);
		}	
		}
			
		function uploadandresizeimage($name,$width=114,$height=114,$dest_dir, $imgid="",$index=-1)
		{	
			global $imgdir;
			global $thumbfld; 
			global $largefld; 
			global $img;
			
			if($_FILES[$name]['name'] || ($index>-1 && $_FILES[$name]['name'][$index]))
			{		
				if($index==-1)
					$file=date('Y-m-d-H-i-s-u').$_FILES[$name]['name'];				
				else
					$file=date('Y-m-d-H-i-s-u').$_FILES[$name]['name'][$index];
					
				$imgdir = $dest_dir;
	
				if($index==-1)
					$boolcopy = copy($_FILES[$name]['tmp_name'],$imgdir.$file);	
				else
					$boolcopy = copy($_FILES[$name]['tmp_name'][$index],$imgdir.$file);	
					
				if($boolcopy)
				{
					$percent=0;
					$img = $imgdir.$file;
					
					// get image extention
					$extention=substr($img,strrpos($img, '.'));
					
					// get image file name
					if (trim($imgid) == "")
						$img_name=substr($file,0,strrpos($file, '.'));
					else
						$img_name = $imgid;
					
					// set resize image file name	
		//			$resizefile=$imgdir.$img_name.'_'.$imagetype.$extention;
					//$resizefile=$imgdir.$img_name.$extention;
					$resizefile=$imgdir.$width.'x'.$height.'_'.$img_name.$extention;
			
					// get image size of img
					$x = @getimagesize($img);
					
					// image width
					$sw = $x[0];
					// image height
					$sh = $x[1];
				
					if ($percent > 0) 
					{
						// calculate resized height and width if percent is defined
						$percent = $percent * 0.01;
						$width = $sw * $percent;
						$height = $sh * $percent;
					} 
					else 
					{
						if (isset ($width) AND !isset ($height)) 
						{
							// autocompute height if only width is set
							$height = (100 / ($sw / $width)) * .01;
							$height = @round ($sh * $height);
						} 
						elseif (isset ($height) AND !isset ($width)) 
						{
							// autocompute width if only height is set
							$width = (100 / ($sh / $height)) * .01;
							$width = @round ($sw * $width);
						} 
						elseif (isset ($height) AND isset ($width) ) 
						{
							// get the smaller resulting image dimension if both height
							// and width are set and $constrain is also set
							$hx = (100 / ($sw / $width)) * .01;
							$hx = @round ($sh * $hx);
					
							$wx = (100 / ($sh / $height)) * .01;
							$wx = @round ($sw * $wx);
					
							if ($hx < $height) 
							{
								$height = (100 / ($sw / $width)) * .01;
								$height = @round ($sh * $height);
							} 
							else 
							{
								$width = (100 / ($sh / $height)) * .01;
								$width= @round ($sw * $width);
							}
						}				
					}					
		
					if(strcmp($extention,'.gif')==0 or strcmp($extention,'.GIF')==0)
					{
						$im = @ImageCreateFromGIF($img); // or GIF Image	
		
					}
					elseif(strcmp($extention,'.png')==0 or strcmp($extention,'.PNG')==0)
					{
						$im = @ImageCreateFromPNG($img); // or PNG Image	
					}
					elseif(strcmp($extention,'.jpg')==0 or strcmp($extention,'.jpeg')==0 or strcmp($extention,'.JPG')==0 or strcmp($extention,'.JPEG')==0)
					{
						$im = @ImageCreateFromJPEG($img); // Read JPEG Image		
					}
					else
					{
						$im = false; // If image is not JPEG, PNG, or GIF	
					}	
		
					if ($im) 
					{	
						if($height>$sh and  $width>$sw)
						{
							$height=$sh;
							$width=$sw;
							$thumb=$im;
						}
						else
						{
							// Create the resized image destination
							$thumb = @ImageCreateTrueColor ($width, $height);
							 imagecolorallocate($thumb, 0xFF, 0xFF, 0xFF);
									
							// Copy from image source, resize it, and paste to image destination
							@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $width, $height, $sw, $sh);
		
						}
						if(strcmp($extention,'.gif')==0 or strcmp($extention,'.GIF')==0)
						{
							if(imagegif($thumb,$resizefile)) //Output a gif image to either the browser or a file
							{
								$returnname=$img_name.$extention;
		
							}				
						}
						elseif(strcmp($extention,'.png')==0 or strcmp($extention,'.PNG')==0)
						{
							if(imagepng($thumb,$resizefile)) //Output a png image to either the browser or a file
							{
		
								$returnname=$img_name.$extention;
							}				
						}
						elseif(strcmp($extention,'.jpg')==0 or strcmp($extention,'.jpeg')==0 or strcmp($extention,'.JPG')==0 or strcmp($extention,'.JPEG')==0)
						{
							if(imagejpeg($thumb,$resizefile)) //Output a jpg image to either the browser or a file
							{
								$returnname=$img_name.$extention;
		
							}				
						}
					}
					//Removes original
					//unlink($imgdir.$file);
				}		
			}	
			return $returnname;
		}

		function upload($name,$old,$dir=NULL,$new_name='',$index=-1)
		{
			if($index==-1){
				if($_FILES[$name]['name']){
					if( is_file($dir.$old) ) unlink($dir.$old);
					
					$ext=substr($_FILES[$name]['name'],strrpos($_FILES[$name]['name'],"."),strlen($_FILES[$name]['name']));
			
					$file	= ($new_name == '') ? $_FILES[$name]['name'] : $new_name . $ext;
					copy($_FILES[$name]['tmp_name'],$dir.$file);
			
				}else{
					$file=$old;
				}
			}
			else {
				if($_FILES[$name]['name'][$index]){
					if( is_file($dir.$old) ) unlink($dir.$old);
					
					$ext=substr($_FILES[$name]['name'][$index],strrpos($_FILES[$name]['name'][$index],"."),strlen($_FILES[$name]['name'][$index]));
			
					$file	= ($new_name == '') ? $_FILES[$name]['name'] : $new_name . $ext;
					copy($_FILES[$name]['tmp_name'][$index],$dir.$file);
			
				}else{
					$file=$old;
				}
			}	
			return($file);
		}
		
		function format_date($format,$date)
		{
			return date($format, strtotime($date));	
		}
		
		function delete_temporary_image($file_array){
			if(file_exists($_FILES[$file_array]["tmp_name"])) unlink($_FILES[$file_array]["tmp_name"]);
			return true;
		}
		
		function strrand($length) 
		{ 
			$str = ""; 
			
			while(strlen($str)<$length){ 
			$random=rand(48,122); 
			if( ($random>47 && $random<58) || ($random>64 && $random<91) || ($random>96 && $random<123) ){ 
			$str.=chr($random); 
			} 
			
			} 
			return $str; 
		}
		
		function header_location($page="index.php"){
			header("Location: $page");
			exit();
		}
		
		function read_value(&$input_value, $default_value)
		{
			if (isset($input_value))
				return $input_value;
			else
				return $default_value;
		}
			
		function get_current_page_url()
		{
			$page_url = 'http';
			
			if (strpos($_SERVER['SERVER_PROTOCOL'],"https") !== false) 
			{
				$page_url .= "s";
			}
			$page_url .= "://";
			if ($_SERVER["SERVER_PORT"] != "80")
			{
				$page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			}
			else
			{
				$page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			
			return $page_url;
		}
		function phpmailer($email_to, $subject, $message, $email_to_name = '', $email_from = '', $email_from_name = '', $email_cc = '', $email_cc_name = '', $email_bcc = '', $email_bcc_name = '',$attachment = '',$attachment_name = '') {
			if ( $GLOBALS['scope'] == 'admin' ) {
				require_once 'class/class.phpmailer.php';
				require_once 'class/class.pop3.php';
				require_once 'class/class.smtp.php';
			}
			else {
				require_once ADMIN_PANEL_PATH . 'class/class.phpmailer.php';
				require_once ADMIN_PANEL_PATH . 'class/class.pop3.php';
				require_once ADMIN_PANEL_PATH . 'class/class.smtp.php';
			}		
			
			$objmail			=	new PHPMailer;
			
			switch ( MAILER ) {
				case 'SIMPLE':
					$objmail->IsMail();
					break;	
				case 'SMTP':
					$objmail->IsSMTP();
					$objmail->Host = SMTP_SERVER;
					$objmail->Port = SMTP_PORT;
					if ( SMTP_AUHTENTICAION ) {
						$objmail->SMTPAuth = true;
						$objmail->Username = SMTP_USER_NAME; 
						$objmail->Password = SMTP_USER_PASSWORD;
					}
					break;	
				case 'SENDMAIL':
					$objmail->IsSendmail();
					break;	
			}
			
			$objmail->FromName	=	$email_from_name;
			$objmail->From     	=	$email_from;
			$objmail->Subject	=	$subject;
			$objmail->Body		=	$message;
			$objmail->AltBody	=	"";
			$objmail->IsHTML(true);
			$objmail->AddAddress($email_to, $email_to_name);
			if ( $email_cc != '' ) {
				$objmail->AddCC($email_cc, $email_cc_name);
			}
			if ( $email_bcc != '' ) {
				$objmail->AddBCC($email_bcc, $email_bcc_name);
			}
			if ( $attachment != '' && file_exists($attachment) && is_file($attachment) ) {
				$objmail->AddAttachment($attachment,$attachment_name);
			}
			$objmail->Send();	

		}
		
		function send_mail ($email_to, $subject, $message, $email_to_name = '', $email_from = '', $email_from_name = '', $email_cc = '', $email_cc_name = '', $email_bcc = '', $email_bcc_name = '',$attachment = '',$attachment_name = '') {
			if ( $GLOBALS['scope'] == 'admin' ) {
				require_once 'class/class.phpmailer.php';
				require_once 'class/class.pop3.php';
				require_once 'class/class.smtp.php';
			}
			else {
				require_once ADMIN_PANEL_PATH . 'class/class.phpmailer.php';
				require_once ADMIN_PANEL_PATH . 'class/class.pop3.php';
				require_once ADMIN_PANEL_PATH . 'class/class.smtp.php';
			}		
			
			$objmail			=	new PHPMailer;
			
			switch ( MAILER ) {
				case 'SIMPLE':
					$objmail->IsMail();
					break;	
				case 'SMTP':
					$objmail->IsSMTP();
					$objmail->Host = SMTP_SERVER;
					$objmail->Port = SMTP_PORT;
					if ( SMTP_AUHTENTICAION ) {
						$objmail->SMTPAuth = true;
						$objmail->Username = SMTP_USER_NAME; 
						$objmail->Password = SMTP_USER_PASSWORD;
					}
					break;	
				case 'SENDMAIL':
					$objmail->IsSendmail();
					break;	
			}
			
			$objmail->FromName	=	$email_from_name;
			$objmail->From     	=	$email_from;
			$objmail->Subject	=	$subject;
			$objmail->Body		=	$message;
			$objmail->AltBody	=	"";
			$objmail->IsHTML(true);
			$objmail->AddAddress($email_to, $email_to_name);
			if ( $email_cc != '' ) {
				$objmail->AddCC($email_cc, $email_cc_name);
			}
			if ( $email_bcc != '' ) {
				$objmail->AddBCC($email_bcc, $email_bcc_name);
			}
			if ( $attachment != '' && file_exists($attachment) && is_file($attachment) ) {
				$objmail->AddAttachment($attachment,$attachment_name);
			}
			$objmail->Send();	

		}
		
		function is_record_exists($strtable, $strfield, $strval, $strcond = "")
		{
			$retVal = false;		
			
			if(trim($strfield) != "" && trim($strval) != "")
			{
				$qry = "select count(*) total from ". DB_PREFIX . $strtable ." where " . $strfield ."='" . $strval ."' ";
			}
			
			if($strcond != "")
			{
				$qry .= " " . $strcond;
			}		
			$rs = mysql_query($qry) or die(mysql_error());
			$total_record = mysql_num_rows($rs);
			
			if($total_record > 0)
			{
				while ($row = mysql_fetch_assoc($rs))
				{
					if ($row['total'] > 0)
						$retVal=true;						
				}
			}
		
			mysql_free_result($rs);
			return $retVal;	
		}	
		
		function export_to_csv($table,$filename = 'export.csv')
		{
			$csv_terminated = "\n";
			$csv_separator = ",";
			$csv_enclosed = '"';
			$csv_escaped = "\\";
			
			if($table == 'order')
				$sql_query="SELECT *, (if ( pay_by_check = 'n', 'Paypal', 'Pay by Check')) payment_method, (SELECT SUM(product_price * quantity) FROM " . DB_PREFIX . "order_item WHERE order_id = " . DB_PREFIX . "order_master.order_id) representative_order_total, (SELECT CONCAT(first_name, ' ', last_name) FROM " . DB_PREFIX . "customer WHERE customer_id = " . DB_PREFIX . "order_master.representative_id) representative_name ,(sales_tax + shipping_charge + (SELECT SUM(product_price * quantity) FROM " . DB_PREFIX . "order_item WHERE order_id = " . DB_PREFIX . "order_master.order_id) - discount) order_total, DATE_FORMAT(order_date, '" . MYSQL_ORDER_DATE_FORMAT . "') order_date_display, (SELECT CONCAT(first_name, ' ', last_name) FROM " . DB_PREFIX . "customer WHERE customer_id = " . DB_PREFIX . "order_master.customer_id ) customer_name FROM ".DB_PREFIX."order_master WHERE 1=1 " . $condition . $order;
			else
				$sql_query = "select * from " . DB_PREFIX . $table;
				
				
			// Gets the data from the database
			$result = mysql_query($sql_query);
			$fields_cnt = mysql_num_fields($result);
			$schema_insert = '';
			for ($i = 0; $i < $fields_cnt; $i++)
			{
				$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
					stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
				$schema_insert .= $l;
				$schema_insert .= $csv_separator;
			} // end for
			$out = trim(substr($schema_insert, 0, -1));
			$out .= $csv_terminated;
			// Format the data
			while ($row = mysql_fetch_array($result))
			{
				$schema_insert = '';
				for ($j = 0; $j < $fields_cnt; $j++)
				{
					if ($row[$j] == '0' || $row[$j] != '')
					{
						if ($csv_enclosed == '')
						{
							$schema_insert .= $row[$j];
						} else
						{
							$schema_insert .= $csv_enclosed .
							str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
						}
					} else
					{
						$schema_insert .= '';
					}
					if ($j < $fields_cnt - 1)
					{
						$schema_insert .= $csv_separator;
					}
				} // end for
				$out .= $schema_insert;
				$out .= $csv_terminated;
			} // end while
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Length: " . strlen($out));
			// Output to browser with appropriate mime type, you choose ;)
			header("Content-type: text/x-csv");
			//header("Content-type: text/csv");
			//header("Content-type: application/csv");
			header("Content-Disposition: attachment; filename=$filename");
			echo $out;
			exit;
		}
		
		function export_to_excel ( $recordset, $params, $report_name, $excel_file = 'export.xls' ) {
	  
			  if ( $recordset && mysql_num_rows($recordset) ) {
				  
				  require_once 'php-excel/PHPExcel.php';
				  
				  $objPHPExcel = new PHPExcel();
				  
				  /*$data = array(
						 array('title'		=> 'Excel for dummies',
								'price'		=> 17.00,
								'quantity'	=> 2
							   ),
						  array('title'		=> 'PHP for dummies',
								'price'		=> 15.05,
								'quantity'	=> 1
							   ),
						  array('title'		=> 'Inside OOP',
								'price'		=> 12.50,
								'quantity'	=> 1
							   )
						 );*/
				  
				  //$objPHPExcel->getActiveSheet()->setCellValue('D1', PHPExcel_Shared_Date::PHPToExcel(time()));
				
				  //heading
				  if ( is_array($params) && count($params) ) {
					$start_col = 'A';
					$counter = 0;
					$row = 1;
					foreach ( $params as $param ) {
						$column = chr(ord($start_col) + $counter);
						$objPHPExcel->getActiveSheet()->setCellValue($column.$row, $param['column_heading']);
						$counter++;
					}	  
				 }
				  //end heading
				  
				  $baseRow = 3;		
				  $r = 0;
				  
				  while ( $record = mysql_fetch_assoc($recordset) ) {
					  
						$start_col = 'A';
						$counter = 0;
						
						$row = $baseRow + $r;
						
						$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
						
						foreach ( $params as $param ) {
							
							$field = $this->getval($param['field']);
							
							$column = chr(ord($start_col) + $counter);
							
							if ( $param['format'] == 'decimal' ) {
								$objPHPExcel->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
							}
												
							$objPHPExcel->getActiveSheet()->setCellValue($column.$row, $record[$field]);
							
							$counter++;
							
						}	  
						
						$r++;
				  }
				  
		
		/*		  $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
			
				  $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $dataRow['title']);
			
				  $objPHPExcel->getActiveSheet()->getStyle('B'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
				  $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $dataRow['price']);
				
				  $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dataRow['quantity']);*/
				  
				
				  $objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);
				
				  // Rename sheet
				  //$objPHPExcel->getActiveSheet()->setTitle('Simple');
				
				  $objPHPExcel->setActiveSheetIndex(0);
				
				  //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2003');
				  //$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
				  header('Content-Type: application/vnd.ms-excel');
				  header('Content-Disposition: attachment;filename="'.$excel_file.'"');
				  header('Cache-Control: max-age=0');
			
				 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				 $objWriter->save('php://output');
			 
			  }
			  
		  }
		
		function get_user_details ( $email ) {
			$arreturn = array();
			$strquery = 'SELECT first_name, email, user_name, password FROM ' . DB_PREFIX . 'freelancer WHERE email = \''. $email .'\' AND freelancer_active = \'y\' LIMIT 1';
			$strquery .=' UNION ';
			$strquery .= 'SELECT first_name, email, user_name, password FROM ' . DB_PREFIX . 'buyer WHERE email = \''. $email .'\' AND buyer_active = \'y\' LIMIT 1';
			$rsuser = mysql_query($strquery) or die(mysql_error());
			if ( $rsuser && mysql_num_rows($rsuser) ) {
				$arreturn[] = mysql_fetch_assoc($rsuser);	
			}
			mysql_free_result($rsuser);
			return $arreturn;
		}
		
		function check_access_right ( $user_type, $redirect_page ) {
			if ( $user_type != $this->get_session(CLIENT_USER_TYPE)  ) {
				global $msg;
				$msg->send_msg($redirect_page, '', 44);
				exit();
			}
		}
		
		function get_formatted_date ( $value, $source_format, $destination_format, $separator = '-' ) {
			$return = '';
			if ( $value != '' ) {
				if ( strlen($value) == 10 ) {
					$year = '';
					$month = '';
					$day = '';
					if ( $source_format == 'MMDDYY' ) {
						$data = explode($separator, $value);
						$year = (int) $data[2];
						$month = (int) $data[0];
						$day = (int) $data[1];
					}
					if ( $destination_format == 'YYMMDD' ) {
						$return = $year . $separator . $month . $separator . $day;	
					}
				}
			}
			return $return;
		}
		
		function get_date_range ( $start_date, $end_date ) {
			$return = array();
			$increment = 0;
			while ( true ) {
				$query = 'SELECT DATE_ADD(\'' . $start_date . '\', INTERVAL ' . $increment . ' DAY) new_date, DATE_FORMAT(DATE_ADD(\'' . $start_date . '\', INTERVAL ' . $increment . ' DAY), \'' . MYSQL_DATE_FORMAT . '\') new_date_display';
				$rs = mysql_query($query) or die(mysql_error());
				if ( $rs && mysql_num_rows($rs) ) {
					$array = mysql_fetch_assoc($rs);
					$return[] = $array;
					if ( $end_date == $this->getval($array['new_date']) ) {
						break;	
					}
				}
				mysql_free_result($rs);
				$increment++;
			}
			return $return;
		}
		
		function search_freelancer ( $freelancers, $freelancer_id ) {
			$return = array();
			if ( is_array($freelancers) && count($freelancers) ) {
				foreach ( $freelancers as $freelancer ) {
					if ( intval($freelancer['freelancer_id']	) == $freelancer_id ) {
						$return = $freelancer;
						break;	
					}
				}	
			}		
			return $return;
		}
		
		function direct_login_from_admin ( $side = 'BUYER' ) {
			if ( $side == 'BUYER' ) {
				if ( isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'view_buyer' && isset($_POST['hdnbuyer_id']) && intval($_POST['hdnbuyer_id']) > 0 ) {
					include_once ADMIN_PANEL_PATH . 'class/clsbuyer.php';
					$objbuyer = new buyer();
					$buyer = $objbuyer->fetchallasarray((int) $_POST['hdnbuyer_id']);
					$this->login_user($this->getval($buyer[0]['user_name']), $this->getval($buyer[0]['password']));
				}
			}
			if ( $side == 'FREELANCER' ) {
				if ( isset($_POST['hdnmode']) && trim($_POST['hdnmode']) == 'view_freelancer' && isset($_POST['hdnfreelancer_id']) && intval($_POST['hdnfreelancer_id']) > 0 ) {
					require_once ADMIN_PANEL_PATH . 'class/clsfreelancer.php';
					$objfreelancer = new freelancer();
					$freelancer = $objfreelancer->fetchallasarray((int) $_POST['hdnfreelancer_id']);
					$this->login_user($this->getval($freelancer[0]['user_name']), $this->getval($freelancer[0]['password']));
				}
			}
		}			
		
		function is_live_file ( $file ) {
			$return = false;
			if ( file_exists($file) && is_file($file) ) {
				$return = true;	
			}
			return $return;
		}
		
		function set_page_state ( ) {
			
			$page = basename($_SERVER['PHP_SELF']);
			if ( isset($_GET['search']) && trim($_GET['search']) == 'reset' ) {
				$this->remove_previous_page_state($page);
				return;
			}
			
			$set_session = false;
			
			$page_state = array(
					'page' => ''
					, 'search' => array()
					, 'order' => array()
					, 'paging' => array()
				);
				
			$page_state = $this->get_page_state();
			
			$page_state['page'] = $page;
			
			if ( isset($_GET['btnsearch']) ) {
				$search_field_value_array = array();
				foreach ( $_GET as $key => $value ) {
					if ( strstr($key, 'search_') ) {
						$search_field = str_replace('search_', '', $key);
						$search_value = '';
						if ( isset($_GET[$key]) && trim($_GET[$key]) != '' ) {
							$search_value = $this->setval($_GET[$key]);	
						}
						$search_field_value_array[$search_field] = $search_value;
					}		
				}	
				$page_state['search'] = $search_field_value_array;
				$page_state['paging']['current_page'] = 1;
				$set_session = true;
			}
			
			if ( isset($_POST['hdnorderby']) && trim($_POST['hdnorderby']) != '' && isset($_POST['hdnorder']) && trim($_POST['hdnorder']) != '' ) {
				$page_state['order']['order_field'] = trim($_POST['hdnorderby']);
				$page_state['order']['order_type'] = trim($_POST['hdnorder']);
				$set_session = true;
			}
			
			if ( isset($_POST['txtpagesize']) && intval($_POST['txtpagesize']) > 0 ) {
				$page_state['paging']['records_per_page'] = (int) $_POST['txtpagesize'];
			}
			if ( isset($_POST['txtcurrentpage']) && intval($_POST['txtcurrentpage']) > 0 ) {
				$page_state['paging']['current_page'] = (int) $_POST['txtcurrentpage'];
			}
							
			if ( $set_session ) {
				$this->remove_previous_page_state($page);
				$page_states = $this->get_all_page_state();
				$page_states[] = $page_state;
				$_SESSION[PAGE_STATE] = $page_states;
			}
					
		}
		
		function get_page_state ( ) {
			$page = basename($_SERVER['PHP_SELF']);
			$return = array();
			if ( isset($_SESSION[PAGE_STATE]) ) {
				foreach ( $_SESSION[PAGE_STATE] as $page_state ) {
					if ( $page_state['page'] == $page ) {
					$return = $page_state;
					}
				}
			}
			return $return;
		}
		
		function get_all_page_state ( ) {
			$return = array();
			if ( isset($_SESSION[PAGE_STATE]) && is_array($_SESSION[PAGE_STATE]) && count($_SESSION[PAGE_STATE]) ) {
				$return = $_SESSION[PAGE_STATE];	
			}
			return $return;
		}
		
		function remove_previous_page_state ( $page ) {
			if ( isset($_SESSION[PAGE_STATE]) ) {
				foreach ( $_SESSION[PAGE_STATE] as $key => $page_state ) {
					if ( $page_state['page'] == $page ) {
						unset($_SESSION[PAGE_STATE][$key]);
					}
				}
			}
		}
		
		function getImageSRC($imageName='no-image.gif', $dirPath=NO_IMAGE_DIR)
		{
			if(is_file($dirPath.$imageName) and file_exists($dirPath.$imageName))
				return $dirPath.$imageName;
			else
				return NO_IMAGE_AVAILABLE;
		}
		
		/**
		 * Function is Limit string (Use when you want to limit length)
		 *
		 * @access      public
		 * @author      Alice N. Kachiya <ank@aipl.com>
		 * @param       mixed [$string] HTML or String
		 * @param       int [$limit] # limit of charecter
		 * @param       mixed [$break] Break with (e.g. "." for santance breaking)
		 * @param       mixed [$tail] Ending string
		 * @return      mixed HTML/string
		 * @package     ANK
		 * @since       Version 1.0 and Date 06-09-2011
		 * @subpackage  ANK Text Limit
		 * @version		1.0
		 *  
		 */

		function textLimit($string, $limit, $break=" ", $tail="...")
		{
			// return with no change if string is shorter than $limit
			if(strlen($string) <= $limit) return $string;

			// is $break present between $limit and the end of the string?
			if(false !== ($breakpoint = strpos($string, $break, $limit)))
			{
				if($breakpoint < strlen($string) - 1) {
					$string = substr($string, 0, $breakpoint) . $tail;
				}
			}
			
			return $string;
		}
		
		/**
		 * Function is for close unclosed tags
		 *
		 * @access      public
		 * @author      Alice N. Kachiya <ank@aipl.com>
		 * @param       mixed [$unclosedString] Unclosed HTML
		 * @return      mixed Complete HTML
		 * @package     ANK
		 * @since       Version 1.0 and Date 12-08-2011
		 * @subpackage  ANK close unclosed tags
		 * @version		1.0
		 *  
		 */
		 
		function closeUnclosedTags($unclosedString)
		{ 
			preg_match_all("/<([^\/]\w*)>/", $closedString = $unclosedString, $tags); 
			
			for($i=count($tags[1])-1; $i>=0; $i--)
			{ 
				$tag = $tags[1][$i];
				
				if(substr_count($closedString, "</$tag>") < substr_count($closedString, "<$tag>"))
					$closedString .= "</$tag>";
			}
			
			return $closedString; 
		}
		
		/**
		 * Function is for send mail using SOAP client
		 *
		 * @access      public
		 * @author      Vipul Tanna
		 * @param       string	[$email_to]		Email address for To
		 * @param       string	[$subject]		Subject line for Mail
		 * @param       mixed	[$message]		Mail body (HTML/Text)
		 * @param       string	[$email_cc]		Email address for Cc
		 * @param       string	[$email_bcc]	Email address for Bcc
		 * @return      boolian (0 = mail not sent, 1 = mail sent successfully)
		 * @since       Version 1.0 and Date 27-08-2012
		 * @version		1.0
		 * 
		 */
		 
		function sendTransactionalMail($email_to, $subject, $message)
		{
			$wsdlLocation = TRANSACTIONAL_MAIL_SERVER_PATH;
			$username = STRONGMAIL_USERNAME;
			$password = STRONGMAIL_PASSWORD;
			$mailingName = 'ElectionImpactDefaultMailTextHtml';

			ini_set("soap.wsdl_cache_enabled", "0"); 

			$client = new SoapClient($wsdlLocation, array('trace' => 1));
			//EmailAddress::UniqueId::FirstName::LastName::Username::Password::URL::FromName::FromEmail::ReplyEmail::BounceEmail::SubjectLine::MailBody 
			
			$sMessageBody = str_replace("\n","",$message);
			$email_from = "salesconsultant@votenet.com";
		
			$records = "$email_to::''::''::''::''::''::''::Election Impact::$email_from::salesconsultant@votenet.com::salesconsultant@votenet.com::$subject::$sMessageBody";

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
 
		function sendTransactionalMailWithCcBcc($email_to, $subject, $message, $email_cc, $email_bcc)
		{
			$wsdlLocation = TRANSACTIONAL_MAIL_SERVER_PATH;
			$username = STRONGMAIL_USERNAME;
			$password = STRONGMAIL_PASSWORD;
			$mailingName = 'ElectionImpactDefaultMailMarketing';

			ini_set("soap.wsdl_cache_enabled", "0"); 

			$client = new SoapClient($wsdlLocation, array('trace' => 1));
			//EmailAddress::UniqueId::FirstName::LastName::Username::Password::URL::FromName::FromEmail::ReplyEmail::BounceEmail::SubjectLine::MailBody 
			
			$sMessageBody = str_replace("\n","",$message);
			$email_from = "salesconsultant@votenet.com";
		$records = "$email_to::''::''::''::''::''::''::''::''::Election Impact::$email_from::support@votenet.com::support@votenet.com::$subject::$sMessageBody::$email_cc::$email_bcc";

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
	}