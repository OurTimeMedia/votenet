function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="party_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "party_list.php";
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
		if(confirm("Are you sure you want to delete selected Contest Admin(s)?"))
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

function validate()
{
	var index = 0;
	var arValidate = new Array;
		
	arValidate[index++] = new Array("S", "document.frm.selState", "State");
	arValidate[index++] = new Array("S", "document.frm.selRaceGroup", "Race Group");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}