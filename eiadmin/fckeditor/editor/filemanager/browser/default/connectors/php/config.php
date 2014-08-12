<?php 
session_start();
ob_start();
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: config.php
 * 	Configuration file for the File Manager Connector for PHP.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

global $Config ;

// SECURITY: You must explicitelly enable this "connector". (Set it to "true").
$Config['Enabled'] = true ;

// Path to user files relative to the document root.
//$Config['UserFilesPath'] = '/myweb' ;

/*if($_SERVER['sess_admserverroot']!="")
{
	$Config['UserFilesPath'] = $_SERVER['sess_admserverroot'];
}
else
{
	$Config['UserFilesPath'] = str_replace("editor/editor/filemanager/browser/default/connectors/php/".basename($_SERVER['PHP_SELF']),"",$_SERVER['PHP_SELF']).'';
}
*/

// Path to user files relative to the document root.
//$Config['UserFilesPath'] = '/userfiles/' ;
$Config['UserFilesPath'] = str_replace("prjadmin/fckeditor/editor/filemanager/connectors/php/".basename($_SERVER['PHP_SELF']),"",$_SERVER['PHP_SELF']).'';


// Fill the following value it you prefer to specify the absolute path for the
// user files directory. Usefull if you are using a virtual directory, symbolic
// link or alias. Examples: 'C:\\MySite\\UserFiles\\' or '/root/mysite/UserFiles/'.
// Attention: The above 'UserFilesPath' must point to the same directory.
//$Config['UserFilesAbsolutePath'] = 'http://www.thepartybook.com/tpb/cmsImages/images' ;

$Config['AllowedExtensions']['File']	= array() ;
$Config['DeniedExtensions']['File']		= array('php','php3','php5','phtml','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi') ;

$Config['AllowedExtensions']['images']	= array('jpg','gif','jpeg','png','pdf','PDF','rtf','RTF','doc','DOC','DOCX','docx') ;
$Config['DeniedExtensions']['images']	= array() ;

$Config['AllowedExtensions']['Flash']	= array('swf','fla') ;
$Config['DeniedExtensions']['Flash']	= array() ;

$Config['AllowedExtensions']['Media']	= array('swf','fla','jpg','gif','jpeg','png','avi','mpg','mpeg') ;
$Config['DeniedExtensions']['Media']	= array() ;


?>