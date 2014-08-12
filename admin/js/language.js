function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="language_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "language_list.php";
	
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
	
		if(confirm("Are you sure you want to delete selected Resource(s)?"))
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
	document.frm.txtlanguage_name.focus();
}

function validate()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtlanguage_name", "Language Name");
	arValidate[index++] = new Array("R", "document.frm.txtlanguage_code", "Language Code");
	arValidate[index++] = new Array("R", "document.frm.txtlanguage_order", "Language Order");
	arValidate[index++] = new Array("I", "document.frm.txtlanguage_order", "Language Order");
	arValidate[index++] = new Array("R", "document.frm.rdolanguage_isactive", "Active");
	arValidate[index++] = new Array("R", "document.frm.rdolanguage_ispublish", "Publish");
	var totFields = document.getElementById("txttotfields").value;
	for(var i=0;i<totFields; i++)
	{	
		var fieldName = eval("document.getElementById('txtField"+i+"').value");
		fieldName = fieldName.split("###");
		arValidate[index++] = new Array("R", "document.frm.txt"+fieldName[0], 'Field "'+fieldName[1]+'"');
	}
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}