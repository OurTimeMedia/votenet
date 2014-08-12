<?php
	/** Default error messages*/
	define("E_VAL_REQUIRED_VALUE","Please enter the value for <strong>%s</strong>.");
	define("E_VAL_MAXLEN_EXCEEDED","Maximum length exceeded for <strong>%s</strong>.");
	define("E_VAL_MINLEN_CHECK_FAILED","Please enter input with length more than <strong>%d</strong> for <strong>%s</strong>.");
	define("E_VAL_ALNUM_CHECK_FAILED","Please provide an alpha-numeric input for <strong>%s</strong>.");
	define("E_VAL_ALNUM_S_CHECK_FAILED","Please provide an alpha-numeric input for <strong>%s</strong>.");
	define("E_VAL_NUM_CHECK_FAILED","Please provide numeric input for <strong>%s</strong>.");
	define("E_VAL_FLOAT_CHECK_FAILED","Please provide numeric input (0-9 .) for <strong>%s</strong.>");
	define("E_VAL_ALPHA_CHECK_FAILED","Please provide alphabetic input for <strong>%s</strong>.");
	define("E_VAL_ALPHA_S_CHECK_FAILED","Please provide alphabetic input for <strong>%s</strong>.");
	define("E_VAL_EMAIL_CHECK_FAILED","Please provide a valid e-mail address.");
	define("E_VAL_LESSTHAN_CHECK_FAILED","Enter a value less than <strong>%f</strong> for <strong>%s</strong>.");
	define("E_VAL_GREATERTHAN_CHECK_FAILED","Enter a value greater than <strong>%f</strong> for <strong>%s</strong>.");
	define("E_VAL_REGEXP_CHECK_FAILED","Please provide a valid input for <strong>%s</strong>.");
	define("E_VAL_DONTSEL_CHECK_FAILED","Wrong option selected for <strong>%s</strong>.");
	define("E_VAL_SHOULD_SEL_CHECK_FAILED","Please select minimum <strong>%d</strong> options for <strong>%s</strong>.");
	define("E_VAL_SELMIN_CHECK_FAILED","Please select minimum <strong>%d</strong> options for <strong>%s</strong>.");
	define("E_VAL_SELONE_CHECK_FAILED","Please select an option for <strong>%s</strong>.");
	define("E_VAL_SELONE_ARRAY_CHECK_FAILED","Please select atleast one <strong>%s</strong>.");
	define("E_VAL_EQELMNT_CHECK_FAILED","Value of <strong>%s</strong> should be same as <strong>%s</strong>.");
	define("E_VAL_NEELMNT_CHECK_FAILED","Value of <strong>%s</strong> should not be same as that of <strong>%s</strong>.");
	define("E_VAL_DATE_CHECK_FAILED","Please enter valid date.");
	define("E_VAL_DUPLICATE_CHECK_FAILED","Duplicate <strong>%s</strong> found.");
	define("E_VAL_BIRTH_DATE_CHECK_FAILED","Please enter birth date not of future.");
	define("E_VAL_FILE_EXTENSION_CHECK_FAILED","Please select only <strong>%s</strong> file for <strong>%s</strong>.");
	define("E_VAL_NOT_FILE_EXTENSION_CHECK_FAILED","Please do not select <strong>%s</strong> file for <strong>%s</strong>.");
	define("E_VAL_FILE_SELECTION_CHECK_FAILED","Please select file to upload for <strong>%s</strong>.");
	define("E_VAL_COMPANR_GREATERTHAN_CHECK_FAILED","Value of <strong>%s</strong> must be less than <strong>%s</strong>.");
	define("E_VAL_DATE_CHECK_FAILED_DD_MM_YYYY","Please enter valid <strong>%s</strong>.");
	define("E_VAL_MAX_FILE_SIZE_FAILED","Maximum file size exceeded for <strong>%s</strong>.");
	
class validation
{
	var $arrvalidations = array();
	var $arrmessages = array();
	var $formvariables =array();
	var $cnt = 0;
	
	function add_validation($field, $field_title, $validation, $message = "", $args = "")
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
		$message = "";
		$this->formvariables = $_REQUEST;
		
		foreach($_FILES as $name => $value)
		{
			$this->formvariables[$name] = $name;
		}
		
		$_SESSION["err_fields"] = "";
		
		for ($i=0;$i<count($this->arrvalidations);$i++)
		{
			if (!$this->validate_command($this->arrvalidations[$i]["validation"], $this->read_value($this->formvariables[$this->arrvalidations[$i]["field"]],$this->arrvalidations[$i]["field"],$this->arrvalidations[$i]["validation"]), $this->arrvalidations[$i]["message"], $this->arrvalidations[$i]["args"], $this->arrvalidations[$i]["field_title"]))
			{
				if (isset($_SESSION["err_fields"]) && trim($_SESSION["err_fields"])!="")
					$_SESSION["err_fields"] .="|";
				$_SESSION["err_fields"] .= $this->arrvalidations[$i]["field"];
				$return = false;
			}
		}
		if ($return == false)
		{
			if($GLOBALS["scope"]=="admin")
			{
				for($i=0;$i<count($this->arrmessages);$i++)
				{
					$message .= "<div class='errror-message'>".$this->arrmessages[$i]."</div>";
				}
				if($GLOBALS["scope"]!="admin") {
					$strmain = $msgcmn->get_file_content(ADMIN_PANEL_PATH."templates/validation-msg.html");
					$strmain = str_replace("##image##", ADMIN_PANEL_PATH . ADMIN_THEME . 'images/validation.jpg', $strmain);
				}
				else {
					$strmain = $msgcmn->get_file_content("templates/validation-msg.html");
					$strmain = str_replace("##image##", ADMIN_THEME . 'images/validation.jpg', $strmain);
				}
				$strmain = str_replace("#strtitle", "Please correct following error(s).", $strmain);
				$strmain = str_replace("#strsubtitle", $message, $strmain);
			}
			else
			{
				$strmain = " <div class='error'><div class='msg-validation-title'>Please correct following error(s).</div><ul><li>".implode('</li><li>',$this->arrmessages)."</li></ul></div>";
			}
			$_SESSION["err"] = $strmain;
			$_SESSION["is_error"]=1;
			
			/* if($GLOBALS["scope"]=="admin")
			{
				for($i=0;$i<count($this->arrmessages);$i++)
				{
					$message .= "<div class='errror-message'>".$this->arrmessages[$i]."</div>";
				}
				 if($GLOBALS["scope"]!="admin") {
					$strmain = $msgcmn->get_file_content(ADMIN_PANEL_PATH . "templates/error-msg.html");
					$strmain = str_replace("##image##",  ADMIN_PANEL_PATH . ADMIN_THEME . 'images/cancel.jpg', $strmain);
				}
				else {
					$strmain = $msgcmn->get_file_content("templates/error-msg.html");
					$strmain = str_replace("##image##", ADMIN_THEME . 'images/cancel.jpg', $strmain);
				}
				$strmain = str_replace("#strtitle", "Please correct following errors.", $strmain);
				$strmain = str_replace("#strsubtitle", $message, $strmain);
			}
			else
			{
				$message = " <div class='msg-validation-title'>Please correct following errors.</div><ul><li>".implode('</li><li>',$this->arrmessages)."</li></ul>";
			}
			
			$_SESSION["err"] = $message;
			$_SESSION["is_error"]=1; */
		}
		
		return $return;
	}

	function validate_command($command, $input_value, &$default_error_message, $command_value, $field_title)
	{
		$bret=true;
		switch($command)
		{
			case 'req':
						{
						
							$bret = $this->validate_req($input_value, $default_error_message,$field_title);
							break;
						}

			case 'maxlen':
						{
							$max_len = intval($command_value);
							$bret = $this->validate_maxlen($input_value,$max_len,$field_title,
												$default_error_message);
							break;
						}

			case 'minlen':
						{
							$min_len = intval($command_value);
							$bret = $this->validate_minlen($input_value,$min_len,$field_title,
											$default_error_message);
							break;
						}

			case 'alnum':
						{
							$bret= $this->test_datatype($input_value,"[^A-Za-z0-9]");
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
							$bret= $this->test_datatype($input_value,"[^A-Za-z0-9 ]");
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
							$bret= $this->test_datatype($input_value,"[^0-9]");
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
							$bret= $this->test_datatype($input_value,"[^.0-9]");
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
							$bret= $this->test_datatype($input_value,"[^A-Za-z]");
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_ALPHA_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
			case 'alpha_s':
						{
							$bret= $this->test_datatype($input_value,"[^A-Za-z ]");
							if(false == $bret)
							{
								if (trim($default_error_message)=="")
									$this->arrmessages[] = sprintf(E_VAL_ALPHA_S_CHECK_FAILED,$field_title);
								else
									$this->arrmessages[] = sprintf($default_error_message, $field_title);
							}
							break;
						}
			case 'email':
						{
							if(isset($input_value) && strlen($input_value)>0)
							{
								$bret= $this->validate_email($input_value);
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
							$bret = $this->validate_lessthan($command_value,
													$input_value,
													$field_title,
													$default_error_message);
							break;
						}
			case "gt": 
			case "greaterthan": 
						{
							$bret = $this->validate_greaterthan($command_value,
													$input_value,
													$field_title,
													$default_error_message);
							break;
						}
			case "comp_gt": 
						{
							$bret = $this->validate_compare_greaterthan($command_value,
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
							$bret = $this->validate_dontselect($input_value,
															   $command_value,
															   $default_error_message,
																$field_title);
							 break;
						}//case

          case "shouldselchk":
          case "selectradio":
                      {
                            $bret = $this->validate_select($input_value,
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
									//check for value against control
									if(strcmp($input_value,$command_field[0]) !=0)
										$bret= true;
									else
										$bret= false;
									if ( $bret == false ) {
										if (trim($default_error_message)=="")
											$this->arrmessages[] = sprintf(E_VAL_NEELMNT_CHECK_FAILED,$field_title,$command_field[1]);
										else
											$this->arrmessages[] = sprintf($default_error_message, $field_title,$command_field[1]);
									}
								}
							}
							break;
						}
			case "date":
						{
							if(strlen($input_value)>0 && $input_value!="MM-DD-YYYY" ){
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
								$strprimary_field_value = $ardupli_data[3];
								$strcondition_field = $ardupli_data[4];
								$strcondition_field_value = $cmn->setval($ardupli_data[5]);
								$strquery = "select $strprimary_field from $strtable where $strfield='".$cmn->setval(trim($input_value))."' and $strprimary_field<>$strprimary_field_value and $strcondition_field='$strcondition_field_value' limit 1";
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
				case "recaptcha":
					$bret = true;
					$response = recaptcha_check_answer (CAPTCHA_PRIVATE_KEY,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
	
						if (!$response->is_valid) {
						  $bret = false;
						  $this->arrmessages[] = $response->error;
						}
					break;
		}//switch
		return $bret;
	}
	
	
	function validate_req($input_value, &$default_error_message,$variable_name)
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

	function validate_maxlen($input_value,$max_len,$variable_name,&$default_error_message)
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

	function validate_minlen($input_value,$min_len,$variable_name,&$default_error_message)
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

	function test_datatype($input_value,$reg_exp)
	{
		if(ereg($reg_exp,$input_value))
		{
			return false;
		}
		return true;
	}

	function validate_email($email) 
	{
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}

	function validate_for_numeric_input($input_value,&$validation_success)
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

	function validate_lessthan($command_value,$input_value,
                $variable_name,&$default_error_message)
	{
		$bret = true;
		if(false == $this->validate_for_numeric_input($input_value,
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

	function validate_greaterthan($command_value,$input_value,$variable_name,&$default_error_message)
	{
		$bret = true;
		if(false == $this->validate_for_numeric_input($input_value,$bret))
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

	function validate_compare_greaterthan($command_value, $input_value, $variable_name, &$default_error_message)
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
    function validate_select($input_value,$command_value,&$default_error_message,$variable_name)
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

	function validate_dontselect($input_value,$command_value,&$default_error_message,$variable_name)
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

	function read_value(&$input_value, $default_value, $validation_command)
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