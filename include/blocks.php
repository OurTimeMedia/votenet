<!-- middle start -->
<div id="middle">
	<div class="unions-b">
		<div class="unions-bb">
			<div class="unions-bt">
				<div class="associationsb">
                   	<h2>Unions</h2>
                     <p>Register union members and turn out the vote on Election Day.</p>
                </div>
                <div class="associationsb">
                  	<h2>Associations</h2>
                    <p>Provide a simple way to register to vote and extend a new convenient benefit to members.</p>
                </div>
                <div class="associationsb">
					<h2>Political Orgs. + Candidates</h2>
                   <p>Turn your web site visitors into registered voters and collect valuable contact information to mobilize your supporters prior to Election Day.</p>
                </div>
            </div>
        </div>
    </div>
	<?php
		if($objsite_config->blog_url != '') {
		include(ADMIN_PANEL_PATH.'class/rss.class.php');
		$feedlist = new rss($objsite_config->blog_url);
	?>
    <div class="unions-b">
       	<div class="unions-bb">
			<div class="blog-bt">
              	<h2>latest blog posts</h2>
					<div class="blogmain">
						<div class="blogb-main">
							<?php echo $feedlist->display(3,"latest blog posts"); ?>
						</div>
					</div>
			</div>
		</div>
	</div>
	<?php } ?>
		 <div class="unions-b">
			<div class="unions-bb">
			  <div class="blog-bt">
					<h2>Customers</h2>
					<div class="blogmain">
					<div class="blogb-main">
						<?php
							include(ADMIN_PANEL_PATH.'class/testimonial.class.php');
							$objTestimonial	= new testimonial();
							$arTestimonial	= $objTestimonial->fetchallasarray(null,null,' AND `active` = \'y\'');
							
							for($c=0; $c<min(count($arTestimonial),3); $c++)
							{
						?>
								<div class="blog-comb">
									<?php if(0) { ?>
									<?php if($arTestimonial[$c]['by_name'] != '' and file_exists(TESTIMONIAL_UPLOAD_DIR_FRONT.'59x55_'.$arTestimonial[$c]['by_name'])) { ?>
										<img src="<?php echo SITE_URL.TESTIMONIAL_UPLOAD_DIR_FRONT.'59x55_'.$arTestimonial[$c]['by_name']; ?>" alt="<?php echo trim($arTestimonial[$c]['title']); ?>" title="<?php echo trim($arTestimonial[$c]['title']); ?>" />
									<?php }else{ ?>
										<img src="<?php echo SITE_URL.NO_IMAGE_AVAILABLE ?>" alt="No Image" title="No Image" width="59" />
									<?php } ?>
									<?php } ?>
									<div class="testimonb">
										<em class="l"><img src="<?php echo SITE_URL; ?>images/testi1.gif" /></em>
										<span><?php echo $cmn->textLimit(strip_tags($arTestimonial[$c]['content']),110); ?></span>
										<p class="r"><a href="<?php echo SITE_URL; ?>customers/" title="Read More">Read More</a></p>
									  </div>
								  </div>
						<?php
							}
						?>
					</div>
					</div>
				</div>
			</div>
		 </div>
	   </div>
	   <!-- middle end-->