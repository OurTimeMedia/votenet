<?php
	$strmeta_title		= SITE_NAME;
	$strmeta_description= SITE_DESCRIPTION;
	$strmeta_keyword	= SITE_KEYWORD;
	
	if ( isset($arcms) && count($arcms) ) {
		$strmeta_title		= ($arcms[0]['meta_title'] != '')	? $cmn->getval($arcms[0]['meta_title'])		: SITE_NAME;
		$strmeta_description= ($arcms[0]['meta_desc'] != '')	? $cmn->getval($arcms[0]['meta_desc'])		: SITE_DESCRIPTION;
		$strmeta_keyword	= ($arcms[0]['meta_keywords'] != '')? $cmn->getval($arcms[0]['meta_keywords'])	: SITE_KEYWORD;	
	}
?>
<title><?php echo $strmeta_title; ?></title>
<meta name="description" content="<?php echo $strmeta_description; ?>" />
<meta name="keywords" content="<?php echo $strmeta_keyword; ?>" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo SITE_URL; ?>images/favicon.ico" />