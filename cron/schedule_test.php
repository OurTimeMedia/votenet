<?php
define("SERVER_ROOT","/var/www/html/");
define("DB_PREFIX","ei_");
define("MAIN_DB_NAME","`election_impact_production`");

$db_host="eimdb.sterling.local";
$db_name="election_impact_production_reports";
$db_user="eiadmin";
$db_password="V0t3n3tdbadmin";
$sestime=1000;
$link = mysql_connect($db_host, $db_user, $db_password);
mysql_select_db($db_name);

$sql ="INSERT INTO tbl_ip_test (server_add) VALUES ('".$_SERVER['SERVER_ADDR']."');";
mysql_query($sql);
?>
