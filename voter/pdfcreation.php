<?php
require_once("include/common_includes.php");

$postdata = rawurldecode($_SERVER['QUERY_STRING']);
$postdata = strstr($postdata, "data=");
$postdata = substr($postdata, 5, strlen($postdata));  

$ch = curl_init();
$timeout = 5;
$rand = rand();
$fp = @fopen(VOTER_PDF_DIR."tempvoter".$rand.".pdf", "w");	
curl_setopt($ch,CURLOPT_URL,"http://www.electionimpact.com/SetaPDF/Demos/demo1.php");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
curl_setopt($ch, CURLOPT_POST, true );
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

//unlink(VOTER_PDF_DIR."tempvoter".$_REQUEST['rand'].".pdf");
/*$content = file_get_contents(VOTER_PDF_DIR."tempvoter".$rand.".pdf");
header("Content-type: application/pdf");
header("Content-Disposition:attachment;filename=voter".$rand.".pdf");
header("Content-Length: " . strlen($content));        
echo $content;*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<script type="text/javascript">
parent.downloadPDF('<?php echo $rand;?>');
</script>
</body>
</html>