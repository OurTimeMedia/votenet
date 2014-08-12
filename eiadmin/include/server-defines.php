<?php
	define('SITE_MODE', 'LIVE'); //LOCAL, STAGGING, LIVE
	

	$LIVE_SERVER_SETTINGS = array (
								'DATABASE_HOST' => 'eimdb.sterling.local'
								, 'DATABASE_USER' => 'eiadmin'
								, 'DATABASE_PASSWORD' => 'V0t3n3tdbadmin'
								, 'DATABASE_NAME' => 'election_marketing'
								, 'MAILER' => 'SMTP' //SIMPLE, SMTP, SENDMAIL
								, 'SMTP_SERVER' => '127.0.0.1' //MAIL SERVER ADDRESS
								, 'SMTP_PORT' => '25' //MAIL SERVER PORT
								, 'SMTP_AUHTENTICAION' => '0' //WHETHER MAIL SERVER REQUIRE AUTHENTICATION?
								, 'SMTP_USER_NAME' => '' //IF AUTHENTICATION IS REQUIRED, SPECIFY ITS USERNAME
								, 'SMTP_USER_PASSWORD' => '' //IF AUTHENTICATION IS REQUIRED, SPECIFY ITS PASSWORD
							);
	
	
	$STAGGING_SERVER_SETTINGS = array (
                                    'DATABASE_HOST' => '76.74.158.144'
                                    , 'DATABASE_USER' => 'A1848'
                                    , 'DATABASE_PASSWORD' => 'eD44g-#x'
                                    , 'DATABASE_NAME' => 'a1848'
                                    , 'MAILER' => 'SMTP' //SIMPLE, SMTP, SENDMAIL
                                    , 'SMTP_SERVER' => '192.168.52.2' //MAIL SERVER ADDRESS
                                    , 'SMTP_PORT' => '25' //MAIL SERVER PORT
                                    , 'SMTP_AUHTENTICAION' => '0' //WHETHER MAIL SERVER REQUIRE AUTHENTICATION?
                                    , 'SMTP_USER_NAME' => '' //IF AUTHENTICATION IS REQUIRED, SPECIFY ITS USERNAME
                                    , 'SMTP_USER_PASSWORD' => '' //IF AUTHENTICATION IS REQUIRED, SPECIFY ITS PASSWORD
                            );
													
	$LOCAL_SERVER_SETTINGS = array (
                                    'DATABASE_HOST' => '192.168.10.2'
                                    , 'DATABASE_USER' => '1843'
                                    , 'DATABASE_PASSWORD' => 'UxsSfrasZctWS79H'
                                    , 'DATABASE_NAME' => '1843'
                                    , 'MAILER' => 'SIMPLE' //SIMPLE, SMTP, SENDMAIL
                                    , 'SMTP_SERVER' => '' //MAIL SERVER ADDRESS
                                    , 'SMTP_PORT' => '25' //MAIL SERVER PORT
                                    , 'SMTP_AUHTENTICAION' => '0' //WHETHER MAIL SERVER REQUIRE AUTHENTICATION?
                                    , 'SMTP_USER_NAME' => '' //IF AUTHENTICATION IS REQUIRED, SPECIFY ITS USERNAME
                                    , 'SMTP_USER_PASSWORD' => '' //IF AUTHENTICATION IS REQUIRED, SPECIFY ITS PASSWORD
                            );
							
	$server_settings_array = array();
	
	switch ( SITE_MODE ) {
			case 'LIVE':
				$server_settings_array = $LIVE_SERVER_SETTINGS;
				break;
			case 'STAGGING':
				$server_settings_array = $STAGGING_SERVER_SETTINGS;
				break;
			case 'LOCAL':
				$server_settings_array = $LOCAL_SERVER_SETTINGS;
				break;
	}

	if (is_array($server_settings_array) && count($server_settings_array)) {
		foreach ($server_settings_array as $constant_name => $constant_value) {
			define($constant_name, $constant_value);
		}
	}
	
	if(0)
	{
		echo '<pre>';
		print_r($_SERVER);
		echo '</pre>';
	}
	
	//define('ADMIN_PANEL_PATH', 'eiadmin/');
	define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/');
	define('SITE_URL_HTTPS', 'http://'.$_SERVER['HTTP_HOST'].'/');
