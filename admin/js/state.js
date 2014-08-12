function display_lanrows(language_name)
{
	var name="document.getElementById('"+language_name+"').checked";	
//	alert(eval(name));
	if(eval(name))
	{
		var new1="document.getElementById('statename_"+language_name+"').style.display='';";
		eval(new1);
		var new2="document.getElementById('fname_"+language_name+"').style.display='';";
		eval(new2);
		var new3="document.getElementById('mname_"+language_name+"').style.display='';";
		eval(new3);
		var new4="document.getElementById('lname_"+language_name+"').style.display='';";
		eval(new4);
		var new5="document.getElementById('address1_"+language_name+"').style.display='';";
		eval(new5);
		var new6="document.getElementById('address2_"+language_name+"').style.display='';";
		eval(new6);
		var new7="document.getElementById('city_"+language_name+"').style.display='';";
		eval(new7);
	}
	else
	{
		var new1="document.getElementById('statename_"+language_name+"').style.display='none';";
		eval(new1);
		var new2="document.getElementById('fname_"+language_name+"').style.display='none';";
		eval(new2);
		var new3="document.getElementById('mname_"+language_name+"').style.display='none';";
		eval(new3);
		var new4="document.getElementById('lname_"+language_name+"').style.display='none';";
		eval(new4);
		var new5="document.getElementById('address1_"+language_name+"').style.display='none';";
		eval(new5);
		var new6="document.getElementById('address2_"+language_name+"').style.display='none';";
		eval(new6);
		var new7="document.getElementById('city_"+language_name+"').style.display='none';";
		eval(new7);
	}
	
}

function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="state_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "state_list.php";
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
function setfocus()
{
	document.frm.state_name.focus();
}

function validate()
{
	var defaultLanguageID = document.frm.hdndefaultlanguage_id.value;
	var index = 0;
	var arValidate = new Array;
	
	arValidate[index++] = new Array("R", "document.frm.state_name_"+defaultLanguageID, "State Name");
	/*arValidate[index++] = new Array("R", "document.frm.state_secretary_fname_"+defaultLanguageID, "Secretary First Name");
	arValidate[index++] = new Array("R", "document.frm.state_secretary_mname_"+defaultLanguageID, "Secretary Middle Name");
	arValidate[index++] = new Array("R", "document.frm.state_secretary_lname_"+defaultLanguageID, "Secretary Last Name");
	arValidate[index++] = new Array("R", "document.frm.state_address1_"+defaultLanguageID, "Secretary Address");
	arValidate[index++] = new Array("R", "document.frm.state_address2_"+defaultLanguageID, "Secretary Address2");
	arValidate[index++] = new Array("R", "document.frm.state_city_"+defaultLanguageID, "State City");
	arValidate[index++] = new Array("R", "document.frm.zipcode", "Zip Code");
	arValidate[index++] = new Array("R", "document.frm.email", "Email");*/
	
	if(document.frm.email.value != "")
		arValidate[index++] = new Array("E", "document.frm.email", "Email");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}