function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="security_block_ip_list.php";
}

function setfocus()
{
	document.frm.txtipaddress.focus();
}

function validateIP()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtipaddress", "IP Address");
	if (!Isvalid(arValidate)){
		return false;
	}
	
	 var re = /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/;
	 var inputString  = document.frm.txtipaddress.value;
	 if (re.test(inputString)) {

 	  var parts = inputString.split(".");
  	 if (parseInt(parseFloat(parts[0])) == 0) {
  	   alert("Please enter valid IP Address");
		document.frm.txtipaddress.focus();
		return false;
  	 }
	  for (var i=0; i<parts.length; i++) {
		 if (parseInt(parseFloat(parts[i])) > 255) {
		   alert("Please enter valid IP Address");
		document.frm.txtipaddress.focus();
		return false;
		 }
	   }
	   return true;
	 }
	 else {
	   alert("Please enter valid IP Address");
		document.frm.txtipaddress.focus();
		return false;
	 }

	return true;	
}

function validateUser()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtuser", "User Name");
	if (!Isvalid(arValidate)){
		return false;
	}
	
	var unames = document.frm.txtuser.value;

	var un = unames+",";
	var u = document.frm.definedUsers.value;
	if(u.indexOf(un)==-1)
	{
		alert(unames+ " User not Available! Please enter valid User Name!");
		document.frm.txtuser.focus();
		return false;
	}
	
	return true;	
}


function setaction(actiontype)
{	
	document.frm.action = "security_block_ip_list.php";

	if (actiontype=="unblock")
	{
		mycount = 0;
		
		for(i=0;i<document.frm.elements.length;i++)
		{
			if(document.frm.elements[i].name=="unblockids[]" && document.frm.elements[i].checked)
			{
				mycount++;	
			}
		}

		if(mycount==0)
		{
			alert("You must check at least one checkbox.");
			return false;
		}
	
		if(confirm("Are you sure you want to Unblock selected IP Address(s)?"))
		{
			document.frm.hdnmode.value = "unblock";
			document.frm.submit();
			return;
		}
		else
			return false;
	}

}

function setactionUser(actiontype)
{	
	document.frm.action = "security_block_user.php";

	if (actiontype=="unblock")
	{
		mycount = 0;
		
		for(i=0;i<document.frm.elements.length;i++)
		{
			if(document.frm.elements[i].name=="unblockids[]" && document.frm.elements[i].checked)
			{
				mycount++;	
			}
		}

		if(mycount==0)
		{
			alert("You must check at least one checkbox.");
			return false;
		}
	
		if(confirm("Are you sure you want to Unblock selected User(s)?"))
		{
			document.frm.hdnmode.value = "unblock";
			document.frm.submit();
			return;
		}
		else
			return false;
	}

}

