<?php	
	$language_id = 1;
	$language_name = "English";	
	$language_code = "en";	
	
	if ($cmn->getSession(VOTER_LANGUAGE_ID)!="")	
	{
		$language_id = $cmn->getSession(VOTER_LANGUAGE_ID);
	}
	if ($cmn->getSession(VOTER_LANGUAGE_CODE)!="")	
	{
		$language_code = $cmn->getSession(VOTER_LANGUAGE_CODE);			
	}
	$default_language_id = $language_id;
	$default_language_code = $language_code;
	if (isset($_REQUEST["languageopt"]))
	{
		$language_id = trim($_REQUEST["languageopt"]);		
	}	
	$qry = " SELECT l.language_id, l.language_name, l.language_code ";
	$qry .= " FROM " . DB_PREFIX . "language l ";
	$qry .= " WHERE l.language_isactive = 1 and l.language_ispublish = 1 and l.language_id = '" . $language_id . "' ";
	
	$rs = mysql_query($qry)  or die(mysql_error());
	if(mysql_num_rows($rs) > 0)
	{	
		while ($row = mysql_fetch_assoc($rs))
		{			
			$language_id   = $row["language_id"];	
			$language_name = $row["language_name"];				
			$language_code = $row["language_code"];
			$cmn->setSession(VOTER_LANGUAGE_ID, $language_id);
			$cmn->setSession(VOTER_LANGUAGE_CODE, $language_code);	
		}
	}		
	
	$qry = " SELECT lr.language_id, r.resource_name, if(lr.resource_text is NULL or lr.resource_text = '', r.resource_text, lr.resource_text) as resource_text" ;
	$qry .= " FROM " . DB_PREFIX . "resource r left join " . DB_PREFIX . "language_resource lr on r.resource_id = lr.resource_id  and lr.language_id = '" . $language_id . "' ";
	$qry .= " WHERE r.resource_isactive = 1";		
	
	$rs = mysql_query($qry)  or die(mysql_error());	
	define ("LANGUAGE_ID", $language_id);
	define ("LANGUAGE_CODE", $language_code);	
	define ("LANGUAGE_NAME", $language_name);
	
	//echo "<pre>";
	if(mysql_num_rows($rs) > 0)
	{	
		while ($row = mysql_fetch_assoc($rs))
		{	
			// echo $row["resource_name"]. ": &nbsp;&nbsp;" .html_entity_decode(utf8_decode($row["resource_text"]))."<br>";	
			define($row["resource_name"], html_entity_decode($row["resource_text"]));	
		}
	}			
?>