<?php
	/** Default error messages*/
	define("E_VAL_REQUIRED_VALUE","Please enter the value for <strong>%s</strong>.");
	define("E_VAL_MAXLEN_EXCEEDED","Maximum length exceeded for <strong>%s</strong>.");
	define("E_VAL_MINLEN_CHECK_FAILED","Please enter input with length more than <strong>%d</strong> for <strong>%s</strong>.");
	define("E_VAL_ALNUM_CHECK_FAILED","Please provide an alpha-numeric input for <strong>%s</strong>.");
	define("E_VAL_ALNUM_S_CHECK_FAILED","Please provide an alpha-numeric input for <strong>%s</strong>.");
	define("E_VAL_NUM_CHECK_FAILED","Please provide numeric input for <strong>%s</strong>.");
	define("E_VAL_PASSWORD_CHECK_FAILED","Please provide valid input for <strong>%s</strong>.");
	define("E_VAL_USERNAME_CHECK_FAILED","Please provide valid input for <strong>%s.</strong>.");
	define("E_VAL_FLOAT_CHECK_FAILED","Please provide numeric input (0-9 .) for <strong>%s</strong>.");
	define("E_VAL_ALPHA_CHECK_FAILED","Please provide alphabetic input for <strong>%s</strong>.");
	define("E_VAL_FILEEXT_CHECK_FAILED","Please provide valid input for <strong>%s</strong>.");
	define("E_VAL_XLSFILE_CHECK_FAILED","Please provide valid input for <strong>%s</strong>.");
	define("E_VAL_FILESIZE_CHECK_FAILED","Please provide valid size for <strong>%s</strong>.");
	define("E_VAL_FILESIZE_POST_CHECK_FAILED","Size of your uploaded files are too large. Please upload files less of size 64mb!");
	define("E_VAL_FILEFIELDS_CHECK_FAILED","The number of records in the file exceeds the limit of 1,000 records. Please upload a file with fewer records.");
	define("E_VAL_NOT_VALID_FILE_TYPE","Please select valid file type for <strong>%s.</strong>");
	define("E_VAL_FILEBLANK_CHECK_FAILED","Fields are not proper. For instructions, please download sample file.");
	define("E_VAL_FILEBLANKV_CHECK_FAILED","Please check blank rows in your file.");
	define("E_VAL_ALPHA_S_CHECK_FAILED","Please provide alphabetic input for <strong>%s</strong>.");
	define("E_VAL_IPADDRESS_S_CHECK_FAILED","Please provide valid <strong>%s</strong>.");
	define("E_VAL_EMAIL_CHECK_FAILED","Please provide a valid e-mail address.");
	define("E_VAL_LESSTHAN_CHECK_FAILED","Enter a value less than <strong>%f</strong> for <strong>%s</strong>.");
	define("E_VAL_GREATERTHAN_CHECK_FAILED","Enter a value greater than <strong>%f</strong> for <strong>%s</strong>.");
	define("E_VAL_DATEGREATERTHAN_CHECK_FAILED","Enter a date value greater than <strong>%s</strong> <strong>%s</strong>.");
	define("E_VAL_DATEGREATERTHAN_CHECK_FAILED_MSG","Enter a date value greater than <strong>%s</strong>.");
	define("E_VAL_DATESMALLERTHAN_CHECK_FAILED","Enter a date value smaller than <strong>%s</strong> <strong>%s</strong>.");
	define("E_VAL_REGEXP_CHECK_FAILED","Please provide a valid input for <strong>%s</strong>.");
	define("E_VAL_DONTSEL_CHECK_FAILED","Wrong option selected for <strong>%s</strong>.");
	define("E_VAL_SHOULD_SEL_CHECK_FAILED","Please select minimum <strong>%d</strong> options for <strong>%s</strong>.");
	define("E_VAL_SELMIN_CHECK_FAILED","Please select minimum <strong>%d</strong> options for <strong>%s</strong>.");
	define("E_VAL_SELONE_CHECK_FAILED","Please select an option for <strong>%s</strong>.");
	define("E_VAL_JUDGE_ROUND_FAILED","There is already a judging round taking place on <strong>%s</strong>.");
	define("E_VAL_JUDGE_ROUND_BETWEEN_FAILED","You have already set round between <strong>%s</strong>.");
	define("E_VAL_SELONE_ARRAY_CHECK_FAILED","Please select at least one <strong>%s</strong>.");
	define("E_VAL_EQELMNT_CHECK_FAILED","Value of <strong>%s</strong> should be same as <strong>%s</strong>.");
	define("E_VAL_NEELMNT_CHECK_FAILED","Value of <strong>%s</strong> should not be same as that of <strong>%s</strong>.");
	define("E_VAL_BLOCK_SELF","You cannot block yourself. Please provide valid %s.");
	define("E_VAL_DATE_CHECK_FAILED","Please enter valid <strong>%s</strong>.");
	define("E_VAL_DUPLICATE_CHECK_FAILED","<strong>%s</strong> is already in use.");
	define("E_VAL_BIRTH_DATE_CHECK_FAILED","Please enter birth date not of future.");
	define("E_VAL_FILE_EXTENSION_CHECK_FAILED","Please select only <strong>%s</strong> file for <strong>%s</strong>.");
	define("E_VAL_NOT_FILE_EXTENSION_CHECK_FAILED","Please do not select <strong>%s</strong> file for <strong>%s</strong>.");
	define("E_VAL_FILE_SELECTION_CHECK_FAILED","Please select file to upload for <strong>%s</strong>.");
	define("E_VAL_COMPANR_GREATERTHAN_CHECK_FAILED","Value of <strong>%s</strong> must be less than <strong>%s</strong>.");
	define("E_VAL_DATE_CHECK_FAILED_DD_MM_YYYY","Please enter valid <strong>%s</strong>.");
	define("E_VAL_MAX_FILE_SIZE_FAILED","Maximum file size exceeded for <strong>%s</strong>.");
	define("E_VAL_NEW_EXISTING_PASSWORD","New password should not be same as the existing password.");
	
class validation
{
	var $arrvalidations = array();
	var $arrmessages = array();
	var $formvariables =array();
	var $cnt = 0;
	
	function addValidation($field, $field_title, $validation, $message = "", $args = "")
	{
		$this->arrvalidations[$this->cnt]["field"] = $field;
		$this->arrvalidations[$this->cnt]["field_title"] = $field_title;
		$this->arrvalidations[$this->cnt]["validation"] = $validation;
		$this->arrvalidations[$this->cnt]["message"] = $message;
		$this->arrvalidations[$this->cnt]["args"] = $args;
		$this->cnt++;
	}
	function validate()
	{
		$msgcmn = new common();
	
		$return = true;
		$this->formvariables = $_REQUEST;
		foreach($_FILES as $name => $value)
		{
			$this->formvariables[$name] = $name;
		}
		$_SESSION["err_fields"] = "";
		for ($i=0;$i<count($this->arrvalidations);$i++)
		{
			if (!$this->validateCommand($this->arrvalidations[$i]["validation"], $this->readValue($this->formvariables[$this->arrvalidations[$i]["field"]],$this->arrvalidations[$i]["field"],$this->arrvalidations[$i]["validation"]), $this->arrvalidations[$i]["message"], $this->arrvalidations[$i]["args"], $this->arrvalidations[$i]["field_title"]))
			{		
				if (isset($_SESSION["err_fields"]) && trim($_SESSION["err_fields"])!="")
					$_SESSION["err_fields"] .="|";
				$_SESSION["err_fields"] .= $this->arrvalidations[$i]["field"];
				
				$return = false;
			}
		}
		if ($return == false)
		{
			for($i=0;$i<count($this->arrmessages);$i++)
			{
				$this->message .= "<div class='errror-message'>".$this->arrmessages[$i]."</div>";
			}
			$strmain = $msgcmn->getFileContent(SERVER_ROOT."common/templates/validation_msg.html");
			$strmain = str_replace("##imgpath##",SERVER_HOST,$strmain);
			$strmain = str_replace("#strtitle", "Please correct following errors.", $strmain);
			$strmain = str_replace("#strsubtitle", $this->message, $strmain);
			$_SESSION["err"] = $strmain;
			$_SESSION["is_error"]=1;
		}
		return $return;
	}
	
	function validateWithMessage()
	{
		$msgcmn = new common();
		$return = true;
		$this->formvariables = $_REQUEST;
		foreach($_FILES as $name => $value)
		{
			$this->formvariables[$name] = $name;
		}
		$_SESSION["err_fields"] = "";
		for ($i=0;$i<count($this->arrvalidations);$i++)
		{
			if (!$this->validateCommand($this->arrvalidations[$i]["validation"], $this->readValue($this->formvariables[$this->arrvalidations[$i]["field"]],$this->arrvalidations[$i]["field"],$this->arrvalidations[$i]["validation"]), $this->arrvalidations[$i]["message"], $this->arrvalidations[$i]["args"], $this->arrvalidations[$i]["field_title"]))
			{	
				if (isset($_SESSION["err_fields"]) && trim($_SESSION["err_fields"])!="")
					$_SESSION["err_fields"] .="|";
				$_SESSION["err_fields"] .= $this->arrvalidations[$i]["message"];
				
				$return = false;
			}
		}
		if ($return == false)
		{
			for($i=0;$i<count($this->arrmessages);$i++)
			{
				$this->message .= "<div class='errror-message'>".$this->arrmessages[$i]."</div>";
			}
			$strmain = $msgcmn->getFileContent(SERVER_ROOT."common/templates/validation_msg.html");
			$strmain = str_replace("#strtitle", "Please correct following errors.", $strmain);
			$strmain = str_replace("#strsubtitle", $this->message, $strmain);
			$_SESSION["err"] = $strmain;
			$_SESSION["is_error"]=1;
		}
		return $return;
	}

	function validateCommand($command, $input_value, &$default_error_message, $command_value, $field_title)
	{
		$bret=true;
		switch($command)
		{
			case 'req':
						{
							$bret = $this->validateReq($input_value, $default_error_message,$field_title);
							break;
						}
			case 'maxlen':
						{
							$max_len = intval($command_value);
							$bret = $this->validateMaxLen($input_value,$max_len,$field_title,
												$default_error_message);
							break;
						}
			case 'minlen':
						{
							$min_len = intval($command_value);
							$bret = $this->validateMinLen($input_value,$min_len,$field_title,
											$default_error_message);
							break;
						}
			case 'alnum':
						{
							$bret= $this->testDataType($input_value,"[^A-Za-z0-9]");
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_ALNUM_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
			case 'alnum_s':
						{
							$bret= $this->testDataType($input_value,"[^A-Za-z0-9 ]");
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_ALNUM_S_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}

			case 'num':
            case 'numeric':
						{
							$bret= $this->testDataType($input_value,"[^0-9]");
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_NUM_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;							
						}
					
			case 'float':
						{
							$bret= $this->testDataType($input_value,"[^.0-9]");
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_FLOAT_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;							
						}

			case 'alpha':
						{
							$input_value = str_replace("\'","",$input_value);
							$input_value = str_replace(" ","",$input_value);
							$bret= $this->testDataType($input_value,"[^A-Za-z.-]");
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_ALPHA_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
			
			case 'password':
						{
							$passwordval = $input_value;
							$mainlen = strlen($passwordval);
							$changeval = str_replace("'","",$passwordval);
							$changeval = str_replace('"',"",$changeval);
							$changeval = str_replace("<","",$changeval);
							$changeval = str_replace(">","",$changeval);
							$changedlen = strlen($changeval);
							if($mainlen!=$changedlen)
							{
								$this->arrmessages[] = sprintf(E_VAL_PASSWORD_CHECK_FAILED,$field_title);
								return false;	
							}
							
							break;
						}
			case 'username':
						{
							$bret= $this->testDataType($input_value,"[^A-Za-z0-9_\-\.]");
							
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_USERNAME_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
			case 'fileext':
						{
							$bret = preg_match("/^\.[a-zA-Z]/",$input_value);
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_FILEEXT_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
			case 'xlsfile':
						{	
							$input_value = $_FILES[$input_value]['name'];
							$bret = preg_match("/.xls$/",$input_value);
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_XLSFILE_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
			case 'filesize':
						{	
							$input_value = $_FILES[$input_value]['size'];
							$bretv = ($input_value * .0009765625) * .0009765625; 
							
							if($bretv>1)
							{	$bret=false;
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_FILESIZE_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
								
							}
							break;
						}
			case 'filesizebeforepost':
						{	
								$bret=false;
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_FILESIZE_POST_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
									
								break;
						}
			case 'fileblank':
						{
							$bret=false;
							if (trim($default_error_message)=="")
								$this->arrmessages[] = sprintf(E_VAL_FILEBLANK_CHECK_FAILED,$field_title);
							else
								$this->arrmessages[] = sprintf($default_error_message, $field_title);
						
							break;
						}
			case 'fileblankv':
						{
							$bret=false;
							if (trim($default_error_message)=="")
								$this->arrmessages[] = sprintf(E_VAL_FILEBLANKV_CHECK_FAILED,$field_title);
							else
								$this->arrmessages[] = sprintf($default_error_message, $field_title);
						
							break;
						}
			case 'notValidFileType':
						{
							$bret=false;
							if (trim($default_error_message)=="")
								$this->arrmessages[] = sprintf(E_VAL_NOT_VALID_FILE_TYPE,$field_title);
							else
								$this->arrmessages[] = sprintf($default_error_message, $field_title);
						
							break;
						}				
			case 'fields':
						{	
							$bret=false;
							if (trim($default_error_message)=="")
								$this->arrmessages[] = sprintf(E_VAL_FILEFIELDS_CHECK_FAILED,$field_title);
							else
								$this->arrmessages[] = sprintf($default_error_message, $field_title);
							break;
						}
			case 'alpha_s':
						{
							$bret= $this->testDataType($input_value,"[^A-Za-z ]");
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_ALPHA_S_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
			case 'ipaddress':
						{
							$bret = preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/",$input_value);
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_IPADDRESS_S_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							else
							{
								$parts=explode(".",$input_value); 
								foreach($parts as $ip_parts)    
								{	if(intval($ip_parts)>255 || intval($ip_parts)<0)     
									$this->arrmessages[] = sprintf(E_VAL_IPADDRESS_S_CHECK_FAILED,$field_title);
								}    
							}
							break;
						}
			case 'email':
						{
							if(isset($input_value) && strlen($input_value)>0)
							{
								$bret= $this->validateEmail($input_value);
								if(false == $bret)
								{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = E_VAL_EMAIL_CHECK_FAILED;
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
								}
							}
							break;
						}
			case "lt": 
			case "lessthan": 
						{
							$bret = $this->validateLessThan($command_value,
													$input_value,
													$field_title,
													$default_error_message);
							break;
						}
			case "gt": 
			case "greaterthan": 
						{
							$bret = $this->validateGreaterThan($command_value,
													$input_value,
													$field_title,
													$default_error_message);
							break;
						}
			case "comparedate": 
						{	
							$bret = $this->validateDateCompare($command_value,
													$input_value,
													$field_title,
													$default_error_message);
								
							break;
						}
			case "comparedatev": 
						{	
							$bret = $this->validateDateCompareV($command_value,
													$input_value,
													$field_title,
													$default_error_message);
								
							break;
						}
			case "comparedatevmsg": 
						{	
							$bret = $this->validateDateCompareVMsg($command_value,
													$input_value,
													$field_title,
													$default_error_message);
								
							break;
						}
			case "comparedatesmall": 
						{	
							$bret = $this->validateDateCompareSmall($command_value,
													$input_value,
													$field_title,
													$default_error_message);
							break;
						}
			case "inarr": 
						{	
							$this->arrmessages[] = sprintf(E_VAL_REGEXP_CHECK_FAILED,$field_title);
							$bret = false;
							break;
						}
			case "blockself": 
						{	
							$this->arrmessages[] = sprintf(E_VAL_BLOCK_SELF,$field_title);
							$bret = false;
							break;
						}			
			case "comp_gt": 
						{
							$bret = $this->validateCompareGreaterThan($command_value,
													$input_value,
													$field_title,
													$default_error_message);
							break;
						}

			case "regexp":
						{
							if(isset($input_value) && strlen($input_value)>0)
							{
								if(!preg_match("$command_value",$input_value))
								{
									$bret=false;
									if (trim($default_error_message)=="")
										$this->arrmessages[] = sprintf(E_VAL_REGEXP_CHECK_FAILED,$field_title);
									else
										$this->arrmessages[] = sprintf($default_error_message, $field_title);
								}
							}
							break;
						}
		  case "dontselect": 
		  case "dontselectchk":
          case "dontselectradio":
						{
							$bret = $this->validateDontSelect($input_value,
															   $command_value,
															   $default_error_message,
																$field_title);
							 break;
						}//case

          case "shouldselchk":
          case "selectradio":
                      {
                            $bret = $this->validateSelect($input_value,
							       $command_value,
							       $default_error_message,
								    $field_title);
                            break;
                      }//case
		  case "selmin":
						{
							$min_count = intval($command_value);

							if(isset($input_value))
                            {
							    if($min_count > 1)
							    {
							        $bret = (count($input_value) >= $min_count )?true:false;
							    }
                                else
                                {
                                  $bret = true;
                                }
                            }
							else
							{
								$bret= false;
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_SELMIN_CHECK_FAILED,$min_count,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}

							break;
						}//case
		 case "selone":
						{	
							if(false == isset($input_value)||
								strlen($input_value)<=0)
							{
								$bret= false;
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_SELONE_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
		case "seloneMsg":
						{
							$bret= false;
							if (trim($default_error_message)=="")
								$this->arrmessages[] = sprintf(E_VAL_SELONE_CHECK_FAILED,$field_title);
							else
								$this->arrmessages[] = sprintf($default_error_message, $field_title);
							break;
						}
		case "judgeRoundDate":
						{
							$bret= false;
							global $cmn;
							
							$field_title = $cmn->convertFormtTimeToDb($field_title);
							$dateformat = explode(" ",$field_title);
							
							if($dateformat[1] == "00:00:00")
							{
								unset($dateformat[1]);
								$field_title = implode(" ",$dateformat);
							}
							
							if (trim($default_error_message)=="")
								$this->arrmessages[] = sprintf(E_VAL_JUDGE_ROUND_FAILED,$field_title);
							else
								$this->arrmessages[] = sprintf($default_error_message, $field_title);
							break;
						}
		case "judgeRoundDateBet":
						{
							global $cmn;
							$field_title_arr = explode(" & ",$field_title);
							$field_title_arr[0] = $cmn->convertFormtTimeToDb($field_title_arr[0]);
							$dateformat = explode(" ",$field_title_arr[0]);
							if($dateformat[1] == "00:00:00")
							{
								unset($dateformat[1]);
								$field_title_arr[0] = implode(" ",$dateformat);
							}
							
							$field_title_arr[1] = $cmn->convertFormtTimeToDb($field_title_arr[1]);
							$dateformat = explode(" ",$field_title_arr[1]);
							if($dateformat[1] == "00:00:00")
							{
								unset($dateformat[1]);
								$field_title_arr[1] = implode(" ",$dateformat);
							}
							
							$field_title = implode(" & ",$field_title_arr);
							
							$bret= false;
							if (trim($default_error_message)=="")
								$this->arrmessages[] = sprintf(E_VAL_JUDGE_ROUND_BETWEEN_FAILED,$field_title);
							else
								$this->arrmessages[] = sprintf($default_error_message, $field_title);
							break;
						}
		case "reqMsg":
						{
							$bret= false;
								$this->arrmessages[] = sprintf($field_title);
							break;
						}
		 case "chk_single":
						{
							if(false == isset($_REQUEST[$input_value])||
								strlen($_REQUEST[$input_value])<=0)
							{
								$bret= false;
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_SELONE_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
		 case "chk_arr":
						{
							if(false == isset($_REQUEST[$input_value])||
								count($_REQUEST[$input_value])<=0)
							{
								$bret= false;
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_SELONE_ARRAY_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
		 case "selfile":
		 				{	
							if($_FILES[$input_value]["size"]<=0)
							{
								$bret= false;
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_FILE_SELECTION_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						
						}
		 case "eqelmnt":
						{
							$command_field = split("\|", $command_value);
							if (trim($input_value)!="")
							{
								if(isset($this->formvariables[$command_field[0]]) && trim($this->formvariables[$command_field[0]])!="" && 
								   strcmp($input_value,$this->formvariables[$command_field[0]])==0 )
								{
									$bret=true;
								}
								else 
								{
									//check for value against control
									if(strcmp($input_value,$command_field[0])==0)
										$bret= true;
									else
										$bret= false;
									if (trim($default_error_message)=="")
										$this->arrmessages[] = sprintf(E_VAL_EQELMNT_CHECK_FAILED,$field_title,$command_field[1]);
									else
										$this->arrmessages[] = sprintf($default_error_message, $field_title, $command_field[1]);
								}
							}
						break;
						}
		 case "eqelmnt-ci":	// Case insensitive
						{
							$command_field = split("\|", $command_value);
							if (trim($input_value)!="")
							{
								if(isset($this->formvariables[$command_field[0]]) && trim($this->formvariables[$command_field[0]])!="" && 
								   strcmp(strtolower($input_value), strtolower($this->formvariables[$command_field[0]]))==0 )
								{
									$bret=true;
								}
								else 
								{
									//check for value against control
									if(strcmp(strtolower($input_value),strtolower($command_field[0]))==0)
										$bret= true;
									else
										$bret= false;
									if (trim($default_error_message)=="")
										$this->arrmessages[] = sprintf(E_VAL_EQELMNT_CHECK_FAILED,$field_title,$command_field[1]);
									else
										$this->arrmessages[] = sprintf($default_error_message, $field_title, $command_field[1]);
								}
							}
						break;
						}
					
		  case "neelmnt":
						{
							$command_field = split("\|", $command_value);
							if (trim($input_value)!="")
							{
								if(isset($this->formvariables[$command_field[0]]) &&
								   strcmp($input_value,$this->formvariables[$command_field[0]]) !=0 )
								{
									$bret=true;
								}
								else
								{
									$bret= false;
									if (trim($default_error_message)=="")
										$this->arrmessages[] = sprintf(E_VAL_NEELMNT_CHECK_FAILED,$field_title,$command_field[1]);
									else
										$this->arrmessages[] = sprintf($default_error_message, $field_title,$command_field[1]);
								}
							}
							break;
						}
			case "date":
						{
							if(strlen($input_value)>0 && $input_value!="MM/DD/YYYY" ){
								$bret=true;
								$strdate=$input_value;
								if((substr_count($strdate,"/"))<>2){
									$bret= false;
									if (trim($default_error_message)=="")
										$this->arrmessages[] = sprintf(E_VAL_DATE_CHECK_FAILED,$field_title,$command_value);
									else
										$this->arrmessages[] = sprintf($default_error_message, $field_title,$command_value);
									//echo("Enter the date in 'dd/mm/yyyy' format");
								}
								else{
										$pos=strpos($strdate,"/");
										$ardate=explode("-",$strdate);
										//$date=substr($strdate,0,($pos));
										$date = $ardate[1];
										$result=ereg("^[0-9]+$",$date,$trashed);
										if(!($result)){
											$bret= false;
										if (trim($default_error_message)=="")
											$this->arrmessages[] = sprintf(E_VAL_DATE_CHECK_FAILED,$field_title,$command_value);
										else
											$this->arrmessages[] = sprintf($default_error_message, $field_title,$command_value);
											//echo "Enter a Valid Date";
										}
										else{
											if(($date<=0)OR($date>31)){
												$bret= false;
											if (trim($default_error_message)=="")
												$this->arrmessages[] = sprintf(E_VAL_DATE_CHECK_FAILED,$field_title,$command_value);
											else
												$this->arrmessages[] = sprintf($default_error_message, $field_title,$command_value);
												//echo "Enter a Valid Date";
											}
										}
										//$month=substr($strdate,($pos+1),($pos));
										$month = $ardate[0];
										if(($month<=0)OR($month>12)){
											$bret= false;
											if (trim($default_error_message)=="")
												$this->arrmessages[] = sprintf(E_VAL_DATE_CHECK_FAILED,$field_title,$command_value);
											else
												$this->arrmessages[] = sprintf($default_error_message, $field_title,$command_value);
											//echo "Enter a Valid Month";
										}
										else{
											$result=ereg("^[0-9]+$",$month,$trashed);
											if(!($result)){
												$bret= false;
												if (trim($default_error_message)=="")
													$this->arrmessages[] = sprintf(E_VAL_DATE_CHECK_FAILED,$field_title,$command_value);
												else
													$this->arrmessages[] = sprintf($default_error_message, $field_title,$command_value);
												//echo "Enter a Valid Month";
											}
										}
										//$year=substr($strdate,($pos+4),strlen($strdate));
										$year = $ardate[2];
										$result=ereg("^[0-9]+$",$year,$trashed);
										if(!($result)){
											$bret= false;
											if (trim($default_error_message)=="")
												$this->arrmessages[] = sprintf(E_VAL_DATE_CHECK_FAILED,$field_title,$command_value);
											else
												$this->arrmessages[] = sprintf($default_error_message, $field_title,$command_value);
											//echo "Enter a Valid year";
										}
										else{
											if(($year<1900)OR($year>2200)){
												$bret= false;
											if (trim($default_error_message)=="")
												$this->arrmessages[] = sprintf(E_VAL_DATE_CHECK_FAILED,$field_title,$command_value);
											else
												$this->arrmessages[] = sprintf($default_error_message, $field_title,$command_value);
												//echo "Enter a year between 1900-2200";
											}
										}
									}
								}
								break;
							}
					case "birthdate":
							if(strlen($input_value)>0 && $input_value!="MM-DD-YYYY" && (!isset($this->error_hash[$field_title]))){
								$begin = array ('year' => date('Y'), 'month' => date('m'), 'day' => date('d'));
								$ardate=explode("-",$input_value);
								$end = array ('year' => $ardate[2], 'month' => $ardate[1], 'day' => $ardate[0]);
								$ardiff=$this->date_difference($begin, $end);
								if ($ardiff == false){
									$bret= true;
								}
								else {
								   $bret= false;
									if (trim($default_error_message)=="")
									   	$this->arrmessages[] = sprintf(E_VAL_BIRTH_DATE_CHECK_FAILED,$field_title,$command_value);
									else
										$this->arrmessages[] = sprintf($default_error_message, $field_title);
								 }
							}
						    break;
				case "check_date":
					if (isset($input_value) && trim($input_value)!="")
					{
						$arrdt = explode("/",$input_value);
						if (!checkdate($arrdt[0], $arrdt[1], $arrdt[2]))
						{
							$bret= false;
							if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_DATE_CHECK_FAILED_DD_MM_YYYY,$field_title,$command_value);
							else
								$this->arrmessages[] = sprintf($default_error_message, $field_title);
						}
						else
							$bret= true;
					}
					break;
				case "dupli":
							if(isset($input_value) && strlen($input_value)>0){
								global $cmn;
								$ardupli_data = explode("|",$command_value);								
								$strtable = $ardupli_data[0];
								$strfield = $ardupli_data[1];
								$strprimary_field=$ardupli_data[2];
								
								if(count($ardupli_data) > 3)
								{									
									$strprimary_field_value = $ardupli_data[3];
									$strcondition_field = $ardupli_data[4];
									$strcondition_field_value = $cmn->setVal($ardupli_data[5]);
											
									$strquery = "select $strprimary_field from $strtable where $strfield='".$cmn->setVal(trim($input_value))."' and $strprimary_field<>$strprimary_field_value and $strcondition_field='$strcondition_field_value' limit 1";
								}
								else
								{
									$strquery = "select $strprimary_field from $strtable where $strfield='".$cmn->setVal(trim($input_value))."' limit 1";
								}
								
								$rsdupli = mysql_query($strquery) or die(mysql_error());
								$bret= true;
								if($rsdupli && mysql_num_rows($rsdupli)){
									$bret= false;
									if (trim($default_error_message)=="")
										$this->arrmessages[] = sprintf(E_VAL_DUPLICATE_CHECK_FAILED,$field_title);
									else
										$this->arrmessages[] = sprintf($default_error_message, $field_title);
								}			
								mysql_free_result($rsdupli);
								}
								
							break;
							
				case "dupliusername":
							if(isset($input_value) && strlen($input_value)>0){
								global $cmn;
								$ardupli_data = explode("|",$command_value);
								$strtable = $ardupli_data[0];
								$strfield = $ardupli_data[1];
								$strprimary_field=$ardupli_data[2];
								$strprimary_field_value = $ardupli_data[3];
								$strcondition_field = $ardupli_data[4];
								$strcondition_field_value = $cmn->setVal($ardupli_data[5]);
								$strquery = "select $strprimary_field from $strtable where $strfield='".$cmn->setVal(trim($input_value))."' and $strprimary_field<>$strprimary_field_value and $strcondition_field='$strcondition_field_value' limit 1";
								
								$rsdupli = mysql_query($strquery) or die(mysql_error());
								$bret= true;
								if($rsdupli && mysql_num_rows($rsdupli)){
									$bret= false;
									if (trim($default_error_message)=="")
										$this->arrmessages[] = sprintf(E_VAL_DUPLICATE_CHECK_FAILED,$field_title);
									else
										$this->arrmessages[] = sprintf($default_error_message, $field_title);
								}			
								mysql_free_result($rsdupli);
								}
								
							break;
										
				case "ext":
							if(isset($input_value) && strlen($input_value)>0){
								if (isset($_FILES[$input_value]["name"]) && $_FILES[$input_value]["size"]>0) {
									$arr_ext = explode(",",$command_value);
									$file_info = pathinfo($_FILES[$input_value]["name"]);
									if (isset($file_info["extension"]))
									{
										$file_extension = strtolower($file_info["extension"]);
									}
									if (!isset($file_info["extension"]) || !in_array($file_extension,$arr_ext))
									{
										$bret = false;
										if (trim($default_error_message)=="")
											$this->arrmessages[] = sprintf(E_VAL_FILE_EXTENSION_CHECK_FAILED, $command_value, $field_title);
										else
											$this->arrmessages[] = sprintf($default_error_message, $field_title);
									}
								}
							}
							break;
				case "not-ext":
							if(isset($input_value) && strlen($input_value)>0){
								if (isset($_FILES[$input_value]["name"]) && $_FILES[$input_value]["size"]>0) {
									$arr_ext = explode(",",$command_value);
									$file_info = pathinfo($_FILES[$input_value]["name"]);
									if (isset($file_info["extension"]))
									{
										$file_extension = strtolower($file_info["extension"]);
									}
									if (!isset($file_info["extension"]) || in_array($file_extension,$arr_ext))
									{
										$bret = false;
										if (trim($default_error_message)=="")
											$this->arrmessages[] = sprintf(E_VAL_NOT_FILE_EXTENSION_CHECK_FAILED, $command_value, $field_title);
										else
											$this->arrmessages[] = sprintf($default_error_message, $field_title);
									}
								}
							}
							break;
				case "file-size":
							if(isset($input_value) && strlen($input_value)>0){
								if (isset($_FILES[$input_value]["name"]) && $_FILES[$input_value]["size"]>$command_value) {
										$bret = false;
										if (trim($default_error_message)=="")
											$this->arrmessages[] = sprintf(E_VAL_MAX_FILE_SIZE_FAILED, $field_title);
										else
											$this->arrmessages[] = sprintf($default_error_message, $field_title);
								}
							}
							break;
				case "eqelmntPassword":
						{
							$command_field = split("\|", $command_value);
							
							if($input_value==$command_field[2])
							{	$bret = false;
								$this->arrmessages[] = sprintf(E_VAL_NEW_EXISTING_PASSWORD, $field_title);
							}
						}
						break;
		}//switch
		return $bret;
	}
	
	
	function validateReq($input_value, &$default_error_message,$variable_name)
	{
	  $bret = true;
		
      	if(!isset($input_value) ||
			strlen($input_value) <=0 || trim($input_value)=="")
		{	
			$bret=false;
		
			if (trim($default_error_message)=="")
				$this->arrmessages[] = sprintf(E_VAL_REQUIRED_VALUE ,$variable_name);
			else
				$this->arrmessages[] = sprintf($default_error_message,$variable_name);
		}	
	  return $bret;	
	}

	function validateMaxLen($input_value,$max_len,$variable_name,&$default_error_message)
	{
		$bret = true;
		if(isset($input_value) )
		{
			$input_length = strlen($input_value);
			if($input_length > $max_len)
			{
				$bret=false;
				if (trim($default_error_message)=="")
					$this->arrmessages[] = sprintf(E_VAL_MAXLEN_EXCEEDED,$variable_name);
				else
					$this->arrmessages[] = sprintf($default_error_message,$variable_name);
			}
		}
		return $bret;
	}

	function validateMinLen($input_value,$min_len,$variable_name,&$default_error_message)
	{
		$bret = true;
		if(isset($input_value) )
		{
			$input_length = strlen($input_value);
			if($input_length < $min_len)
			{
				$bret=false;
				if (trim($default_error_message)=="")
					$this->arrmessages[] = sprintf(E_VAL_MINLEN_CHECK_FAILED,$min_len,$variable_name);
				else
					$this->arrmessages[] = sprintf($default_error_message,$variable_name);
			}
		}
		return $bret;
	}

	function testDataType($input_value,$reg_exp)
	{
		if(ereg($reg_exp,$input_value))
		{
			return false;
		}
		return true;
	}

	function validateEmail($email) 
	{
		return eregi("^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$", $email);
	}

	function validateForNumericInput($input_value,&$validation_success)
	{
		
		$more_validations=true;
		$validation_success = true;
		if(strlen($input_value)>0)
		{
			
			if(false == is_numeric($input_value))
			{
				$validation_success = false;
				$more_validations=false;
			}
		}
		else
		{
			$more_validations=false;
		}
		return $more_validations;
	}

	function validateLessThan($command_value,$input_value,
                $variable_name,&$default_error_message)
	{
		$bret = true;
		if(false == $this->validateForNumericInput($input_value,
                                    $bret))
		{
			return $bret;
		}
		if($bret)
		{
			$lessthan = doubleval($command_value);
			$float_inputval = doubleval($input_value);
			if($float_inputval >= $lessthan)
			{

				if (trim($default_error_message)=="")
				{
					$this->arrmessages[] = sprintf(E_VAL_LESSTHAN_CHECK_FAILED,
											$lessthan,
											$variable_name);
				}
				else
					$this->arrmessages[] = sprintf($default_error_message,$variable_name);
				$bret = false;
			}//if
		}
		return $bret ;
	}

	function validateGreaterThan($command_value,$input_value,$variable_name,&$default_error_message)
	{
		$bret = true;
		if(false == $this->validateForNumericInput($input_value,$bret))
		{
			return $bret;
		}
		if($bret)
		{
			$greaterthan = doubleval($command_value);
			$float_inputval = doubleval($input_value);
			if($float_inputval <= $greaterthan)
			{
				if (trim($default_error_message)=="")
				{
					$this->arrmessages[] = sprintf(E_VAL_GREATERTHAN_CHECK_FAILED,
											$greaterthan,
											$variable_name);
				}
				else
					$this->arrmessages[] = sprintf($default_error_message,$variable_name);
				
				$bret = false;
			}//if
		}
		return $bret ;
	}
	
	function validateDateCompare($command_value,$input_value,$variable_name,&$default_error_message)
	{
		$bret = true;
		if($bret)
		{	
			$smalldate = @strtotime($command_value);
			$greaterdate = @strtotime($input_value);
			
			if($greaterdate > $smalldate)
			{	
				if (trim($default_error_message)=="")
				{
					$cmn = new common();
					$dt = explode(" ",$input_value);
					
					$command_valuechk = $cmn->dateTimeFormatMonth($cmn->setVal($dt[0]),'%m/%d/%Y');
					
					$this->arrmessages[] = sprintf(E_VAL_DATEGREATERTHAN_CHECK_FAILED,
											$command_valuechk,
											$variable_name);
				}
				else
					$this->arrmessages[] = sprintf($default_error_message,$variable_name);
				
				$bret = false;
			}//if
		}
		return $bret ;
	}
	
	function validateDateCompareV($command_value,$input_value,$variable_name,&$default_error_message)
	{
		$bret = true;
		if($bret)
		{	
			$smalldate = @strtotime($command_value);
			$greaterdate = @strtotime($input_value);
			
			if($greaterdate >= $smalldate)
			{	
				if (trim($default_error_message)=="")
				{
					$cmn = new common();
					$dt = explode(" ",$input_value);
					
					$command_valuechk = $cmn->dateTimeFormatYearChk($cmn->setVal($dt[0]),'%m/%d/%Y');
					
					$this->arrmessages[] = sprintf(E_VAL_DATEGREATERTHAN_CHECK_FAILED,
											$command_valuechk,
											$variable_name);
				}
				else
					$this->arrmessages[] = sprintf($default_error_message,$variable_name);
				
				$bret = false;
			}//if
		}
		return $bret ;
	}
	
	
	function validateDateCompareVMsg($command_value,$input_value,$variable_name,&$default_error_message)
	{
		$bret = true;
		if($bret)
		{	
			$smalldate = @strtotime($command_value);
			$greaterdate = @strtotime($input_value);
			
			if($greaterdate >= $smalldate)
			{	
				if (trim($default_error_message)=="")
				{
					$cmn = new common();
					$dt = explode(" ",$input_value);
					
					$command_valuechk = $cmn->dateTimeFormatYearChk($cmn->setVal($dt[0]),'%m/%d/%Y');
				
					$this->arrmessages[] = sprintf(E_VAL_DATEGREATERTHAN_CHECK_FAILED_MSG,
											$variable_name);
				}
				else
					$this->arrmessages[] = sprintf($default_error_message,$variable_name);
				
				$bret = false;
			}//if
		}
		return $bret ;
	}
	
	function validateDateCompareSmall($command_value,$input_value,$variable_name,&$default_error_message)
	{
		$bret = true;
		if($bret)
		{	
			
			$greaterdate = @strtotime($command_value);
			$smalldate = @strtotime($input_value);

			if($greaterdate <= $smalldate)
			{
				if (trim($default_error_message)=="")
				{
					$cmn = new common();
					$dt = explode(" ",$command_value);
					
					$command_valuechk = $cmn->dateTimeFormatYearChk($cmn->setVal($dt[0]),'%m/%d/%Y');
					
					$this->arrmessages[] = sprintf(E_VAL_DATESMALLERTHAN_CHECK_FAILED,
											$command_valuechk,
											$variable_name);
				}
				else
					$this->arrmessages[] = sprintf($default_error_message,$variable_name);
				
				$bret = false;
			}//if
		}
		return $bret ;
	}

	function validateCompareGreaterThan($command_value, $input_value, $variable_name, &$default_error_message)
	{
		$bret = true;
		$arr_values = split("\|",$command_value);
		$arr_variable_name = split("\|",$variable_name);

		if ($arr_values[0]>$arr_values[1])
		{
				if (trim($default_error_message)=="")
				{
					$this->arrmessages[] = sprintf(E_VAL_COMPANR_GREATERTHAN_CHECK_FAILED,
											$arr_variable_name[0], $arr_variable_name[1]);
				}
				else
					$this->arrmessages[] = sprintf($default_error_message,$arr_variable_name[0], $arr_variable_name[1]);
				
				$bret = false;
				
				$arr_fields = split(",", $input_value);
				for ($i=0;$i<count($arr_fields);$i++)
				{
					if (isset($_SESSION["err_fields"]) && trim($_SESSION["err_fields"])!="")
						$_SESSION["err_fields"] .="|";
					$_SESSION["err_fields"] .= $arr_fields[$i];
				}

		}
		return $bret ;
	}
    function validateSelect($input_value,$command_value,&$default_error_message,$variable_name)
    {
	    $bret=false;
		if(is_array($input_value))
		{
			foreach($input_value as $value)
			{
				if($value == $command_value)
				{
					$bret=true;
					break;
				}
			}
		}
		else
		{
			if($command_value == $input_value)
			{
				$bret=true;
			}
		}
        if(false == $bret)
        {
					if (trim($default_error_message)=="")
						$this->arrmessages[] = sprintf(E_VAL_SHOULD_SEL_CHECK_FAILED, $command_value,$variable_name);
					else
						$this->arrmessages[] = sprintf($default_error_message,$variable_name);
        }
	    return $bret;
    }

	function validateDontSelect($input_value,$command_value,&$default_error_message,$variable_name)
	{
	   $bret=true;
		if(is_array($input_value))
		{
			foreach($input_value as $value)
			{
				if($value == $command_value)
				{
					$bret=false;
				if (trim($default_error_message)=="")
					$this->arrmessages[] = sprintf(E_VAL_DONTSEL_CHECK_FAILED,$variable_name);
				else
					$this->arrmessages[] = sprintf($default_error_message,$variable_name);
					break;
				}
			}
		}
		else
		{
			if($command_value == $input_value)
			{
				$bret=false;
				$this->arrmessages[] = sprintf(E_VAL_DONTSEL_CHECK_FAILED,$variable_name);
			}
		}
	  return $bret;
	}

	function readValue(&$input_value, $default_value, $validation_command)
	{
		if ($validation_command == "chk_single")
			return $default_value;
		else if ($validation_command == "chk_arr")
			return $default_value;
		else
		{
			if (isset($input_value))
				return $input_value;
			else
				return $default_value;
		}
	}

}
?>