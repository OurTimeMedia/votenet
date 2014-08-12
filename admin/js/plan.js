function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="plan_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "plan_list.php";
	
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
	
		if(confirm("Are you sure you want to delete selected Contest Plan(s)?"))
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
	arValidate[index++] = new Array("R", "document.frm.plan_title", "Title");
	
	arValidate[index++] = new Array("R", "document.frm.plan_amount", "Amount");
	arValidate[index++] = new Array("F", "document.frm.plan_amount", "Amount");
	
	arValidate[index++] = new Array("S", "document.frm.plan_ispublish", "Publish");
	
	arValidate[index++] = new Array("S", "document.frm.custom_field", "Custom Field");
	arValidate[index++] = new Array("S", "document.frm.custom_color", "Custom Color");
	arValidate[index++] = new Array("S", "document.frm.download_data", "Download Data");
	arValidate[index++] = new Array("S", "document.frm.FB_application", "FB Application");
	arValidate[index++] = new Array("S", "document.frm.API_access", "API Access");
	arValidate[index++] = new Array("S", "document.frm.plan_isactive", "Active");	
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}