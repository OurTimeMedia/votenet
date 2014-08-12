<div id="header-sub">
	<h1><?php echo trim($arcms[0]['cms_title']); ?></h1>
	<p class="register"><?php echo trim($arcms[0]['cms_sub_title']); ?></p>
</div>
<div id="middle-sub"><?php echo trim($arcms[0]['cms_content']); ?>
<?php
	$extClass = '';
	if($_REQUEST['cms_seo_url'] == 'overview' || $_REQUEST['cms_seo_url'] == 'press-release') {
		$extClass	= 'aboutbtn-op';
} ?>
<p class="aboutbtn <?php echo $extClass; ?>" align="center">
 	<a href="<?php echo SITE_URL; ?>demo"><img src="<?php echo SITE_URL; ?>images/view-demo-sub.gif" width="281" height="73" /></a> 
	<a href="<?php echo SITE_URL; ?>request-info"><img src="<?php echo SITE_URL; ?>images/request-information-btn-sub.gif" width="402" height="73" /></a>
	<?php if($_REQUEST['cms_seo_url'] == 'overview' || $_REQUEST['cms_seo_url'] == 'press-release') { ?>
		<a href="<?php echo SITE_URL; ?>pdf/Election_Impact_Product_Slick.pdf" target="_blank&quot;"><img width="313" height="73" alt="Download the Product Brochure" src="<?php echo SITE_URL; ?>images/download-btn.gif"></a>
	<?php } ?>
</p>
</div>