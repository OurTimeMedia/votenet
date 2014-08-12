<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Election Impact</title>
<link href="<?php echo SERVER_HOST?>common/templates/css/message.css" rel="stylesheet" />
<script type="text/javascript">
	var JsSiteUrl = "<?PHP echo SERVER_CLIENT_HOST; ?>";
</script>
<link href="<?PHP echo SERVER_CLIENT_HOST; ?>css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?PHP echo SERVER_CLIENT_HOST; ?>css/skins/tango/skin.css" />
<script type="text/javascript" src="<?PHP echo SERVER_CLIENT_HOST; ?>js/jquery.js"></script>
<script type="text/javascript" src="<?PHP echo SERVER_CLIENT_HOST; ?>js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?PHP echo SERVER_CLIENT_HOST; ?>js/jcarousel/jquery.jcarousel.js"></script>
<script type="text/javascript" src="<?PHP echo SERVER_CLIENT_HOST; ?>js/jcarousel/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?PHP echo SERVER_CLIENT_HOST; ?>js/jcarousel/jcmenuscorll.js"></script>
<script type="text/javascript" src="<?PHP echo SERVER_CLIENT_HOST; ?>js/jscolor.js"></script>
<script type="text/javascript" src="<?PHP echo SERVER_CLIENT_HOST; ?>js/jquery-ui-1.8.4.custom.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() 
{
	jQuery.noConflict();
	
    jQuery('#mycarousel3').jcarousel();
});
</script>
<script type="text/javascript" src="<?PHP echo SERVER_CLIENT_HOST; ?>js/thickbox.js"></script>
<link rel="stylesheet" href="<?PHP echo SERVER_CLIENT_HOST; ?>css/thickbox.css" type="text/css" media="screen" />
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
<body  class="login-body">