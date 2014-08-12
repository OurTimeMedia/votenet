function submitfrm(frm)
{

	if(trim(frm.txtold_password.value).length==0)
	{
		alert("Please enter old password.");
		frm.txtold_password.focus();
		return false
	}

	if(trim(frm.txtpassword.value).length==0)
	{
		alert("Please enter password.");
		frm.txtpassword.focus();
		return false
	}

	/*
	if(trim(frm.txtpassword.value).length<6)
	{
		alert("Please enter password of minimum 6 characters.");
		frm.txtpassword.focus();
		return false
	}
	*/

	if(trim(frm.txtcpassword.value).length==0)
	{
		alert("Please enter confirm password.");
		frm.txtcpassword.focus();
		return false
	}
	
	if(trim(frm.txtpassword.value) != trim(frm.txtcpassword.value))
	{
		alert("Your password is no same as confirm password.");
		frm.txtpassword.focus();
		return false
	}
return true;
}
