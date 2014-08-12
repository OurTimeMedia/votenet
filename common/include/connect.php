<?php
$db_host="eimdb.sterling.local";
$db_name="election_impact_production";
$db_user="eiadmin";
$db_password="V0t3n3tdbadmin";

$sestime=1000;
$link = mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name);

$sestime=1000;

error_reporting(E_ALL);
?>
