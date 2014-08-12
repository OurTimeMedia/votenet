function display_lanrows(language_name)
{
	var name="document.getElementById('"+language_name+"').checked";	
//	alert(eval(name));
	if(eval(name))
	{
		var new1="document.getElementById('eligibilitycriteria_"+language_name+"').style.display='';";
		eval(new1);		
	}
	else
	{
		var new1="document.getElementById('eligibilitycriteria_"+language_name+"').style.display='none';";
		eval(new1);		
	}
	
}

function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="eligibility_criteria_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "eligibility_criteria_list.php";
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
	var defaultLanguageID = document.frm.hdndefaultlanguage_id.value;
	var index = 0;
	var arValidate = new Array;
		
	arValidate[index++] = new Array("R", "document.frm.eligibility_criteria_"+defaultLanguageID, "Eligibility Criteria");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}