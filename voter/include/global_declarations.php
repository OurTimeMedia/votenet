<?php
// Define app environment
$env = getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production';

defined('APPLICATION_ENV') || define('APPLICATION_ENV', $env);
// end define app environment


define("DB_PREFIX","ei_");

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

define('SESSION_ADMIN_PREFIX',"EI_ADMIN_SESSION_");
define('SESSION_CLIENT_PREFIX',"EI_CLIENT_SESSION_");

define('USER_TYPE_SUPER_SYSTEM_ADMIN', 1);
define('USER_TYPE_SYSTEM_ADMIN', 2);
define('USER_TYPE_SUPER_CONTEST_ADMIN', 3);
define('USER_TYPE_CONTEST_ADMIN', 4);
define('USER_TYPE_ENTRANT_USER', 5);
define('USER_TYPE_JUDGE_USER', 6);
define('USER_TYPE_VOTER_USER', 7);
define('USER_TYPE_PUBLIC_VOTER_USER', 8);
define('USER_TYPE_PREVIEW_ENTRANT_USER', 9);

define('SYSTEM_CLIENT_ID',"system_voter_user_id");

define('ADMIN_USER_ID',"admin_user_id");
define('ADMIN_USER_USERNAME',"admin_user_username");
define('ADMIN_USER_DISPLAYNAME',"admin_user_displayname");
define('ADMIN_USER_TYPE_ID',"admin_user_type_id");
define('ADMIN_EMAIL',"info@electionimpact.com");

define('CLIENT_USER_ID',"client_user_id");
define('CLIENT_USER_USERNAME',"client_user_username");
define('CLIENT_USER_DISPLAYNAME',"client_user_displayname");

define('VOTER_LANGUAGE_ID',"voter_language_id");
define('VOTER_LANGUAGE_CODE',"voter_language_code");


define('ADD',"add");
define('EDIT',"edit");
define('DELETE',"delete");
define('DEAUTHORIZED',"deauthorized");
define('AUTHORIZED',"authorized");
define('EDITOFFLINE',"edit_offline");


define('PAGESIZE',10);

define('MENU_ICONS',"images/");

define('COMPULSORY_FIELD','<span class="compulsory">*</span>');

define('TEMPLATE_DIR',"templates/");

define('SESSION_VOTER_PREFIX',"EI_VOTER_SESSION_");
$GLOBALS["scope"]="voter";

define('SITE_OFFLINE',1);
define('SITE_ONLINE',2);

$current_module = "";

define('NO_RECORD_FOUND','<fieldset style="padding: 15px;" class="fieldset-background"><p align="center"><strong>No record found.</strong></p></fieldset>');


define('LANGUAGES_IMAGE_WIDTH', 16);
define('LANGUAGES_IMAGE_HEIGHT', 14);

define('SPONSORS_IMAGE_WIDTH', 184);
define('SPONSORS_IMAGE_HEIGHT', 77);

define('JUDGES_IMAGE_WIDTH', 150);
define('JUDGES_IMAGE_HEIGHT', 170);

### DEFINE THE SITE CONSTANTS ###
//define("BASE_DIR", "/2757/SITE");
define("BASE_DIR", "../");
define('DWOO_DIR', BASE_DIR."library/dwoo/");
define('DESIGN_TEMPLATES_DIR', BASE_DIR."design_templates/");
define('VOTER_BASE_DIR', BASE_DIR."voter/");


define("EMAIL_TEMPLATE",BASE_DIR."/common/files/templates/");
define("EMAIL_TEMPLATE_FORGOTPASS",EMAIL_TEMPLATE."customer_notify_email.html");
define("EMAIL_TEMPLATE_COMMON",EMAIL_TEMPLATE."common.html");

define('ENTRY_ENTRANT_ADMIN','NEW_ENTRY_SUBMISSION_VOTER');
define('ENTRY_CONTEST_ADMIN','NEW_ENTRY_SUBMISSION_CLIENT');

define('COMMON_INCLUDE_DIR', BASE_DIR."common/include/");
define('COMMON_CLASS_DIR', BASE_DIR."common/class/");

define('LANGUAGES_DIR', BASE_DIR."common/files/languages/");
define('SPONSORS_DIR', BASE_DIR."common/files/sponsors/");
define('SPONSORS_DIR_LOC', BASE_DIR."common/files/sponsors/");
define('VOTER_PDF_DIR', BASE_DIR."common/files/voter_pdf/");
define('BANNER_DIR', BASE_DIR."common/files/banners/");
define('BACKGROUND_IMAGE_DIR', BASE_DIR."common/files/background/");
define('TOP_NAV_FILE', "top_navigation.tpl");

define('STRONGMAIL_USERNAME', "votenet");
define('STRONGMAIL_PASSWORD', "V039tnet");
define('TRANSACTIONAL_MAIL_SERVER_PATH',"http://www.electionimpact.com/sm_tmailing.wsdl");

define('ENGLISH_LANGUAGE_ID', '1');

define('ENCDECKEY',"electionimpact");
define('MAX_FILE_UPLOADSIZE',"128");

global $extensions;	

$extensions['image'] = array(".jpg", ".jpeg", ".png", ".bmp", ".gif", ".mp3", ".flv", ".wmv", ".doc", ".docx",".pdf");
$extensions['pdf'] = array(".pdf");

define("SYSTEM_EMAIL", "support@votenet.com");
define("CLIENT_EMAIL", "support@votenet.com");
define('CURRENT_DOMAIN',".electionimpact.com");
define("SITE_DOMAIN_NAME", "electionimpact.com");

define('ENTRY_MAIL_TO_VOTER','VOTER_REGISTRATION_TO_VOTER');
define('ENTRY_MAIL_TO_CLIENT_ADMIN','VOTER_REGISTRATION_TO_CLIENT');

define('AMAZON_KEY', "AKIAJHFEXCMKZGEO2DEQ");
define('AMAZON_SECRET_KEY', "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");
define('BUCKET_NAME', "B-ElectionImpact");
define('AMAZON_S3_LINK', "https://s3.amazonaws.com/");
define('BANNER_DIR_S3', AMAZON_S3_LINK.BUCKET_NAME."/ElectionImpactProd/files/banners/");
define('SPONSORS_DIR_S3', AMAZON_S3_LINK.BUCKET_NAME."/ElectionImpactProd/files/sponsors/");
define('BACKGROUND_IMAGE_DIR_S3', AMAZON_S3_LINK.BUCKET_NAME."/ElectionImpactProd/files/background/");
define('BACKGROUND_IMAGE', "common/files/background/");
define('BANNER_IMAGE', "common/files/banner/");
define('SPONSER_IMAGE', "common/files/sponsors/");
?>