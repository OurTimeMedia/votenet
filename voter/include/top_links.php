<?php
$domain = $_REQUEST['domain'];
$objWebsite = new website();
$condition = " AND domain='".$domain."' ";
$client_id = $objWebsite->fieldValue("client_id","",$condition);
	
require_once (COMMON_CLASS_DIR ."clswebsite_pages.php");
$objWebsitePages = new website_pages();
$cond_webpage = " AND client_id='".$client_id."' ";
$arrWebsitePages = $objWebsitePages->fetchAllAsArray("", "", $cond_webpage);

require_once (COMMON_CLASS_DIR ."clsencdec.php");
$objEncdec = new encdec();

$toplinks = "<ul><li><a href='index.php' class='act-top'>".LANG_HOME_TEXT."</a></li>";

foreach($arrWebsitePages as $awpkey => $awpval)		
{
	if($awpval['page_type'] == 1)
		$toplinks.= "<li><a href='page.php?pid=".$objEncdec->encrypt($awpval['page_id'])."' target='_blank' class='act-top'>".$awpval['page_name']."</a></li>";
	else
		$toplinks.= "<li><a href='page.php?pid=".$objEncdec->encrypt($awpval['page_id'])."' class='act-top'>".$awpval['page_name']."</a></li>";
}
		
$toplinks.= "<ul>";

echo $toplinks;
?>
