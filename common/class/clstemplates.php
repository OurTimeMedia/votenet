<?php
class templates
{	
//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="template_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and template_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", template_id desc";
		}
		$strquery="SELECT * FROM ".DB_PREFIX."template WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	function get_site_array($site_array = array())
	{
		$site_array['site_title'] = SITE_TITLE;
		$site_array['image_dir'] = SITE_IMAGE_DIR;
		$site_array['base_dir'] = VOTER_BASE_DIR;
		$site_array['top_nav'] = TOP_NAV_FILE;
		return $site_array;		
	}		
//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_template= mysql_fetch_array($rs))
		{
			$this->template_id = $artf_template["template_id"];
			$this->template_name = $artf_template["template_name"];
			$this->template_folder = $artf_template["template_folder"];
			$this->template_isprivate = $artf_template["template_isprivate"];
			$this->template_header_image = $artf_template["template_header_image"];
			$this->template_thumb_image = $artf_template["template_thumb_image"];
			$this->template_background_color = $artf_template["template_background_color"];
			$this->template_background_image = $artf_template["template_background_image"];
			$this->template_ispublish = $artf_template["template_ispublish"];
			$this->template_isactive = $artf_template["template_isactive"];
			$this->created_by = $artf_template["created_by"];
			$this->created_date = $artf_template["created_date"];
			$this->updated_by = $artf_template["updated_by"];
			$this->updated_date = $artf_template["updated_date"];
		}
	}
	function get_menu_array($menu_array = array())
	{			
		return $menu_array;		
	}	
	
	function get_home_array($home_array = array())
	{
		return $home_array;
	}
	
	function get_ragister_form_language($register_lang_array = array())
	{
		$register_lang_array['reg_step'] = LANG_STEP;
		$register_lang_array['reg_review_and_download'] = LANG_REVIEW_AND_DOWNLOAD;
		$register_lang_array['reg_registration'] = LANG_REGISTERATION;
		$register_lang_array['reg_spread_word_social_network'] = LANG_SPREAD_WORD_SOCIAL_NETWORK;
		$register_lang_array['LANG_HOME_TEXT'] = LANG_HOME_TEXT;
		$register_lang_array['LANG_REGISTER_TO_VOTE_TEXT'] = LANG_REGISTER_TO_VOTE_TEXT;
		$register_lang_array['LANG_LANGUAGE_PREFERENCE_TEXT'] = LANG_LANGUAGE_PREFERENCE_TEXT;
		$register_lang_array['LANG_YOUR_ZIP_STATE_TEXT'] = LANG_YOUR_ZIP_STATE_TEXT;
		$register_lang_array['LANG_YOUR_EMAIL_ADDRESS_TEXT'] = LANG_YOUR_EMAIL_ADDRESS_TEXT;
		$register_lang_array['LANG_STATE_VOTER_REGISTRATION_OFFICE_LOCATION_TEXT'] = LANG_STATE_VOTER_REGISTRATION_OFFICE_LOCATION_TEXT;
		$register_lang_array['LANG_VIEW_KEY_DATES_AND_DEADLINES_TEXT'] = LANG_VIEW_KEY_DATES_AND_DEADLINES_TEXT;
		$register_lang_array['LANG_OR_TEXT'] = LANG_OR_TEXT;
		$register_lang_array['LANG_SELECT_A_STATE_TEXT'] = LANG_SELECT_A_STATE_TEXT;
		$register_lang_array['LANG_COPY_RIGHT_TEXT'] = LANG_COPY_RIGHT_TEXT;
		$register_lang_array['LANG_CONTINUE_TEXT'] = LANG_CONTINUE_TEXT;
		$register_lang_array['LANG_PLEASE_ENTER_ZIP_OR_STATE'] = LANG_PLEASE_ENTER_ZIP_OR_STATE;
		$register_lang_array['LANG_PLEASE_ENTER_VALID_EMAIL_ADDRESS'] = LANG_PLEASE_ENTER_VALID_EMAIL_ADDRESS;
		$register_lang_array['LANG_HELP_US_SPREAD_THE_WORD'] = LANG_HELP_US_SPREAD_THE_WORD;
		$register_lang_array['LANG_ELECTION_DATE_TEXT'] = LANG_ELECTION_DATE_TEXT;
		$register_lang_array['LANG_SELECT_STATE_TEXT'] = LANG_SELECT_STATE_TEXT;
		$register_lang_array['LANG_ELECTION_TYPE_TEXT'] = LANG_ELECTION_TYPE_TEXT;
		$register_lang_array['LANG_STATE_TEXT'] = LANG_STATE_TEXT;
		$register_lang_array['LANG_ELECTION_DATES_TEXT'] = LANG_ELECTION_DATES_TEXT;
		$register_lang_array['LANG_REGISTRATION_DEADLINE_DATE_TEXT'] = LANG_REGISTRATION_DEADLINE_DATE_TEXT;
		$register_lang_array['LANG_RECORD_PER_PAGE'] = LANG_RECORD_PER_PAGE;
		$register_lang_array['LANG_PAGE_TEXT'] = LANG_PAGE_TEXT;
		$register_lang_array['LANG_OF_TEXT'] = LANG_OF_TEXT;
		$register_lang_array['LANG_GOTO_PAGE_TEXT'] = LANG_GOTO_PAGE_TEXT;
		$register_lang_array['LANG_ADDRESS_TEXT'] = LANG_ADDRESS_TEXT;
		$register_lang_array['LANG_ENTER_5DIGIT_ZIPCODE'] = LANG_ENTER_5DIGIT_ZIPCODE;
		$register_lang_array['LANG_WAIT_FOR_GENERATING_VOTER_REGISTRATION_FORM'] = LANG_WAIT_FOR_GENERATING_VOTER_REGISTRATION_FORM;
		$register_lang_array['LANG_SPREAD_WORD_SOCIAL_NETWORK'] = LANG_SPREAD_WORD_SOCIAL_NETWORK;
		$register_lang_array['LANG_ADD_TO_YOUR_CALENDER'] = LANG_ADD_TO_YOUR_CALENDER;
		$register_lang_array['BTN_STEP1_REGISTER'] = BTN_STEP1_REGISTER;
		$register_lang_array['BTN_STEP2_REGISTER'] = BTN_STEP2_REGISTER;
		$register_lang_array['BTN_STEP3_REGISTER'] = BTN_STEP3_REGISTER;
		$register_lang_array['LANG_ADOBE_REQUIRED_TEXT'] = LANG_ADOBE_REQUIRED_TEXT;
		
		$cmn = new common();		
		$language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
		
		$register_lang_array['CURR_LANGUAGE_ID'] = $language_id;
		
		return $register_lang_array;
	}	

	function get_important_dates_array($entry_start_date,$entry_end_date,$judge_start_date,$judge_end_date)
	{
		$important_dates_array = array();

		$cmn = new common();		
		
		$index = -1;
		
		$item['date_title'] = LANG_SUBMISSION_START.":"; 
		$item['date'] = $cmn->dateTimeFormatMonthAMPM($entry_start_date,"%b %d, %Y %h:%i%p")." ".date("T"); //$cmn->dateTimeFormat($entry_start_date); 
		$item['islast'] = 0; 
		$important_dates_array[$index++] = $item;
		
		$item['date_title'] = LANG_SUBMISSION_END.":"; 
		$item['date'] = $cmn->dateTimeFormatMonthAMPM($entry_end_date,"%b %d, %Y %h:%i%p")." ".date("T"); //$cmn->dateTimeFormat($entry_end_date); 
		$item['islast'] = 0; 
		$important_dates_array[$index++] = $item;
		
		$item['date_title'] = LANG_JUDGING_START.":"; 
		$item['date'] = $cmn->dateTimeFormatMonthAMPM($judge_start_date,"%b %d, %Y %h:%i%p")." ".date("T"); //$cmn->dateTimeFormat($judge_start_date); 
		$item['islast'] = 0; 
		$important_dates_array[$index++] = $item;
		
		$item['date_title'] = LANG_JUDGING_END.":"; 
		$item['date'] = $cmn->dateTimeFormatMonthAMPM($judge_end_date,"%b %d, %Y %h:%i%p")." ".date("T"); //$cmn->dateTimeFormat($judge_end_date); 
		$item['islast'] = 1; 
		$important_dates_array[$index++] = $item;		

		return $important_dates_array;		
	}		

	function url_exists($url){
        $hdrs = @get_headers($url); 
        return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false; 
    }
	
	function get_sponsers_array($aSponsorsDetail)
	{
		$sponsers_array = array();
		
		$index = -1;
		
		for($i=0;$i<count($aSponsorsDetail);$i++)
		{
			$sponsors_website = $aSponsorsDetail[$i]['sponsors_website'];
			$sponsors_website = str_replace("http://","",$sponsors_website);
			$sponsors_website = str_replace("https://","",$sponsors_website);
			if($aSponsorsDetail[$i]['sponsors_website']=='')
			{
				$sponsors_website = "#";
			}
			else
			{
				$sponsors_website = "http://".$sponsors_website;
			}
			$item['sponser_name'] = $aSponsorsDetail[$i]['sponsors_name']; 
			
			if($aSponsorsDetail[$i]['sponsors_logo'] != "" && file_exists(SERVER_ROOT.SPONSER_IMAGE.$aSponsorsDetail[$i]["sponsors_logo"]))
			{				
			
		
				list($width, $height, $type, $attr) = getimagesize(SERVER_ROOT.SPONSER_IMAGE.$aSponsorsDetail[$i]["sponsors_logo"]);
				
				$widthprop = $width / 119;
				$heightprop = $height / 79;
				
				if($widthprop >= $heightprop)
					$imageparam = "width='119'";
				else
					$imageparam = "height='79'";
					
				$item['sponser_image'] = '<img src="'.SERVER_HOST.SPONSER_IMAGE.$aSponsorsDetail[$i]["sponsors_logo"].'" title="'.$aSponsorsDetail[$i]["sponsors_name"].'" alt="'.$aSponsorsDetail[$i]["sponsors_name"].'" border="0" '.$imageparam.'>';
			}	
			else
				$item['sponser_image'] = $aSponsorsDetail[$i]['sponsors_name']; 
			
			$item['sponser_link'] = $sponsors_website;
			$item['islast'] = 0;
			
			if(($i+1)==count($aSponsorsDetail))
				$item['islast'] = 1; 
				
			$item['image_dir_path'] = SITE_IMAGE_DIR;
			
			$sponsers_array[$index++] = $item;
		}
		
		return $sponsers_array;		
	}

			
}

?>