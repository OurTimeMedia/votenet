<?php
if (isset($_REQUEST['btn_addpage']))
{		
	$objvalidation = new validation();
	
	$page_id = intval($objEncDec->decrypt($_REQUEST["hdnpage_id"]));
	
	$objvalidation->addValidation("txtPageName", "Name of page", "req");
	$objvalidation->addValidation("rdoOption", "Option ", "selone");
	
	if($_POST['rdoOption'] == 1)
		$objvalidation->addValidation("txtLink", "Link", "req");	
	else if($_POST['rdoOption'] == 2)
		$objvalidation->addValidation("txtContent", "Content", "req");	
	
	if ($objvalidation->validate())
	{	
		include_once "website_pages_addedit_field.php";	
		
		if (trim($_POST['hdnmode']) == ADD)
		{
			$objWebsitePages->add();			
		}
	
		//Code to edit record
		if (trim($_POST['hdnmode']) == 'edit' && !empty($_POST['hdnpage_id']))
		{	
			$objWebsitePages->update();			
		}
		
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<body>
		<script type="text/javascript">			
			parent.location.href = "website_templates.php#mpage";
			parent.location.reload();			
			self.parent.tb_remove(); 
		</script>
		</body>
		</html>
		<?php
	}
}
?>