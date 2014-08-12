	</div>
        <!--contener end -->
        <div id="footer-mail">
        	<div id="footer">
            	<div class="companb">
                	<h3>COMPANY</h3>
					<ul id="nav">
						<li><a href="<?php echo SITE_URL; ?>" <?php echo $_REQUEST['cms_seo_url']; if($_REQUEST['cms_seo_url'] == '' || $_REQUEST['cms_seo_url'] == 'home') { ?>class="active"<?php } ?>>Home</a></li>
						<?php $noChilds = 0; include 'menu.php'; ?>
					</ul>
                </div>
                <div class="contact">
                	<h3>CONTACT</h3>
                    <p class="add"><?php echo $objsite_config->street; ?>, <br />
<?php echo $objsite_config->town; ?>, <br />
<?php echo $objsite_config->state; ?> <?php echo $objsite_config->zipcode; ?>
</p>
					<p class="call"><?php if($objsite_config->phone != '') { ?>P: <?php echo $objsite_config->phone; ?>,<?php } ?> 1-800-VOTENET&trade; <br />
                                      <span>(868-3638)</span><br />
<?php if($objsite_config->fax != '') { ?>F: <?php echo $objsite_config->fax; ?>,<?php } ?> <?php if($objsite_config->from_email != '') { ?>email: <a href="mailto:<?php echo $objsite_config->from_email; ?>"><?php echo $objsite_config->from_email; ?></a><?php } ?></p>
                </div>
                <p class="copy"><?php echo $objsite_config->Copy; ?>
				<?php
					$fMenu = $objcms->fetchallasarray(null,null,' AND cms_id IN (17,20) ');
				?>
				<a href="<?php echo SITE_URL.$fMenu[1]['seo_url']; ?>" <?php if($_REQUEST['cms_seo_url'] == $fMenu[1]['seo_url']) { ?>class="active"<?php } ?>><?php echo $fMenu[1]['cms_title']; ?></a> | <a href="<?php echo SITE_URL.$fMenu[0]['seo_url']; ?>" <?php if($_REQUEST['cms_seo_url'] == $fMenu[0]['seo_url']) { ?>class="active"<?php } ?>><?php echo $fMenu[0]['cms_title']; ?></a></p>
            </div>
			</div>
        </div>
	</div>
	<?php if($_REQUEST['cms_seo_url'] == 'home' or $_REQUEST['cms_seo_url'] == '') { ?>
	</div>
	<?php } ?>
</body>
</html>