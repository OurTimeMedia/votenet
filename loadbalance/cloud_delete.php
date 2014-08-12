<?php
require_once 'sdk.class.php';
include("config.inc.php");

$as = new AmazonAS();
$elb = new AmazonELB();
$cw = new AmazonCloudWatch();

$response = $as->delete_launch_configuration('EIProduction-Load');
var_dump($response->isOK());

$response = $as->delete_policy('EIProduction-Scaling-Policy-UP', array(
    'AutoScalingGroupName' => 'EIProduction-Load-Scaling-GRP',
));
var_dump($response->isOK());

$response = $as->delete_policy('EIProduction-Scaling-Policy-DOWN', array(
    'AutoScalingGroupName' => 'EIProduction-Load-Scaling-GRP',
));
var_dump($response->isOK());

$response = $as->delete_auto_scaling_group('EIProduction-Load-Scaling-GRP');
var_dump($response->isOK());

$response = $cw->delete_alarms('EIProduction-Alarm-UP');
var_dump($response->isOK());

$response = $cw->delete_alarms('EIProduction-Alarm-DOWN');
var_dump($response->isOK());

?>