<?php
/* template head */
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
/* end template head */ ob_start(); /* template body */ ?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/Article">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="Cache-Control" CONTENT="No Store">
<?php echo Dwoo_Plugin_include($this, 'include/google_share.php', null, null, null, '_root', null);?>

<?php echo $this->scope["header_data"];?>

<title>Election Impact</title>
<link href="../design_templates/ourtime-template/css/skin.css" rel="stylesheet" type="text/css" />
<link href="../design_templates/ourtime-template/css/ei.css" rel="stylesheet" type="text/css" />
<link href="../design_templates/ourtime-template/css/thickbox.css" rel="stylesheet" type="text/css" />
<link href="../voter/css/message.css" rel="stylesheet" type="text/css" />

<script src="../design_templates/ourtime-template/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="../design_templates/ourtime-template/js/jquery.jcarousel.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="../design_templates/ourtime-template/js/jquery-ui-1.8.4.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="../design_templates/ourtime-template/js/jquery.validate.js"></script>
<link href="../design_templates/ourtime-template/css/calendar.css" rel="stylesheet" type="text/css" />
<link href="../design_templates/ourtime-template/css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="../design_templates/ourtime-template/js/jquery.datepick.js"></script>
<script type="text/javascript" language="javascript" src="../design_templates/ourtime-template/js/jquery.datepick.ext.js"></script>
<script type="text/javascript" language="javascript" src="../design_templates/ourtime-template/js/registration-form.js"></script>
<script type="text/javascript" language="javascript" src="../design_templates/ourtime-template/js/thickbox.js"></script>
<script type="text/javascript" language="javascript" src="../design_templates/ourtime-template/js/format_phone.js"></script>
<?php if ((isset($this->scope["background_color"]) ? $this->scope["background_color"] : null)) {
?>
<style type="text/css">
body {
background-color: #<?php echo $this->scope["background_color"];?>;
}
</style>
<?php 
}?>

<?php if ((isset($this->scope["nav_background_color"]) ? $this->scope["nav_background_color"] : null)) {
?>
<style type="text/css">
.top-menu-main {
background-color: #<?php echo $this->scope["nav_background_color"];?>;
}
</style>
<?php 
}?>

<?php if ((isset($this->scope["nav_text_color"]) ? $this->scope["nav_text_color"] : null)) {
?>
<style type="text/css">
.top-menu li a:hover, .top-menu li a.act-top {
color: #<?php echo $this->scope["nav_text_color"];?>;
}
</style>
<?php 
}?>

<?php if ((isset($this->scope["Voting_Source"]) ? $this->scope["Voting_Source"] : null) == "Facebook") {
?>
<style type="text/css">
#container {     
	margin: 0;
    width: 810px;
}

#content-main {    
	margin: 0;
    width: 810px;
}

#content {   
    margin: 0;
    width: 810px;
}
</style>
<?php 
}?>


<?php if ((isset($this->scope["hide_banner"]) ? $this->scope["hide_banner"] : null) == "1") {
?>
<?php if ((isset($this->scope["hide_navigation"]) ? $this->scope["hide_navigation"] : null) == "1") {
?>
<style type="text/css">
#container, #content-main, #slider, #footer {
width:820px;
}

#content{
margin: 0 5px 10px;
}
</style>
<?php 
}?>

<?php 
}?>


<?php if ((isset($this->scope["mobile_device"]) ? $this->scope["mobile_device"] : null)) {
?>
<meta name = "viewport" content = "width=device-width">
<meta name = "viewport" content = "user-scalable=no, width=device-width">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" media="screen" href="../design_templates/ourtime-template/css/mobile_device.css">
<?php 
}
else {
?>
<?php if ((isset($this->scope["background_image"]) ? $this->scope["background_image"] : null)) {
?>
<style type="text/css">
body {
background: url(<?php echo $this->scope["background_image"];?>) repeat;
}
</style>
<?php 
}?>

<?php 
}?>


<?php if ((isset($this->scope["CURR_LANGUAGE_ID"]) ? $this->scope["CURR_LANGUAGE_ID"] : null) == 3) {
?>
<style type="text/css">
#step1 {
background: url("../images/<?php echo $this->scope["BTN_STEP1_REGISTER"];?>") no-repeat scroll left top transparent;
width: 212px;
}
#step1.step-act{
background: url("../images/<?php echo $this->scope["BTN_STEP1_REGISTER"];?>") no-repeat scroll left bottom transparent;
width: 212px;
}

#step2 {
background: url("../images/<?php echo $this->scope["BTN_STEP2_REGISTER"];?>") no-repeat scroll left top transparent;
}
#step2.step-act{
background: url("../images/<?php echo $this->scope["BTN_STEP2_REGISTER"];?>") no-repeat scroll left bottom transparent;
}

#step3 {
background: url("../images/<?php echo $this->scope["BTN_STEP3_REGISTER"];?>") no-repeat scroll left top transparent;
width: 183px;
}

#step3.step-act{
background: url("../images/<?php echo $this->scope["BTN_STEP3_REGISTER"];?>") no-repeat scroll left bottom transparent;
width: 183px;
}
</style>
<?php 
}?>


</head>
<body>
<div id="container">
<?php if ((isset($this->scope["Voting_Source"]) ? $this->scope["Voting_Source"] : null) == "Website") {
?>
<div class="top">
<?php if ((isset($this->scope["hide_banner"]) ? $this->scope["hide_banner"] : null) == "0") {
?>
		<?php if ((isset($this->scope["banner_image"]) ? $this->scope["banner_image"] : null)) {
?>		
		<a href="index.php" class="ir"><img border="0" src="<?php echo $this->scope["banner_image"];?>"></a>
		<?php 
}
else {
?>
		<div class="conter" style="width:950px; height:170px; padding-bottom: 0px;">&nbsp;</div>
		<?php 
}?>

<?php 
}?>

<?php if ((isset($this->scope["hide_navigation"]) ? $this->scope["hide_navigation"] : null) == "0") {
?>
<div class="top-menu-main">
<div class="top-menu">
<?php echo Dwoo_Plugin_include($this, 'include/top_links.php', null, null, null, '_root', null);?>  
</div>
</div>
<?php 
}?>

<?php if ((isset($this->scope["hide_banner"]) ? $this->scope["hide_banner"] : null) == "1") {
?>
<?php if ((isset($this->scope["hide_navigation"]) ? $this->scope["hide_navigation"] : null) == "1") {
?>
<div style="height:3px;"></div>
<?php 
}?>

<?php 
}?>

</div>
<?php 
}?>

<div id="content-main"><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>