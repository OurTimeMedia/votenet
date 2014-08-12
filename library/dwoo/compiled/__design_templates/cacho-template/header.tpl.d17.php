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
<link href="../design_templates/cacho-template/css/skin.css" rel="stylesheet" type="text/css" />
<link href="../design_templates/cacho-template/css/ei.css" rel="stylesheet" type="text/css" />
<link href="../design_templates/cacho-template/css/thickbox.css" rel="stylesheet" type="text/css" />
<link href="../voter/css/message.css" rel="stylesheet" type="text/css" />
<script src="../design_templates/cacho-template/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="../design_templates/cacho-template/js/jquery.jcarousel.min.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="../design_templates/cacho-template/js/jquery-ui-1.8.4.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="../design_templates/cacho-template/js/jquery.validate.js"></script>
<link href="../design_templates/cacho-template/css/calendar.css" rel="stylesheet" type="text/css" />
<link href="../design_templates/cacho-template/css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="../design_templates/cacho-template/js/jquery.datepick.js"></script>
<script type="text/javascript" language="javascript" src="../design_templates/cacho-template/js/jquery.datepick.ext.js"></script>
<script type="text/javascript" language="javascript" src="../design_templates/cacho-template/js/registration-form.js"></script>
<script type="text/javascript" language="javascript" src="../design_templates/cacho-template/js/thickbox.js"></script>
<script type="text/javascript" language="javascript" src="../design_templates/cacho-template/js/format_phone.js"></script>
<?php if ((isset($this->scope["background_color"]) ? $this->scope["background_color"] : null)) {
?>
<style type="text/css">
body {
background-color: #<?php echo $this->scope["background_color"];?>;
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

<?php if ((isset($this->scope["background_image"]) ? $this->scope["background_image"] : null)) {
?>
<style type="text/css">
body {
background: url(<?php echo $this->scope["background_image"];?>) repeat;
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

<meta name = "viewport" content = "width=device-width">
<meta name = "viewport" content = "user-scalable=no, width=device-width">

<!--//<script>
//  var metas = document.getElementsByTagName('meta');
//  var i;
//  if (navigator.userAgent.match(/iPhone/i)) {
//    for (i=0; i<metas.length; i++) {
//      if (metas[i].name == "viewport") {
//        metas[i].content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
//      }
//    }
//    document.addEventListener("gesturestart", gestureStart, false);
//  }
//  function gestureStart() {
//    for (i=0; i<metas.length; i++) {
//      if (metas[i].name == "viewport") {
//        metas[i].content = "width=device-width, minimum-scale=0.25, maximum-scale=1.6";
//      }
//    }
//    }
//  }
//</script>-->
<link rel="stylesheet" type="text/css" media="screen" href="../design_templates/cacho-template/css/menumain.css">
<link rel="stylesheet" type="text/css" media="screen" href="../design_templates/cacho-template/css/mobile_device.css">
</head>
<body>
<div id="container">
<?php if ((isset($this->scope["Voting_Source"]) ? $this->scope["Voting_Source"] : null) == "Website") {
?>
<div class="top">
<a href="http://www.movimientohispano.org/index.php"><img alt="MOVIMENTO HISPANO" src="../design_templates/cacho-template/images/HeaderLogo6_01.png"></a><a target="_blank" href="http://www.hispanicfederation.org/"><img border="0" alt="Hispanic Federation" src="../design_templates/cacho-template/images/HeaderLogo6_02.png"></a><a target="_blank" href="http://www.lclaa.org"><img alt="LCLAA Logo" src="../design_templates/cacho-template/images/HeaderLogo6_03.png"></a><a target="_blank" href="http://www.lulac.org/"><img alt="LULAC Logo" src="../design_templates/cacho-template/images/HeaderLogo6_04.png"></a><a target="_blank" href="http://www.comcast.com/corporate/about/inthecommunity/inthecommunity.html?SCRedirect=true"><img border="0" alt="Comcast Logo" src="../design_templates/cacho-template/images/HeaderLogo6_05.png"></a>
<?php if ((isset($this->scope["hide_navigation"]) ? $this->scope["hide_navigation"] : null) == "0") {
?>
<div class="top-menu-main">
<?php echo Dwoo_Plugin_include($this, "top-menu.tpl", null, null, null, '_root', null);?>

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