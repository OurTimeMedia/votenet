<?php
require_once 'sdk.class.php';
include("config.inc.php");

$as = new AmazonAS();
$elb = new AmazonELB();
$cw = new AmazonCloudWatch();

$response1 = $as->create_launch_configuration('EIProduction-Load', 'ami-bfd457d6', 'm1.small', array(
    'KeyName' => 'DeerPark',
    'SecurityGroups' => 'web-servers-linux','KernelId'=>'aki-407d9529','InstanceMonitoring'=>'disabled'));
var_dump($response1->isOK());

$response_scaling_group=$as->create_auto_scaling_group('EIProduction-Load-Scaling-GRP','EIProduction-Load',1,7,'us-east-1b',array('DesiredCapacity' => 1, // instances
    'DefaultCooldown' => 30, // seconds
    'HealthCheckGracePeriod' => 30,// seconds
    'LoadBalancerNames'  => 'LB-ElectionImpactProduction',
    'HealthCheckType' => 'ELB'));

var_dump($response_scaling_group->isOK());
      
$response_scaling_policy_up = $as->put_scaling_policy('EIProduction-Load-Scaling-GRP', 'EIProduction-Scaling-Policy-UP', 1, 'ChangeInCapacity', array('Cooldown' => 300));
$temp=$response_scaling_policy_up->body[0]->PutScalingPolicyResult[0]->PolicyARN;
	  
$response= $cw->put_metric_alarm ('EIProduction-Alarm-UP','CPUUtilization','AWS/EC2','Average',300,1,50, 'GreaterThanThreshold',array(
    'AlarmDescription' => 'Action when CPU utilization is more then 50%',
    'AlarmActions' => "$temp"));
var_dump($response->isOK());

$response_scaling_policy_down = $as->put_scaling_policy('EIProduction-Load-Scaling-GRP', 'EIProduction-Scaling-Policy-DOWN', -1, 'ChangeInCapacity', array('Cooldown' => 300));
$temp1=$response_scaling_policy_down->body[0]->PutScalingPolicyResult[0]->PolicyARN;

$response= $cw->put_metric_alarm ('EIProduction-Alarm-DOWN','CPUUtilization','AWS/EC2','Average',600,1,30, 'LessThanThreshold',array(
    'AlarmDescription' => 'Action when CPU utilization is less then 30%',
    'AlarmActions' => "$temp1"
	));
var_dump($response->isOK());
?>