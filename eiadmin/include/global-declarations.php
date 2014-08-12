<?php
	define('PAGE_EXECUTE', true);
	define("DB_PREFIX","ei_");
	define('ADMIN_PANEL_PATH', 'eiadmin/');
	define('ADMIN_PANEL_PAGE_TITLE', 'Election Impact');
	
	define('SITE_NAME', 'Election Impact');
	define('SITE_DESCRIPTION', 'Election Impact');
	define('SITE_KEYWORD', 'Election Impact');
	
	date_default_timezone_set ( "Asia/Colombo" );
	
	define('ADMIN_THEME'			,'themes/black/');

	define('SESSION_ADMIN_PREFIX'	,"EI_ADMIN_SESSION_");
	define('SESSION_CLIENT_PREFIX'	,"EI_CLIENT_SESSION_");
	define('PAGE_STATE'				,SESSION_ADMIN_PREFIX . 'PAGE_STATE');
	define('REDIRECT_PAGE'			,'REDIRECT_PAGE_ADMIN');
	define('CLIENT_REDIRECT_PAGE'	,'REDIRECT_PAGE_CLIENT');
	
	define('ADMIN_USER_ID'			,"admin_userid");
	define('ADMIN_NAME'				,"admin_name");
	define('ADMIN_USER_NAME'		,"admin_username");
	define('ADMIN_USER_ROLE'		,"admin_user_role");
	
	define('CLIENT_USERID'			,"client_userid");
	define('CLIENT_USERNAME'		,"client_username");
	define('CLIENT_USER_TYPE'		,"client_user_type");

	define('PAGESIZE'				,50);
	define('REQUIRED'				,'<span class="red-text">*</span>');
	define('REQUIRED_SENTENCE'		,'<span class="red-text">*</span> = required fields.');
	
	define("SITE_CURRENCY_SYMBOL"	,"$");
	define('NO_OF_DECIMAL_POINT'	,2);
	
	define('DATE_FORMAT'			,'m/d/Y');
	define('DATE_FORMAT_NEWS'		,'jS M, Y');
	define('JQUERY_DATE_FORMAT'		,'mm/dd/yy');
	
	define('MYSQL_DATE_FORMAT'		,'%m-%d-%Y');
	define('MYSQL_WEEKDAY_FORMAT'	,'%W');
	define('MYSQL_FULL_DATE_FORMAT'	,'%a %D %M %Y %h:%i:%s %p');
	
	define('NO_IMAGE_DIR'			,'images/no-images/');
	
	define('NO_IMAGE_AVAILABLE'		, NO_IMAGE_DIR.'no-image.gif');
	define('NO_IMAGE_AVAILABLE1'	, NO_IMAGE_DIR.'no-image-1.png'); //kit image
	define('NO_IMAGE_AVAILABLE2'	, 'images/no-images/no-image-2.png'); //big image
	define('NO_IMAGE_AVAILABLE3'	, 'images/no-images/no-image-3.png'); //product image
	
	define('TESTIMONIAL_UPLOAD_DIR'	, '../files/testimonial/');
	define('TESTIMONIAL_UPLOAD_DIR_FRONT', 'files/testimonial/');
	define('TESTIMONIAL_THUMB_PREFIX', '59x55_');
	
	define('COOKIE_NAME'		, 'siteAuth');
	define('COOKIE_TIME'		, (3600 * 24 * 30));
	
	/* Mail configuration */
	define('TRANSACTIONAL_MAIL_SERVER_PATH',"http://www.electionimpact.com/sm_tmailing.wsdl");
	define('STRONGMAIL_USERNAME', "votenet");
	define('STRONGMAIL_PASSWORD', "V039tnet");