// JavaScript Document
function submitfrm(frm)
{
	if(trim(frm.txturl.value).length==0)
	{
		alert("Please enter URL.");
		frm.txturl.focus();
		return false;
	}

	if(trim(frm.txtemail.value).length==0)
	{
		alert("Please enter email.");
		frm.txtemail.focus();
		return false
	}

	if(!isEmail(trim(frm.txtemail.value)))
	{
		alert("Please enter valid email.");
		frm.txtemail.focus();
		return false
	}
	if(trim(frm.txtmin.value).length==0)
	{
		alert("Please enter delay minute.");
		frm.txtmin.focus();
		return false
	}
		if(trim(frm.txtsec.value).length==0)
	{
		alert("Please enter delay second.");
		frm.txtsec.focus();
		return false
	}



	return true;
}