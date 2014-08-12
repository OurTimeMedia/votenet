<?php
$pdffile = "../common/files/voter_pdf/tempvoter".$_REQUEST['rand'].".pdf";

$content = file_get_contents($pdffile);
header("Content-Disposition:attachment;filename=voter".$_REQUEST['rand'].".pdf");
header("Content-type: application/pdf");
header("Cache-control: private"); //use this to open files directly
header("Content-Length: " . strlen($content));        
echo $content;

unlink($pdffile);
?>