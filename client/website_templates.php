<?php
require_once("include/general_includes.php");
require_once SERVER_ROOT.'common/class/s3/s3.php';

$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$objEncDec = new encdec();
$objClient = new client();
$objPlan = new plan();
$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);
$plan_id = $objClient->fieldValue("plan_id",$userID);

$objPlan->setAllValues($plan_id);

$objSponsors = new create_client_sponsors();

$objWebsite = new website();
$objWebsite->setAllValues($client_id);

include "website_templates_db.php";

$objWebsitePages = new website_pages();
$cond_webpage = " AND client_id='".$client_id."' ";
$arrWebsitePages = $objWebsitePages->fetchAllAsArray("", "", $cond_webpage);

$condition = " AND ".DB_PREFIX."sponsors.client_id='".$client_id."' ";
$orderby = "sponsors_id asc";
$aSponsorsDetail = $objSponsors->fetchAllAsArraySponsors("","",$condition,$orderby);
	
$extraJs = array("ajaxupload.js", "website_templates.js", "jscolor.js", "timymce_editor.js");

include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";	


/*$tmp_background_dir = "ElectionImpactProd/files/background/tmp_bgImage_".$client_id.".jpg";
$s3 = new s3(AMAZON_KEY, AMAZON_SECRET_KEY);
$s3->deleteObject(BUCKET_NAME,$tmp_background_dir);
		
$tmp_banner_dir = "ElectionImpactProd/files/banners/tmp_bannerImage_".$client_id.".jpg";
$s3 = new s3(AMAZON_KEY, AMAZON_SECRET_KEY);
$s3->deleteObject(BUCKET_NAME,$tmp_banner_dir);*/
?>
<div class="content_mn">
<div class="content_mn2">
  <div class="cont_mid">
	<div class="cont_lt">
	  <div class="cont_rt">
		<div class="user_tab_mn">
		<?php $msg->displayMsg(); ?>
		  <div class="blue_title">
			<div class="blue_title_lt">
				<div class="blue_title_rt">
				<div class="fleft">Website Template</div>
				<div class="fright"></div>
			  </div>
			</div>
		  </div>
		  <div class="content-box">
			<div class="content-left-shadow">
				<div class="content-right-shadow">
					<div class="content-box-lt">
						<div class="content-box-rt">
							<div class="blue_title_cont">
							  <?php  include SERVER_CLIENT_ROOT."website_templates_form.php";?>
						  </div>
						</div>
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
</div>
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>