<?php

switch (APPLICATION_ENV) {
    case 'production':
        die ('Add production credentials');
        break;
    case 'staging':
        $dbHost = "staging-vote.cqr7kxw13zis.us-west-1.rds.amazonaws.com";
        $dbName = "staging";
        $dbUsername = "voteuser";
        $dbPassword = "qFS3!lTKkL5j";
        break;
    case 'development':
        $dbHost = "localhost";
        $dbName = "fission_ei_production";
        $dbUsername = "root";
        $dbPassword = "123456";
        date_default_timezone_set('America/Chicago');
        break;
    default:
        die ('Application environment is not defined');
}

$sestime = 1000;
$link = mysql_connect($dbHost, $dbUsername, $dbPassword);
mysql_select_db($dbName);

$sestime = 1000;

error_reporting(E_ALL);
?>
