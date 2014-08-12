<?php
$objPlan->custom_domain = $cmn->setVal(trim($cmn->readValue($_POST["custom_domain"],"")));
$objPlan->custom_field = $cmn->setVal(trim($cmn->readValue($_POST["custom_field"],"")));
$objPlan->custom_color = $cmn->setVal(trim($cmn->readValue($_POST["custom_color"],"")));
$objPlan->download_data = $cmn->setVal(trim($cmn->readValue($_POST["download_data"],"")));
$objPlan->plan_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnplan_id"],"")));
$objPlan->plan_title = $cmn->setVal(trim($cmn->readValue($_POST["plan_title"],"")));
$objPlan->plan_description = $cmn->setVal(trim($cmn->readValue($_POST["plan_description"],"")));
$objPlan->plan_amount = $cmn->setVal(trim($cmn->readValue($_POST["plan_amount"],"")));
$objPlan->plan_ispublish = $cmn->setVal(trim($cmn->readValue($_POST["plan_ispublish"],"")));

$objPlan->FB_application = $cmn->setVal(trim($cmn->readValue($_POST["FB_application"],"")));
$objPlan->API_access = $cmn->setVal(trim($cmn->readValue($_POST["API_access"],"")));
$objPlan->plan_isactive = $cmn->setVal(trim($cmn->readValue($_POST["plan_isactive"],"")));
$objPlan->created_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);
$objPlan->updated_by = $cmn->getSession(SYSTEM_ADMIN_USER_ID);	
?>