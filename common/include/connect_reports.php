<?php
$db_host="eimdb.sterling.local";
$db_name="election_impact_production_reports";
$db_user="eiadmin";
$db_password="V0t3n3tdbadmin";

$sestime=1000;
$link_report = mysql_connect($db_host, $db_user, $db_password);
$conne2=mysql_select_db($db_name,$link_report);
error_reporting(E_ALL);
?>
