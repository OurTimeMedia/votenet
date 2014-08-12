<?php
require_once 'include/general_includes.php';

$content = file_get_contents(VOTER_PDF_DIR."tempvoter".$_REQUEST['rand'].".pdf");
header("Content-type: application/pdf");
header("Content-Disposition:attachment;filename=voter".$_REQUEST['rand'].".pdf");
header("Content-Length: " . strlen($content));        
echo $content;
unlink(VOTER_PDF_DIR."tempvoter".$_REQUEST['rand'].".pdf");
?>