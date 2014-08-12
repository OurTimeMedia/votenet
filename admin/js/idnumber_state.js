function display_lanrows(language_name, language_id)
{
	var name="document.getElementById('"+language_name+"').checked";	
//	alert(eval(name));
	if(eval(name))
	{
		var new1="document.getElementById('id_numbernote_"+language_name+"').style.display='';";		
		eval(new1);		
	}
	else
	{
		var new1="document.getElementById('id_numbernote_"+language_name+"').style.display='none';";
		document.getElementById('id_number_note_'+language_id).value = "";
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
	arValidate[index++] = new Array("S", "document.frm.selidnumber", "ID Number");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}