<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<title><?php print SITE_TITLE;?></title>

<link href="<?php echo SERVER_HOST?>common/templates/css/message.css" rel="stylesheet" />

<script type="text/javascript">
	var JsSiteUrl = "<?PHP echo SERVER_CLIENT_HOST; ?>";
</script>

<SCRIPT language="JavaScript">
<!--

function getInternetExplorerVersion()
// Returns the version of Windows Internet Explorer or a -1
// (indicating the use of another browser).
{
   var rv = 0; // Return value assumes failure.
   if (navigator.appName == 'Microsoft Internet Explorer')
   {
      var ua = navigator.userAgent;
      var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
      if (re.exec(ua) != null)
         rv = parseFloat( RegExp.$1 );
   }
   return rv;
}

var ver = getInternetExplorerVersion();
/*if ( ver > 0)
{ 
	if ( ver <= 7.0) 
	{
		document.write('<link href="<?php echo SERVER_CLIENT_HOST?>css/ie7_style.css" rel="stylesheet" type="text/css" />');
		
	} 
	else if ( ver == 8.0 ) 
	{
		document.write('<link href="<?php echo SERVER_CLIENT_HOST?>css/ie8_style.css" rel="stylesheet" type="text/css" />');
		
	}
}
else 
{*/
	document.write('<link href="<?php echo SERVER_CLIENT_HOST?>css/style.css" rel="stylesheet" type="text/css" />');
	if ( ver > 0)
	{ 
		document.write('<link href="<?php echo SERVER_CLIENT_HOST?>css/ie_style.css" rel="stylesheet" type="text/css" />');
	}
	
//}
document.write('<link href="<?php echo SERVER_CLIENT_HOST?>css/acor.css" rel="stylesheet" type="text/css" />');
//-->
</SCRIPT>

<script language="javascript" type="text/javascript" src="<?php echo SERVER_CLIENT_HOST?>js/common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo SERVER_CLIENT_HOST?>js/jquery-1.2.6.pack.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo SERVER_CLIENT_HOST?>js/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo SERVER_CLIENT_HOST?>js/jquery-ui-1.8.4.custom.min.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo SERVER_CLIENT_HOST?>js/ddaccordion.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SERVER_CLIENT_HOST?>css/skins/tango/skin.css" />
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click" or "mouseover
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='<?PHP echo SERVER_CLIENT_HOST ?>images/plus.gif' class='statusicon' />", "<img src='<?PHP echo SERVER_CLIENT_HOST ?>images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>
<?php
	if (!empty($extraCss))
	{
		foreach ($extraCss as $currentCss)
		{
			?>
			<link href="<?php echo SERVER_CLIENT_HOST?>css/<?php echo $currentCss ?>" rel="stylesheet" type="text/css" />
			<?php
		}
	}
	
	if (!empty($extraJs) && in_array('timymce_editor.js',$extraJs)) 
	{
		?>
		<script type="text/javascript" src="<?php echo SERVER_HOST?>/library/tiny_mce/tiny_mce.js"></script>
		<?php	
	}
	
	if (!empty($extraJs)) 
	{
		foreach ($extraJs as $currentJs)
		{
			?>
			<script type="text/javascript" language="javascript" src="<?php echo SERVER_CLIENT_HOST?>js/<?php echo $currentJs ?>"></script>
			<?php
		}
	}
?>
</head>
<body>