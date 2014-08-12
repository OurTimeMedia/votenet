function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="client_admin_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "client_admin_list.php";
	
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
	
		if(confirm("Are you sure you want to delete selected Admin(s)?"))
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

function search_record(frm)
{
	frm.submit();
}

function validate()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtuser_username", "Username");
	arValidate[index++] = new Array("L", "document.frm.txtuser_username", "Username");
	
	arValidate[index++] = new Array("R", "document.frm.user_password", "Password");
	arValidate[index++] = new Array("PASSWORD", "document.frm.user_password", "Password");
	arValidate[index++] = new Array("R", "document.frm.user_confirmpassword", "Confirm Password");
	arValidate[index++] = new Array("P", "document.frm.user_password|document.frm.user_confirmpassword", "Password and Confirm Password must be same.");
	
	arValidate[index++] = new Array("R", "document.frm.txtuser_firstname", "First Name");
	arValidate[index++] = new Array("A", "document.frm.txtuser_firstname", "First Name");
	
	arValidate[index++] = new Array("R", "document.frm.txtuser_lastname", "Last Name");
	arValidate[index++] = new Array("A", "document.frm.txtuser_lastname", "Last Name");
	
	arValidate[index++] = new Array("R", "document.frm.txtuser_designation", "Designation");
	
	arValidate[index++] = new Array("R", "document.frm.txtuser_email", "Email");
	arValidate[index++] = new Array("E", "document.frm.txtuser_email", "Email");
			
	//arValidate[index++] = new Array("R", "document.frm.rdouser_isactive", "Status");
	arValidate[index++] = new Array("S", "document.getElementById('rdouser_isactive')", "Status");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}