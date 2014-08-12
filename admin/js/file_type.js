function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="file_type_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "file_type_list.php";
	
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
	
		if(confirm("Are you sure you want to delete selected File Type(s)?"))
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
	arValidate[index++] = new Array("R", "document.frm.txtfile_type_name", "File Type Name");
	arValidate[index++] = new Array("R", "document.frm.txtfile_type_extension", "File Type Extension");
	arValidate[index++] = new Array("R", "document.frm.selfile_type_base", "File Type Base");
	if (!Isvalid(arValidate)){
		return false;
	}
	
	var ext = document.frm.txtfile_type_extension.value;
	
	if(!isFileExt(ext))
	{
		alert("Please enter valid File Type Extension!");
		document.frm.txtfile_type_extension.focus();
		return false;
	}
	
	
	var index = 0;
	var arValidate = new Array;
	//arValidate[index++] = new Array("R", "document.frm.rdofile_type_isactive", "Active");
	arValidate[index++] = new Array("S", "document.frm.rdofile_type_isactive", "Active");
	if (!Isvalid(arValidate)){
		return false;
	}
	
	return true;	
}