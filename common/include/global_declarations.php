<?php

// Define app environment
$env = getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production';

defined('APPLICATION_ENV') || define('APPLICATION_ENV', $env);
// end define app environment



define("DB_PREFIX","ei_");
define("REPORT_DB_PREFIX","election_impact_production_reports.ei_");
define('SITE_TITLE','Election Impact Control Panel');
define('DMYT12',"d/m/Y h:i:s A");
define('DMYT24',"d/m/Y H:i:s");
define('YMDT12',"Y/m/d h:i:s A");
define('YMDT24',"Y/m/d H:i:s");
define('MDYT12',"d/m/Y h:i:s A");
define('MDYT24',"m/d/Y H:i:s");
define('DMYT12_DESH',"d-m-Y h:i:s A");
define('DMYT24_DESH',"d-m-Y H:i:s");
define('YMDT12_DESH',"Y-m-d h:i:s A");
define('YMDT24_DESH',"Y-m-d H:i:s");
define('MDYT12_DESH',"d-m-Y h:i:s A");
define('MDYT24_DESH',"d-m-Y H:i:s");
define('DMY_DESH',"d-m-Y");
define('YMD_DESH',"Y-m-d");
define('MDY_DESH',"m-d-Y");
define('TIME12',"h:i:s A");
define('TIME24',"H:i:s");
define('HM12',"h:i A");
define('HM24',"H:i");
define('DMMMY',"d-M-Y");
define('DMY',"d/m/Y");
define('YMD',"Y/m/d");
define('MDY',"m/d/Y");
define('SESSION_ADMIN_PREFIX',"ELECTION_IMPACT_SESSION_");
define('SESSION_CLIENT_PREFIX',"ELECTION_IMPACT_CLIENT_SESSION_");
define('USER_TYPE_SUPER_SYSTEM_ADMIN', 1);
define('USER_TYPE_SYSTEM_ADMIN', 2);
define('USER_TYPE_SUPER_CLIENT_ADMIN', 3);
define('USER_TYPE_CLIENT_ADMIN', 4);
define('USER_TYPE_VOTER_USER', 5);
define('SYSTEM_ADMIN_USER_ID',"system_admin_user_id");
define('SYSTEM_ADMIN_USER_USERNAME',"system_admin_user_username");
define('SYSTEM_ADMIN_USER_DISPLAYNAME',"system_admin_user_displayname");
define('SYSTEM_ADMIN_USER_TYPE_ID',"system_admin_user_type_id");
define('SYSTEM_ADMIN_EMAIL',"info@electionimpact.com");
define('ADMIN_USER_ID',"admin_user_id");
define('ADMIN_USER_USERNAME',"admin_user_username");
define('ADMIN_USER_DISPLAYNAME',"admin_user_displayname");
define('ADMIN_USER_TYPE_ID',"admin_user_type_id");
define('ADMIN_EMAIL',"info@electionimpact.com");
define('CLIENT_USER_ID',"client_user_id");
define('CLIENT_USER_USERNAME',"client_user_username");
define('CLIENT_USER_DISPLAYNAME',"client_user_displayname");
define('CLIENT_USER_MEMBERSHIP_ID', "client_user_membership_id");
define('ADD',"add");
define('EDIT',"edit");
define('DELETE',"delete");
define('CANCEL',"cancel");
define('DEAUTHORIZED',"deauthorized");
define('AUTHORIZED',"authorized");
define('EDITOFFLINE',"edit_offline");
define('PAGESIZE',10);
define('PAGESIZEAJAX',5);
define('COMPULSORY_FIELD','<span class="compulsory">*</span>');
define('TEMPLATE_DIR',"templates/");
define('ENGLISH_LANGUAGE_ID', '1');
define('CLIENT_LANGUAGE_ID', '1');
$GLOBALS["scope"]="contest";
$current_module = "";

define('NO_RECORD_FOUND','<fieldset style="padding: 15px;" class="fieldset-background"><p align="center"><strong>No record found.</strong></p></fieldset>');
						 

/**
 *	Extensions Used image Upload
*/
global $extensions;	

$extensions['image'] = array(".jpg", ".jpeg", ".png", ".gif");
$extensions['pdf'] = array(".pdf");

define("SERVER_CLIENT_HOST","http://".$_SERVER['HTTP_HOST']."/client/");
define("SERVER_CLIENT_ROOT",$_SERVER['DOCUMENT_ROOT']."/client/");

define("SERVER_ADMIN_HOST","http://".$_SERVER['HTTP_HOST']."/admin/");
define("SERVER_ADMIN_ROOT",$_SERVER['DOCUMENT_ROOT']."/admin/");

define("SERVER_HOST","http://".$_SERVER['HTTP_HOST']."/");
//define("SERVER_ROOT",$_SERVER['DOCUMENT_ROOT']."/");

define("SERVER_VOTER_HOST","http://".$_SERVER['HTTP_HOST']."/voter/");
define("SERVER_VOTER_ROOT",$_SERVER['DOCUMENT_ROOT']."/voter/");

$scriptName = explode("/",$_SERVER['SCRIPT_NAME']);
$totCount = count($scriptName);
//define("Site_URL","http://".$_SERVER['HTTP_HOST'].str_replace($scriptName[$totCount-1],"",$_SERVER['REQUEST_URI']));
define('SUPER_ADMIN_USER_TYPE',1);
/* Mail Template Defined */
define("EMAIL_TEMPLATE",SERVER_ROOT."/common/files/templates/");
define("EMAIL_TEMPLATES",SERVER_ROOT."/common/templates/");
define("EMAIL_TEMPLATE_FORGOTPASS",EMAIL_TEMPLATE."customer_notify_email.html");
/* Mail Template Defined */
define('MENU_ICONS',"".SERVER_CLIENT_HOST."images/");
define('ENCDECKEY',"electionimpact");
// Reports
define('CLIENT_FIELD_FOR',"1");
define('ADMIN_FIELD_FOR',"2");
//Strong Mail Credentials
define('STRONGMAIL_USERNAME', "votenet");
define('STRONGMAIL_PASSWORD', "V039tnet");
define('SOAPHOST', "www.electionimpact.com");
define('SOAP_SERVER_PATH',"http://".SOAPHOST.":9000/SOAP/sm-client");
define('TRANSACTIONAL_MAIL_SERVER_PATH',"http://www.electionimpact.com/sm_tmailing.wsdl");
define("NOTIFICATION_TEMPLATE",SERVER_ROOT."/common/notification_templates/");
define("NOTIFICATION_TEMPLATE_URL",SERVER_HOST."/common/notification_templates/");
define("EMAIL_TEMPLATE_COMMON",EMAIL_TEMPLATE."common.html");
define("TEMPLATE_COMMON","common.html");
define("SYSTEM_EMAIL", "support@votenet.com");
define("SYSTEM_EMAIL_NOREPLY", "noreply@votenet.com");
define("CLIENT_EMAIL", "support@votenet.com");
define("SITE_DOMAIN_NAME", "electionimpact.com");
define("DEFINED_ACCESSED_USER","ptanner");

define("ADMIN_ENTRY_TABLE_DEFAULT_COLUMNS","9");
define("CLIENT_ENTRY_TABLE_DEFAULT_COLUMNS","5");

//date_default_timezone_set('America/New_York');

define('CLIENT_REGISTRATION_ADMIN','NEW_CLIENT_REGISTRATION_CONTEST');

global $aSystemAdminLookupTables;
$aSystemAdminLookupTables = array(
							array('table'=>'user','field'=>'created_by'),
							array('table'=>'user','field'=>'updated_by')
						);
						
global $aPlanLookupTables;
$aPlanLookupTables = array(
								//array('table'=>'user','field'=>'plan_id')
							);	
							
global $aClientAdminLookupTables;
$aClientAdminLookupTables = array(
							array('table'=>'user','field'=>'created_by'),
							array('table'=>'user','field'=>'updated_by')							
						);			

global $aBlockIPLookupTables;
$aBlockIPLookupTables = array();

if(isset($_REQUEST['uId']))
{
	define("CLIENT_SITE_URL",SERVER_CLIENT_HOST.$_REQUEST['uId']."/");
}

define('FORGOTPASS_CLIENT_USER', 'CLIENT_FORGOT_PASSWORD');
define('CLIENT_REGISTRANT_LIST',"1");

define('VOTER_PDF_DIR', SERVER_ROOT."common/files/voter_pdf/");
define('GADGET_DIR', SERVER_HOST."common/files/gadget/");

define('AMAZON_KEY', "AKIAJHFEXCMKZGEO2DEQ");
define('AMAZON_SECRET_KEY', "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");
define('BUCKET_NAME', "B-ElectionImpact");
define('AMAZON_S3_LINK', "https://s3.amazonaws.com/");
define('BACKGROUND_IMAGE', "common/files/background/");
define('BANNER_IMAGE', "common/files/banner/");
define('SPONSER_IMAGE', "common/files/sponsors/");
?>