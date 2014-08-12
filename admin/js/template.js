

function setaction(actiontype)
{	
	document.frm.action = "template_list.php";
	
	if (actiontype=="active")
	{
		document.frm.hdnmode.value = "active";
		document.frm.submit();		
	}
	else if (actiontype=="private")
	{
		document.frm.hdnmode.value = "private";
		document.frm.submit();		
	}
	else if (actiontype=="update")
	{
		document.frm.hdnmode.value = "update";
		document.frm.submit();		
	}
}
