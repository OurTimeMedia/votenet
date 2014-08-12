<?php
define("DB_PREFIX","ei_");
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
define('USER_TYPE_ENTRANT_USER', 5);
define('USER_TYPE_JUDGE_USER', 6);
define('USER_TYPE_VOTER_USER', 7);
define('USER_TYPE_PUBLIC_VOTER_USER', 8);

define('SYSTEM_ADMIN_USER_ID',"system_admin_user_id");
define('SYSTEM_ADMIN_USER_USERNAME',"system_admin_user_username");
define('SYSTEM_ADMIN_USER_DISPLAYNAME',"system_admin_user_displayname");
define('SYSTEM_ADMIN_USER_TYPE_ID',"system_admin_user_type_id");
define('SYSTEM_ADMIN_EMAIL',"info@trofee.com");

define('ADMIN_USER_ID',"admin_user_id");
define('ADMIN_USER_USERNAME',"admin_user_username");
define('ADMIN_USER_DISPLAYNAME',"admin_user_displayname");
define('ADMIN_USER_TYPE_ID',"admin_user_type_id");
define('ADMIN_EMAIL',"info@trofee.com");

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

global $aAdminMenuTables;

$aAdminMenuTables = array(
					 'file_type_addedit'=>array('table'=>'file_types', 'field'=>'file_type_id', 'getField'=>'file_type_name'),
					 'file_type_detail'=>array('table'=>'file_types', 'field'=>'file_type_id', 'getField'=>'file_type_name'),
					 'judge_question_addedit'=>array('table'=>'judge_question', 'field'=>'judge_question_id', 'getField'=>'judge_question'),
					 'judge_question_detail'=>array('table'=>'judge_question', 'field'=>'judge_question_id', 'getField'=>'judge_question'),
					 'judge_type_addedit'=>array('table'=>'judge_type', 'field'=>'judge_type_id', 'getField'=>'judge_type_name'),
					 'judge_type_detail'=>array('table'=>'judge_type', 'field'=>'judge_type_id', 'getField'=>'judge_type_name'),
					 'contest_plan_addedit'=>array('table'=>'contest_plan', 'field'=>'contest_plan_id', 'getField'=>'contest_plan_title'),
					 'contest_plan_detail'=>array('table'=>'contest_plan', 'field'=>'contest_plan_id', 'getField'=>'contest_plan_title'),
					 'email_template_addedit'=>array('table'=>'email_templates', 'field'=>'email_templates_id', 'getField'=>'email_templates_name'),
					 'email_templates_detail'=>array('table'=>'email_templates', 'field'=>'email_templates_id', 'getField'=>'email_templates_name'),
					 'language_addedit'=>array('table'=>'language', 'field'=>'language_id', 'getField'=>'language_name'),
					 'language_detail'=>array('table'=>'language', 'field'=>'language_id', 'getField'=>'language_name'),
					 'system_admin_addedit'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'system_admin_detail'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'system_admin_access'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'contest_admin_addedit'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'contest_admin_detail'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'tickets_action'=>array('table'=>'ticket', 'field'=>'ticket_id', 'getField'=>'ticket_no'),
					 'send_notifications_listing'=>array('table'=>'email_notification', 'field'=>'email_notification_id', 'getField'=>'email_title')
					);
					
global $aMenuRecentTables;

$aMenuRecentTables = array(
					 'contest_admin_addedit'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'contest_admin_detail'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'contest_admin_access'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'judge_user_detail'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'judge_user_addedit'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'voter_user_detail'=>array('table'=>'voter', 'field'=>'voter_id', 'getField'=>'voter_username'),
					 'voter_user_addedit'=>array('table'=>'voter', 'field'=>'voter_id', 'getField'=>'voter_username'),
					 'email_template_addedit'=>array('table'=>'email_templates', 'field'=>'email_templates_id', 'getField'=>'email_templates_name'),
					 'email_templates_detail'=>array('table'=>'email_templates', 'field'=>'email_templates_id', 'getField'=>'email_templates_name'),
					 'judge_question_addedit'=>array('table'=>'judge_question', 'field'=>'judge_question_id', 'getField'=>'judge_question'),
					 'judge_question_detail'=>array('table'=>'judge_question', 'field'=>'judge_question_id', 'getField'=>'judge_question'),
					 'voter_group_detail'=>array('table'=>'voter_group', 'field'=>'voter_group_id', 'getField'=>'voter_group_name'),
					 'voter_group_addedit'=>array('table'=>'voter_group', 'field'=>'voter_group_id', 'getField'=>'voter_group_name'),
					 'block_ip_addedit'=>array('table'=>'block_ipaddress', 'field'=>'block_ipaddress_id', 'getField'=>'ipaddress'),
					 'block_ip_detail'=>array('table'=>'block_ipaddress', 'field'=>'block_ipaddress_id', 'getField'=>'ipaddress'),
					 'block_user_addedit'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'block_user_detail'=>array('table'=>'user', 'field'=>'user_id', 'getField'=>'user_username'),
					 'tickets_action'=>array('table'=>'ticket', 'field'=>'ticket_id', 'getField'=>'ticket_no'),
					 'send_notifications_listing'=>array('table'=>'email_notification', 'field'=>'email_notification_id', 'getField'=>'email_title')
					);
					

global $aSystemAdminLookupTables;

$aSystemAdminLookupTables = array(
							array('table'=>'user','field'=>'created_by'),
							array('table'=>'user','field'=>'updated_by')
						);


global $aContestAdminLookupTables;

$aContestAdminLookupTables = array(
							array('table'=>'user','field'=>'created_by'),
							array('table'=>'user','field'=>'updated_by'),
							array('table'=>'contest','field'=>'created_by'),
							array('table'=>'contest','field'=>'updated_by')
						);
						

global $aJudgeAdminLookupTables;

$aJudgeAdminLookupTables = array(
							array('table'=>'user','field'=>'created_by'),
							array('table'=>'user','field'=>'updated_by'),
							array('table'=>'judge_round_user','field'=>'user_id'),
							array('table'=>'vote','field'=>'user_id')
						);

global $aContestPlanLookupTables;

$aContestPlanLookupTables = array(
								array('table'=>'contest','field'=>'contest_plan_id')
							);


global $aJudgeTypeLookupTables;

$aJudgeTypeLookupTables = array(
								array('table'=>'user','field'=>'judge_type_id'),
								);


global $aJudgeQuestionLookupTables;

$aJudgeQuestionLookupTables = array(
								array('table'=>'judge_question_text','field'=>'judge_question_id'),
								array('table'=>'judge_round_question','field'=>'question_id'),
							);

global $aLanguageLookupTables;

$aLanguageLookupTables = array(
							array('table'=>'language_resource','field'=>'language_id'),
						);
						
global $aFileTypeLookupTables;

$aFileTypeLookupTables = array();

global $aContestCancelLookupTables;

$aContestCancelLookupTables = array();

global $aVoterAdminLookupTables;

$aVoterAdminLookupTables = array(
							array('table'=>'vote','field'=>'voter_id')
						  );
						  
global $aVoterGroupAdminLookupTables;

$aVoterGroupAdminLookupTables = array(
							array('table'=>'judge_round_voter_group','field'=>'voter_group_id')
						  );

global $aVoterGroupLookupTables;

$aVoterGroupLookupTables = array(
							array('table'=>'voter','field'=>'voter_group_id'),
							array('table'=>'judge_round_voter_group','field'=>'voter_group_id')
						 );
						 
global $aVoterGroupsLookupTables;

$aVoterGroupsLookupTables = array(
							array('table'=>'judge_round_voter_group','field'=>'voter_group_id')
						 );
						 
global $aBlockIPLookupTables;

$aBlockIPLookupTables = array();

/**
 *	Extensions Used image Upload
*/
global $extensions;	

$extensions['image'] = array(".jpg", ".jpeg", ".png", ".gif");
$extensions['pdf'] = array(".pdf");

//define("SERVER_CLIENT_HOST","http://".$_SERVER['HTTP_HOST']."/1589/site/contest/");
//define("SERVER_CLIENT_ROOT",$_SERVER['DOCUMENT_ROOT']."/1589/site/contest/");

define("SERVER_ADMIN_HOST","http://".$_SERVER['HTTP_HOST']."/1589/site/admin/");
define("SERVER_ADMIN_ROOT",$_SERVER['DOCUMENT_ROOT']."/1589/site/admin/");

define("SERVER_HOST","http://".$_SERVER['HTTP_HOST']."/1589/site/");
//define("SERVER_ROOT",$_SERVER['DOCUMENT_ROOT']."/1589/site/");

$scriptName = explode("/",$_SERVER['SCRIPT_NAME']);
$totCount = count($scriptName);
//define("Site_URL","http://".$_SERVER['HTTP_HOST'].str_replace($scriptName[$totCount-1],"",$_SERVER['REQUEST_URI']));
if(isset($_REQUEST['uId']))
{
	define("Contest_Site_URL",SERVER_CLIENT_HOST.$_REQUEST['uId']."/");
}

define('SUPER_ADMIN_USER_TYPE',1);
/* Mail Template Defined */
define("EMAIL_TEMPLATE",SERVER_ROOT."/common/files/templates/");
define("EMAIL_TEMPLATES",SERVER_ROOT."/common/templates/");
define("EMAIL_TEMPLATE_FORGOTPASS",EMAIL_TEMPLATE."customer_notify_email.html");
define('FORGOTPASS_CONTEST_USER', 'CONTEST_FORGOT_PASSWORD');
define("EMAIL_TEMPLATE_TICKET",EMAIL_TEMPLATES."ticket_notification.html");
define('CONTEST_REGISTRATION',17);
define('CONTEST_REGISTRATION_ML','NEW_CLIENT_REGISTRATION_SYSTEMADMIN');

define("TICKET_MAIL_SUBJECT","Ticket from client");
define("TICKET_MAIL_SUBJECT_ADMIN","Ticket from Admin");
/* Mail Template Defined */

define("VOTER_EXCEL",SERVER_ROOT."common/files/importVoters/");
define("VOTER_EXCEL_PATH",SERVER_HOST."common/files/importVoters/");

define('MENU_ICONS',"".SERVER_CLIENT_HOST."images/");

define('ENCDECKEY',"trofee");

// Reports
define('CLIENT_FIELD_FOR',"1");
define('ADMIN_FIELD_FOR',"2");

define('CLIENT_ENTRANT_USER_REPORT',"1");
define('CLIENT_JUDGE_USER_REPORT',"2");
define('CLIENT_CONTEST_SUMMARY_REPORT',"3");
define('CLIENT_SUBMISSION_COUNT_REPORT',"4");
define('CLIENT_CONTEST_STATS_REPORT',"5");
define('CLIENT_LOOKUP_JUDGEMENT_REPORT',"6");
define('CLIENT_REVENUE_CONTEST_REPORT',"7");

//Strong Mail Credentials
define('STRONGMAIL_USERNAME', "votenet");
define('STRONGMAIL_PASSWORD', "V039tnet");

define('SOAPHOST', "64.58.70.420");
define('SOAP_SERVER_PATH',"http://".SOAPHOST.":9000/SOAP/sm-client");
define('TRANSACTIONAL_MAIL_SERVER_PATH',"http://192.168.10.2:8081/1589/site/sm_tmailing.wsdl");

define("NOTIFICATION_TEMPLATE",SERVER_ROOT."/common/notification_templates/");
define("NOTIFICATION_TEMPLATE_URL",SERVER_HOST."/common/notification_templates/");

define('CLIENT_REGISTRATION_ADMIN','NEW_CLIENT_REGISTRATION_CONTEST');
define('CONTEST_WINNER_ANNOUNCEMENT','CONTEST_WINNER_ANNOUNCEMENT');

define("EMAIL_TEMPLATE_COMMON",EMAIL_TEMPLATE."common.html");
define("TEMPLATE_COMMON","common.html");

define("SYSTEM_EMAIL", "vnt@aipl.com");
define("CLIENT_EMAIL", "vnt@aipl.com");
define("SITE_DOMAIN_NAME", "stagingtrofee.com");

define("CRON_ENTRY_COMPLETION_ADVANCE", "CONTEST_ENTRY_COMPLETION_ADVANCE");
define("CRON_ENTRY_COMPLETION_NOTIFICATION", "CONTEST_ENTRY_COMPLETION_NOTIFICATION");
define("CRON_JUDGE_STAGE_START_NOTIFICATION", "CONTEST_JUDGE_STAGE_START_JUDGE");
define("CRON_JUDGE_STAGE_COMPLETION_NOTIFICATION", "CONTEST_JUDGMENT_COMPLETION_JUDGE");
define("CRON_CONTEST_JUDGMENT_COMPLETION_NOTIFICATION_JUDGE", "CONTEST_JUDGMENT_COMPLETION_NOTIFICATION_JUDGE");
define("CRON_CONTEST_WINNER_DATE_NOTIFICATION", "CONTEST_WINNER_DATE_NOTIFICATION");

define("DEFINED_ACCESSED_USER","ptanner");
//date_default_timezone_set('America/New_York');
?>