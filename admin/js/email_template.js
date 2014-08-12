function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="email_template_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "email_template_list.php";
	
	if (actiontype=="delete")
	{
		mycount = 0;
		
		for(i=0;i<document.frm.elements.length;i++)
		{
			if(document.frm.elements[i].name=="deletedids[]" && document.frm.elements[i].checked)
			{
				mycount++;	
			}
		}

		if(mycount==0)
		{
			alert("You must check at least one checkbox.");
			return false;
		}
	
		if(confirm("Are you sure you want to delete selected Email(s)?"))
		{
			document.frm.hdnmode.value = "delete";
			document.frm.submit();
			return;
		}
		else
			return false;
	}
	else if (actiontype=="active")
	{
		document.frm.hdnmode.value = "active";
		document.frm.submit();		
	}
	
}

function setfocus()
{
	document.frm.txtusername.focus();
}

function validate()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtemail_templates_name", "Name of Email Template");
	arValidate[index++] = new Array("R", "document.frm.txtemail_subject", "Subject");

	if (!Isvalid(arValidate)){
		return false;
	}
	
	tinyMCE.triggerSave(); 
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtemail_body", "Content");
	
	if (!Isvalid(arValidate)){
		tinyMCE.execCommand('mceFocus', false, 'txtemail_body');
		return false;
	}

	return true;	
}