<?php
class strongmail extends common
{
	//config variables
	var $username;
	var $password;
	var $context;
	var $action;
	var $mailing_file;
	var $file_prefix;
	var $config_id;
	var $message_id;
	var $subject;
	var $from_name;
	var $from_email;
	var $reply_email;
	var $bounce_email;
	var $recipient_parameter;
	var $parameter_separator;
	var $rowid_column;
	var $log_success;
	var $log_fail;
	var $InputHeaderCharset;
	var $OutputHeaderCharset;
	var $config_message_format;
	
	//database variables
	var $database_id;
	var $database_format;
	var $database_file;
	
	//message variables
	var $message_type;
	var $message_format;
	var $content_type;
	var $message_inputcharset;
	var $message_outputcharset;
	var $message_encoding;	
	var $message_template;
	var $message_body;
	var $message_file;
	
	var $email_send_later;
	var $email_send_date;
	var $email_send_bcc;
	var $email_bcc_address;

	function strongmail()
	{
		//config variables
		$this->username = STRONGMAIL_USERNAME;
		$this->password = STRONGMAIL_PASSWORD;
		$this->context = "mailing";
		$this->action = "save";
		$this->mailing_file = "";
		$this->file_prefix = "ElectionImpact";
		$this->config_id = 0;
		$this->message_id = 0;
		$this->subject = "";
		$this->from_name = "Election Impact - Notification";
		$this->from_email = "";
		$this->reply_email = "";
		$this->bounce_email = "";
		$this->recipient_parameter = "RecipientAddress";
		$this->parameter_separator = "::";
		$this->rowid_column = "RID";
		$this->log_success = 0;
		$this->log_fail = 1;
		$this->InputHeaderCharset = "utf8";
		$this->OutputHeaderCharset = "gb2312";
		$this->config_message_format = "format_column";
		
		//database variables
		$this->database_id = 0;
		$this->database_format = "data";
		$this->database_file = "";
		
		//message variables
		$this->message_type = "html";
		$this->message_format = "data";
		$this->content_type = "text/html";
		$this->message_inputcharset = "utf8";
		$this->message_outputcharset = "gb2312";
		$this->message_encoding = "quoted-printable | base64 | 7bit | 8bit";		
		$this->message_template = "";
		$this->message_body = "";
		$this->message_file = "";
		
		$this->email_send_later = 2;
		$this->email_send_date = date("m/d/Y H:i", strtotime("+10 Minutes",time()));
		//$this->email_send_date = date("m/d/Y H:i");
		$this->email_send_bcc = 2;
		$this->email_bcc_address = "";
	}
	
	function save($iRecordSet, $contest_id = "")
	{
		$this->mailing_file = $this->file_prefix . $this->config_id . '.cfg';
	
		$sFullBlock = '<strongmail-client username="'.$this->username.'" password="'.$this->password.'" context="'.$this->context.'" action="'.$this->action.'">
   							<mailing file="'.$this->mailing_file.'">'.
								$this->getConfigBlock().$this->getDatabaseBlock($iRecordSet).$this->getMessageBlock($contest_id)
							.'</mailing>
						</strongmail-client>';
		
		return $sFullBlock;
	}
	
	
	function saveCommon($iRecordSet, $contest_id = "")
	{
		$this->mailing_file = $this->file_prefix . $this->config_id . '.cfg';
	
		$sFullBlock = '<strongmail-client username="'.$this->username.'" password="'.$this->password.'" context="'.$this->context.'" action="'.$this->action.'">
   							<mailing file="'.$this->mailing_file.'">'.
								$this->getConfigBlock().$this->getDatabaseBlock($iRecordSet).$this->getMessageBlockCommon($contest_id)
							.'</mailing>
						</strongmail-client>';
		
		return $sFullBlock;
	}
	
	
	function schedule()
	{
		$sScheduleBlock = '<strongmail-client username="'.$this->username.'" password="'.$this->password.'" context="'.$this->context.'" action="'.$this->action.'">
								<mailing file="'.$this->mailing_file.'">
									<datetime>'.date("m/d/y H:i",strtotime($this->email_send_date)).'</datetime>
								</mailing>
							</strongmail-client>';
		
		return $sScheduleBlock;
	}
	
	function unschedule()
	{
		$sUnScheduleBlock = '<strongmail-client username="'.$this->username.'" password="'.$this->password.'" context="'.$this->context.'" action="'.$this->action.'">
								<mailing file="'.$this->mailing_file.'">
									<datetime>'.date("m/d/y H:i",strtotime($this->email_send_date)).'</datetime>
								</mailing>
							</strongmail-client>';
		
		return $sUnScheduleBlock;
	}
	
	function delete()
	{
		$sConfigBlock = '<strongmail-client username="'.$this->username.'" password="'.$this->password.'" context="'.$this->context.'" action="'.$this->action.'">
<mailing file="'.$this->mailing_file.'"></mailing>
</strongmail-client>';
				
		return $sConfigBlock; 
	}
	
	function getConfigBlock()
	{
		$sConfigBlock = '<config>
						<id>'.$this->config_id.'</id>
						<message_id>'.$this->message_id.'</message_id>
						<subject>'.$this->subject.'</subject>
						<from_name>'.$this->from_name.'</from_name>
						<from_email>'.$this->from_email.'</from_email>
						<reply_email>'.$this->reply_email.'</reply_email>
						<bounce_email>'.$this->bounce_email.'</bounce_email>
						<recipient_parameter>'.$this->recipient_parameter.'</recipient_parameter>
						<parameter_separator>'.$this->parameter_separator.'</parameter_separator>
						<rowid_column>'.$this->rowid_column.'</rowid_column>
						<header>X-Priority: 3;</header>
						<header>Y-Priority: 88;</header>
						<log_success>'.$this->log_success.'</log_success>
						<log_fail>'.$this->log_fail.'</log_fail>
						<InputHeaderCharset>'.$this->InputHeaderCharset.'</InputHeaderCharset>
						<OutputHeaderCharset>'.$this->OutputHeaderCharset.'</OutputHeaderCharset>
						<message_format>'.$this->config_message_format.'</message_format>
						<BCCAddressField>BCCAddress</BCCAddressField>
					</config>';
					
		return $sConfigBlock;
	}
	
	function getDatabaseBlock($iRecordSet)
	{			
		$this->database_file = $this->file_prefix . $this->database_id . ".db";
		
		$sDatabaseBlock = "";
		$this->recipient_parameter = "";
		//						<header>'.$this->recipient_parameter.'::Name</header>
		$sDatabaseBlock .= '<database id="'.$this->database_id.'" format="'.$this->database_format.'">
						<file>'.$this->database_file.'</file>
						<header>RID::EmailAddress::RecipientAddress::Name::UserName::BCCAddress::FirstName::LastName</header>
						<records>';
		
		$i=1;
		while ($aRow = mysql_fetch_assoc($iRecordSet))
		{	
			$sName = $aRow['user_firstname'] . " " . $aRow['user_lastname'];
		
			$sDatabaseBlock .= $i."::".$aRow['user_email']."::".$aRow['user_email'] . '::' . $sName . '::' . $aRow['user_username'] . '::' . $this->email_bcc_address . '::' . $aRow['user_firstname'] . '::' . $aRow['user_lastname']."\n";
			
			$i++;
		}
		
		$sDatabaseBlock .= '</records>
					</database>';
	
		return $sDatabaseBlock;
	}
	
	function getMessageBlock($contest_id = "")
	{
		$this->message_file = $this->file_prefix . $this->message_id . '.html';

		$sMessageBody = file_get_contents(NOTIFICATION_TEMPLATE . $this->message_template);
		$sMessageBody = str_replace("##message_body##",$this->message_body,$sMessageBody);
		$sMessageBody = str_replace("##antispam_body##",$this->message_body_antispam,$sMessageBody);
		$sMessageBody = str_replace('##image_url##',NOTIFICATION_TEMPLATE_URL,$sMessageBody);
		$sMessageBody = str_replace('\r\n',"<br>",$sMessageBody);
				
		$sMessageBlock = '<message type="'.$this->message_type.'" format="'.$this->message_format.'">
							<content_type>'.$this->content_type.'</content_type>
							<InputCharset>'.$this->message_inputcharset.'</InputCharset>
							<OutputCharset>'.$this->message_outputcharset.'</OutputCharset>
							<encoding> '.$this->message_encoding.' </encoding>
							<file>'.$this->message_file.'</file>
							<body>
								<![CDATA['.$sMessageBody.']]>
							</body>
						</message>';
		
		return $sMessageBlock;
	}
	
	function getMessageBlockCommon($contest_id = "")
	{
		$this->message_file = $this->file_prefix . $this->message_id . '.html';
		
		$sMessageBody = $this->message_body;		
		$sMessageBody = str_replace('\r\n',"<br>",$sMessageBody);
				
		$sMessageBlock = '<message type="'.$this->message_type.'" format="'.$this->message_format.'">
							<content_type>'.$this->content_type.'</content_type>
							<InputCharset>'.$this->message_inputcharset.'</InputCharset>
							<OutputCharset>'.$this->message_outputcharset.'</OutputCharset>
							<encoding> '.$this->message_encoding.' </encoding>
							<file>'.$this->message_file.'</file>
							<body>
								<![CDATA['.$sMessageBody.']]>
							</body>
						</message>';
						
						
		
		return $sMessageBlock;
	}
	
	/**
	 * handles the response of our SOAP call
	 *
	 */
	function saveMailings($sRequest)
	{
		//  Editable parameters
		$SOAPHOST = SOAPHOST;

		$serverpath = SOAP_SERVER_PATH;

		$client = new nu_soapclient($serverpath);
		
		$client->call('execute', array($sRequest) );
		
		$nu_error = '';
		
		$nu_response = '';
		
		// Check for a fault
		if ($client->fault) 
		{			
			$nu_error = 'Error occured while processing your request.';
		} 
		else 
		{
			// Check for errors
			$err = $client->getError();
			if ($err) 
			{
				// Display the error
				$nu_error = $err;
			} 
			else 
			{				
				$nu_response = $client->response;
				
			}
		}
		
		$aNuSoap['error'] = $nu_error;
		$aNuSoap['response'] = $nu_response;
		
		return $aNuSoap;
		
	}
	
	function xml2array($contents, $get_attributes=1, $priority = 'tag') 
	{
		$iStartPoint = strpos(html_entity_decode($contents), '<strongmail-client');
						
		$iEndPoint = strpos(html_entity_decode($contents), '</strongmail-client>');
		
		$contents = '<?xml version="1.0" encoding="ISO-8859-1"?>'.substr(html_entity_decode($contents), $iStartPoint, $iEndPoint);

	
		if(!$contents) return array(); 
	
		if(!function_exists('xml_parser_create'))
		{
			//print "'xml_parser_create()' function not found!"; 
			return array(); 
		} 
	
		//Get the XML parser of PHP - PHP must have this module for the parser to work
		$parser = xml_parser_create(''); 
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss 
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
		xml_parse_into_struct($parser, trim($contents), $xml_values); 
		xml_parser_free($parser); 
	
		if(!$xml_values) return;//Hmm... 
	
		//Initializations 
		$xml_array = array(); 
		$parents = array(); 
		$opened_tags = array(); 
		$arr = array(); 
	
		$current = &$xml_array; //Refference 
	
		//Go through the tags. 
		$repeated_tag_index = array();//Multiple tags with same name will be turned into an array
		foreach($xml_values as $data) 
		{ 
			unset($attributes,$value);//Remove existing values, or there will be trouble
	
			//This command will extract these variables into the foreach scope 
			// tag(string), type(string), level(int), attributes(array). 
			extract($data);//We could use the array by itself, but this cooler. 
	
			$result = array(); 
			$attributes_data = array(); 
			 
			if(isset($value)) 
			{ 
				if($priority == 'tag') $result = $value; 
				else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
			} 
	
			//Set the attributes too. 
			if(isset($attributes) and $get_attributes) 
			{ 
				foreach($attributes as $attr => $val) 
				{ 
					if($priority == 'tag') $attributes_data[$attr] = $val; 
					else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
				} 
			} 
	
			//See tag status and do the needed. 
			if($type == "open") 
			{//The starting of the tag '<tag>' 
				$parent[$level-1] = &$current; 
				if(!is_array($current) or (!in_array($tag, array_keys($current)))) 
				{ //Insert New tag
					$current[$tag] = $result; 
					if($attributes_data) $current[$tag. '_attr'] = $attributes_data; 
					$repeated_tag_index[$tag.'_'.$level] = 1; 
	
					$current = &$current[$tag]; 
	
				} 
				else 
				{ //There was another element with the same tag name 
	
					if(isset($current[$tag][0])) 
					{//If there is a 0th element it is already an array 
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
						$repeated_tag_index[$tag.'_'.$level]++; 
					} 
					else 
					{//This section will make the value an array if multiple tags with the same name appear together
						$current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
						$repeated_tag_index[$tag.'_'.$level] = 2; 
						 
						if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
							$current[$tag]['0_attr'] = $current[$tag.'_attr']; 
							unset($current[$tag.'_attr']); 
						} 
	
					} 
					$last_item_index = $repeated_tag_index[$tag.'_'.$level]-1; 
					$current = &$current[$tag][$last_item_index]; 
				} 
	
			} 
			elseif($type == "complete") 
			{ //Tags that ends in 1 line '<tag />' 
				//See if the key is already taken. 
				if(!isset($current[$tag])) 
				{ //New Key 
					$current[$tag] = $result; 
					$repeated_tag_index[$tag.'_'.$level] = 1; 
					if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;
	
				} 
				else 
				{ //If taken, put all things inside a list(array) 
					if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array... 
	
						// ...push the new element into that array. 
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
						 
						if($priority == 'tag' and $get_attributes and $attributes_data) 
						{
							$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
						} 
						$repeated_tag_index[$tag.'_'.$level]++; 
	
					} 
					else 
					{ //If it is not an array... 
						$current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
						$repeated_tag_index[$tag.'_'.$level] = 1; 
						if($priority == 'tag' and $get_attributes) 
						{ 
							if(isset($current[$tag.'_attr'])) 
							{ //The attribute of the last(0th) tag must be moved as well
								 
								$current[$tag]['0_attr'] = $current[$tag.'_attr']; 
								unset($current[$tag.'_attr']); 
							} 
							 
							if($attributes_data) 
							{ 
								$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
							} 
						} 
						$repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
					} 
				} 
			} 
			elseif($type == 'close') 
			{ //End of tag '</tag>' 
				$current = &$parent[$level-1]; 
			} 
		}
		return($xml_array); 
	}
	
	function chkStrongMailError($contents)
	{
		$sErrorMsg = "";
		
		if (!empty($contents['error']))
		{
			$sErrorMsg = $contents['error'];
		}
		
		$aTemp = $this->xml2array($contents['response']);
		
		if (array_key_exists('error', $aTemp['strongmail-client']['mailing']))
		{
			$sErrorMsg = $aTemp['strongmail-client']['mailing']['error'];
		}
		
		return $sErrorMsg;
	}
	
}
?>