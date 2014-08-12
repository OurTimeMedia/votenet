<?php	
header("Content-type: application/pdf"); // add here more headers for diff. extensions
header("Content-Disposition: attachment; filename=\"voter.pdf\""); // use 'attachment' to force a download
echo $_POST['data'];
?>
