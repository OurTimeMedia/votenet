<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once 'meta-tags.php'; ?>
<link href="<?php echo SITE_URL; ?>css/election.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITE_URL; ?>css/stylesheet.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo SITE_URL; ?>js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL; ?>js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL; ?>js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	
<?php if($_REQUEST['cms_seo_url'] == 'home' or $_REQUEST['cms_seo_url'] == '') { ?>
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/nivo-slider.css" type="text/css" media="screen" />
    
    <script type="text/javascript" src="<?php echo SITE_URL; ?>js/jquery.nivo.slider.pack.js"></script>
	
    <script type="text/javascript">
    $(window).load(function() {
    $('#slider').nivoSlider({
        effect:'random', //Specify sets like: 'fold,fade,sliceDown'
        slices:15,
        animSpeed:500, //Slide transition speed
        pauseTime:5000,
        startSlide:0, //Set starting Slide (0 index)
        directionNav:false, //Next & Prev
        directionNavHide:false, //Only show on hover
        controlNav:false, //1,2,3...
        controlNavThumbs:false, //Use thumbnails for Control Nav
        controlNavThumbsFromRel:false, //Use image rel for thumbs
        controlNavThumbsSearch: '.jpg', //Replace this with...
        controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
        keyboardNav:true, //Use left & right arrows
        pauseOnHover:true, //Stop animation while hovering
        manualAdvance:false, //Force manual transitions
        captionOpacity:0.8, //Universal caption opacity
        beforeChange: function(){},
        afterChange: function(){},
        slideshowEnd: function(){}, //Triggers after all slides have been shown
        lastSlide: function(){}, //Triggers when last slide is shown
        afterLoad: function(){} //Triggers when slider has loaded
    });
});
</script>
<?php } ?>
	<script type="text/javascript">
		$(document).ready(function () {
			/*
				Dropdown menu
			*/
			$('.menu ul li').hover(
				function () {
					//show its submenu
					$('ul', this).slideDown(100);

				}, 
				function () {
					//hide its submenu
					$('ul', this).slideUp(100);			
				}
			);
		});
	</script>
</head>
<body>
	<?php if($_REQUEST['cms_seo_url'] == 'home' or $_REQUEST['cms_seo_url'] == '') { ?>
	<div class="main-top">
	<?php } else { ?>
	<div class="boby-sub">
	<div class="main-top-sub">
	<?php } ?>
    	<!--contener start -->
    	<div id="contener">
        	<!--top start -->
        	<div id="top">
            	<div class="top-header">
                	<a target="_blank" href="http://www.twitter.com/votenet"><img alt="Twitter" src="<?php echo SITE_URL; ?>images/twitter-iocn.gif" class="social"></a>
					<a target="_blank" href="http://www.facebook.com/VotenetSolutions?ref=ts"><img alt="Facebook" src="<?php echo SITE_URL; ?>images/facebook-icon.gif" class="social"></a>
					<p>or <span><a href="mailto:<?php echo $objsite_config->from_email; ?>"><?php echo $objsite_config->from_email; ?></a></span> </p><p>Contact Us at <span>1-800-VOTENET</span>&trade; <br /> <span class="call">(868-3638)</span></p>
                </div>
                <div class="top-buttomb"> 
               	  <a class="logo" href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL; ?>images/logo.gif" /></a>
                    <div class="menu">
						<ul id="nav">
							<?php include 'menu.php'; ?>
						</ul>
                    </div>
                </div>
            </div>
			<!--top end -->
            <?php if($_REQUEST['cms_seo_url'] == 'home' or $_REQUEST['cms_seo_url'] == '') { ?>
			<!-- Header start -->
			<div id="header">
           	 <div class="header-left">
			  <p><a href="press-release">Social Voter<br />Registration<br />is Here</a><br />
				<span>Turn Your Web Site and Facebook Fan Page Into a Voter Registration Center</span></p>
				
                <a href="http://www.electionimpact.com/demo/" class="demo"><img alt="View Demo" src="<?php echo SITE_URL; ?>images/view-demo.gif"></a>
				
				<a href="<?php echo SITE_URL; ?>request-info/" class="request"><img alt="Request Information" src="<?php echo SITE_URL; ?>images/request-information-btn.gif"></a>
				
                <img src="<?php echo SITE_URL; ?>images/request-mobilize.gif" />
             </div>
             <div class="header-right">
				<div class="slider">
					<div id="frag_2" style="text-align:left;">
					<div id="slider">
						<img src="<?php echo SITE_URL; ?>images/slider-img.jpg" alt="" />
						<img src="<?php echo SITE_URL; ?>images/slider-img1.jpg" alt="" />
						<img src="<?php echo SITE_URL; ?>images/slider-img2.jpg" alt="" />
						<img src="<?php echo SITE_URL; ?>images/slider-img3.jpg" alt="" />
                        <img src="<?php echo SITE_URL; ?>images/slider-img4.jpg" alt="" />
                        <img src="<?php echo SITE_URL; ?>images/slider-img5.jpg" alt="" />
                        <img src="<?php echo SITE_URL; ?>images/slider-img6.jpg" alt="" />
					   </div>
					</div>
				</div>
             </div>
			</div>
			<!-- Header end -->
			<?php } ?>