<?php	
require_once("include/general_includes.php");

$client_id = 0;

$objForm = new form();
$objForm->setAllValues($client_id);

$sHeaderBackground = SERVER_HOST . "common/files/background/" . $objForm->form_background;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php print SITE_TITLE;?></title>
<style type="text/css">
	.header_banner {
		height:300px;
		font-family:Arial, Helvetica, sans-serif;
		font-size:30px;
		color:#ffffff;
		font-weight:bold;
		padding:0px 0px 0px 20px;		
	}
	
	.banner-container {
		float:left;
		width:300px;
		overflow:hidden;
		padding:5px;
	}
</style>
</head>
<body>
<div class="banner-container">
<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" onSubmit="return designValidations();">
  <table width="300" cellspacing="0" cellpadding="0" border="0">
    <tbody>
      <tr>
        <td valign="top" align="left"><img src="<?php echo $sHeaderBackground; ?>" border="0"></td>
      </tr>
    </tbody>
  </table>
</form>  
</div>
</body>
</html>
