function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="email_templates_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "email_templates_list.php";
	
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
	arValidate[index++] = new Array("R", "document.frm.txtemail_templates_name", "Email Name");
	arValidate[index++] = new Array("R", "document.frm.txtemail_from", "Email From");
	arValidate[index++] = new Array("E", "document.frm.txtemail_from", "Email From");
	if(document.frm.txtemail_to.value!="")
	{
			arValidate[index++] = new Array("E", "document.frm.txtemail_to", "Email To");
	}
	if(document.frm.txtemail_cc.value!="")
	{
			arValidate[index++] = new Array("E", "document.frm.txtemail_cc", "Email CC");
	}
	if(document.frm.txtemail_bcc.value!="")
	{
			arValidate[index++] = new Array("E", "document.frm.txtemail_bcc", "Email BCC");
	}
	if(document.frm.txtemail_reply_to.value!="")
	{
			arValidate[index++] = new Array("E", "document.frm.txtemail_reply_to", "Email Reply To");
	}
	arValidate[index++] = new Array("R", "document.frm.txtemail_subject", "Email Subject");
	if (!Isvalid(arValidate)){
		return false;
	}
	
	var oEditor = FCKeditorAPI.GetInstance('txtemail_body');
	var contents = oEditor.GetXHTML(true); 
	var txtemail_body = document.getElementById('txtemail_body___Frame');
	if (contents == "null" || contents == "" )
	{
		alert("Email Body can not be blank.")
		txtemail_body.focus();
		return false;
	}
	
	var index = 0;
	var arValidate = new Array;
	//arValidate[index++] = new Array("R", "document.frm.rdoemail_isactive", "Active");
	arValidate[index++] = new Array("S", "document.frm.rdoemail_isactive", "Active");
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}