<?php	include(ADMIN_PANEL_PATH.'class/testimonial.class.php');	$objTestimonial	= new testimonial();	$tId	= $_REQUEST['tId'];	$arTestimonial	= $objTestimonial->fetchallasarray($tId);?><div id="header-sub">	<h1><?php echo trim($arTestimonial[0]['title']); ?></h1>	<p class="register"></p></div><div id="middle-sub"><?php echo trim($arcms[0]['cms_content']); ?></div><?php								include(ADMIN_PANEL_PATH.'class/testimonial.class.php');								$objTestimonial	= new testimonial();								$arTestimonial	= $objTestimonial->fetchallasarray();																for($c=0; $c<min(count($arTestimonial),3); $c++)								{							?>									<div class="blog-comb">										<?php if($arTestimonial[$c]['by_name'] != '' and file_exists(TESTIMONIAL_UPLOAD_DIR_FRONT.'59x55_'.$arTestimonial[$c]['by_name'])) { ?>											<img src="<?php echo SITE_URL.TESTIMONIAL_UPLOAD_DIR_FRONT.'59x55_'.$arTestimonial[$c]['by_name']; ?>" alt="<?php echo trim($arTestimonial[$c]['title']); ?>" title="<?php echo trim($arTestimonial[$c]['title']); ?>" />										<?php }else{ ?>											<img src="<?php echo SITE_URL.NO_IMAGE_AVAILABLE ?>" alt="No Image" title="No Image" width="59" />										<?php } ?>																				<div class="testimonb">											<em class="l"><img src="<?php echo SITE_URL; ?>images/testi1.gif" /></em>											<span><?php echo $cmn->textLimit(strip_tags($arTestimonial[$c]['content']),69); ?></span>											<p class="r"><a href="<?php echo SITE_URL; ?>testimonial/<?php echo $arTestimonial[$c]['id']; ?>/" title="Read More">Read More</a></p>										  </div>									  </div>							<?php								}							?>