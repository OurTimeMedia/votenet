<?php
require_once("include/common_includes.php");
$page_id = 2;
require_once("include/general_includes.php");
require_once(COMMON_CLASS_DIR . "clsstate.php");

if (isset($_REQUEST["lng"])) {
    header("Location: index.php");
    exit;
}

if ((isset($_POST['btnsubmit']) && $_POST['btnsubmit'] != "") || (isset($_POST['btnsubmit_x']) && $_POST['btnsubmit_x'] != "")) {
    include "registrationform1_db.php";
}

$objState = new state();

if ($cmn->getSession('Home_State_ID') == "") {
    header("location: index.php");
    exit;
}

// set up auto-loader
include DWOO_DIR . 'dwooAutoload.php';

if ($cmn->getSession('Home_State_ID') == 51 || $cmn->getSession('Home_State_ID') == 37)
    $template_file = DESIGN_TEMPLATES_DIR . SITE_TEMPLATE_DIR . "/registration_ristricted.tpl";
else
    $template_file = DESIGN_TEMPLATES_DIR . SITE_TEMPLATE_DIR . "/registrationform1.tpl";

// create Dwoo object
$dwoo = new Dwoo();

// read template file
$tpl = new Dwoo_Template_File($template_file);

if (!empty($_SESSION["err"])) {
    // Set red border for error fields
    if (isset($_SESSION["err_fields"])) {
        $err_fields = split("\|", $_SESSION["err_fields"]);
        unset($_SESSION["err_fields"]);
        for ($i = 0; $i < count($err_fields); $i++) {
            $err_fields[$i] = "class_" . $err_fields[$i];
            $$err_fields[$i] = "input-red-border";
        }
    }
}

// assign values to template variables
$data = array();
$data['main_menu'] = 0;
$data = $tmpl->get_ragister_form_language($data);
$data['header_data'] = $header_data;
$data['client_id'] = $objWebsite->client_id;
$data['hide_banner'] = $objWebsite->hide_banner;
$data['hide_navigation'] = $objWebsite->hide_navigation;
$data['hide_steps'] = $objWebsite->hide_steps;

if ($objWebsite->background_color != "")
    $data['background_color'] = $objWebsite->background_color;

if ($objWebsite->background_image != "")
    $data['background_image'] = SERVER_HOST . BACKGROUND_IMAGE . $objWebsite->background_image;
//$data['background_image'] = BACKGROUND_IMAGE_DIR_S3.$objWebsite->background_image;

if ($objWebsite->banner_image != "")
    $data['banner_image'] = SERVER_HOST . BANNER_IMAGE . $objWebsite->banner_image;
//$data['banner_image'] = BANNER_DIR_S3.$objWebsite->banner_image;

if ($objWebsite->top_nav_background_color != "")
    $data['nav_background_color'] = $objWebsite->top_nav_background_color;

if ($objWebsite->top_nav_text_color != "")
    $data['nav_text_color'] = $objWebsite->top_nav_text_color;

if (!isset($data['banner_image'])) {
    $data['hide_banner'] = 1;
}

$data = $tmpl->get_site_array($data);
$data['islanguage'] = 0;

require_once(COMMON_CLASS_DIR . "clscreate_client_sponsors.php");

$objClientSponsors = new create_client_sponsors();
$condition = " AND " . DB_PREFIX . "sponsors.client_id='" . $objWebsite->client_id . "' ";
$orderby = "sponsors_id asc";
$aSponsorsDetail = $objClientSponsors->fetchAllAsArraySponsors("", "", $condition, $orderby);


$data['sponsers'] = $tmpl->get_sponsers_array($aSponsorsDetail);
$data['issponsers'] = 0;
if (count($data['sponsers']) > 0) {
    $data['issponsers'] = 1;
}

$data['submit_form'] = $_SERVER['REQUEST_URI'];
$data['Voting_Source'] = "Website";
$data['Voting_State_id'] = $cmn->getSession('Home_State_ID');
$data['mobile_device'] = ismobile();

if ($cmn->getSession('votingSource') == "Facebook") {
    $data['Voting_Source'] = "Facebook";
    $data['issponsers'] = 0;
}
//________________ End ________________//
// interpolate values into template
// send interpolated result to output device
$dwoo->output($tpl, $data);
?>