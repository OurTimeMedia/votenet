<?php
require_once("include/general_includes.php");
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$objEncDec = new encdec();

$objClient = new client();
$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$objWebsitePages = new website_pages();

$mode = ADD;
if(isset($_REQUEST['pid']) && $_REQUEST['pid'] !="")
{
	$page_id = $objEncDec->decrypt($_REQUEST['pid']);
	$objWebsitePages->setAllValues($page_id);
	$mode = EDIT;
}	

$extraJs = array("website_pages.js");

include SERVER_CLIENT_ROOT."include/header_popup.php";
include "website_pages_addedit_db.php";
?>
<!--Start content -->
  <div class="content_mn">
    <div class="content_mn2">
      <div class="cont_mid">
        <div class="cont_lt">
          <div class="cont_rt">
            <div class="user_tab_box">
			<?php $msg->displayMsg(); ?>
              <div class="blue_title2">
                <div class="blue_title_lt2">
                  	<div class="blue_title_rt2">
					</div>
                </div>
              </div>
              <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont2">                                 
                                  <?php  include SERVER_CLIENT_ROOT."website_pages_addedit_form.php";?>
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
  <div class="clear"></div>
</div>
<!--Start footer -->
<?php include SERVER_CLIENT_ROOT."include/footer_popup.php"; ?>