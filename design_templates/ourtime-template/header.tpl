<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/Article">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="Cache-Control" CONTENT="No Store">
{include(file='include/google_share.php')}
{$header_data}
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
{if $background_color}
<style type="text/css">
body {
background-color: #{$background_color};
}
</style>
{/if}
{if $nav_background_color}
<style type="text/css">
.top-menu-main {
background-color: #{$nav_background_color};
}
</style>
{/if}
{if $nav_text_color}
<style type="text/css">
.top-menu li a:hover, .top-menu li a.act-top {
color: #{$nav_text_color};
}
</style>
{/if}
{if $Voting_Source == "Facebook"}
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
{/if}

{if $hide_banner == "1"}
{if $hide_navigation == "1"}
<style type="text/css">

    #container, #slider, #footer {
        width:730px;
        padding: 5px 10px;
    }

#content{
    margin: 0 5px 10px;
}
</style>
{/if}
{/if}

{if $mobile_device}
<meta name = "viewport" content = "width=device-width">
<meta name = "viewport" content = "user-scalable=no, width=device-width">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" media="screen" href="../design_templates/ourtime-template/css/mobile_device.css">
{else}
{if $background_image}
<style type="text/css">
body {
background: url({$background_image}) repeat;
}
</style>
{/if}
{/if}

{if $CURR_LANGUAGE_ID == 3}
<style type="text/css">
#step1 {
background: url("../images/{$BTN_STEP1_REGISTER}") no-repeat scroll left top transparent;
width: 212px;
}
#step1.step-act{
background: url("../images/{$BTN_STEP1_REGISTER}") no-repeat scroll left bottom transparent;
width: 212px;
}

#step2 {
background: url("../images/{$BTN_STEP2_REGISTER}") no-repeat scroll left top transparent;
}
#step2.step-act{
background: url("../images/{$BTN_STEP2_REGISTER}") no-repeat scroll left bottom transparent;
}

#step3 {
background: url("../images/{$BTN_STEP3_REGISTER}") no-repeat scroll left top transparent;
width: 183px;
}

#step3.step-act{
background: url("../images/{$BTN_STEP3_REGISTER}") no-repeat scroll left bottom transparent;
width: 183px;
}
</style>
{/if}

</head>
<body>
<div id="container">
{if $Voting_Source == "Website"}
<div class="top">
{if $hide_banner == "0"}
		{if $banner_image}		
		<a href="index.php" class="ir"><img border="0" src="{$banner_image}"></a>
		{else}
		<div class="conter" style="width:950px; height:170px; padding-bottom: 0px;">&nbsp;</div>
		{/if}
{/if}
{if $hide_navigation == "0"}
<div class="top-menu-main">
<div class="top-menu">
{include(file='include/top_links.php')}  
</div>
</div>
{/if}
{if $hide_banner == "1"}
{if $hide_navigation == "1"}
<div style="height:3px;"></div>
{/if}
{/if}
</div>
{/if}
<div id="content-main">