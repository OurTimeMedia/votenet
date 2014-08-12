function validate()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtuser_username", "Username");
	//arValidate[index++] = new Array("E", "document.frm.txtuser_email", "Email");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}