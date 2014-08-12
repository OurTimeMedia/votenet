<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print SITE_TITLE;?></title>

<script type="text/javascript">
	var JsSiteUrl = "<?PHP echo SERVER_ADMIN_HOST; ?>";
</script>

<link href="<?php echo SERVER_HOST?>common/templates/css/message.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo SERVER_ADMIN_HOST?>css/skins/tango/skin.css" />
<link href="<?php echo SERVER_ADMIN_HOST?>css/style_tro.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo SERVER_ADMIN_HOST?>js/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo SERVER_ADMIN_HOST?>js/jquery-ui-1.8.4.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo SERVER_ADMIN_HOST?>js/jcarousel/jquery.jcarousel.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo SERVER_ADMIN_HOST?>js/jcarousel/jcmenuscorll.js"></script>
<?php

	if (!empty($extraJs) && in_array('timymce_editor.js',$extraJs)) 
	{
		?>
		<script type="text/javascript" src="<?php echo SERVER_HOST?>/library/tiny_mce/tiny_mce.js"></script>
		<?php	
	}

	if (!empty($extraJs) && in_array('prototype.js',$extraJs)) 
	{
		?>
		<script language="javascript" type="text/javascript" src="<?php echo SERVER_ADMIN_HOST?>js/prototype.js"></script>	
		<?php	
		
		unset($extraJs[0]);
	}

?>

<script language="javascript" type="text/javascript" src="<?php echo SERVER_ADMIN_HOST?>js/common.js"></script>



<?php
	if (!empty($extraCss))
	{
		foreach ($extraCss as $currentCss)
		{
			?>
			<link href="<?php echo SERVER_ADMIN_HOST?>css/<?php echo $currentCss ?>" rel="stylesheet" type="text/css" />
			<?php
		}
	}
	if (!empty($extraJs)) 
	{
		foreach ($extraJs as $currentJs)
		{
			?>
			<script type="text/javascript" language="javascript" src="<?php echo SERVER_ADMIN_HOST?>js/<?php echo $currentJs ?>"></script>
			<?php
		}
	}
?>
</head>
<body>
<div class="page_mn">
