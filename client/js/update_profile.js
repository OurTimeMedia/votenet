function validate()
{
	var index = 0;
	var arValidate = new Array;

	arValidate[index++] = new Array("R", "document.frm.txtuser_firstname", "First Name");
	arValidate[index++] = new Array("A", "document.frm.txtuser_firstname", "First Name");
	
	arValidate[index++] = new Array("R", "document.frm.txtuser_lastname", "Last Name");
	arValidate[index++] = new Array("A", "document.frm.txtuser_lastname", "Last Name");
	
	arValidate[index++] = new Array("R", "document.frm.txtuser_company", "Company");
	
	arValidate[index++] = new Array("R", "document.frm.txtuser_email", "Email");
	arValidate[index++] = new Array("E", "document.frm.txtuser_email", "Email");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}


function validatePassword()
{
	var index = 0;
	var arValidate = new Array;

	arValidate[index++] = new Array("R", "document.frm.user_oldpassword", "Old Password");
	arValidate[index++] = new Array("PASSWORD", "document.frm.user_oldpassword", "Old Password");
	arValidate[index++] = new Array("R", "document.frm.user_password", "New Password");
	arValidate[index++] = new Array("PASSWORD", "document.frm.user_password", "New Password");
	arValidate[index++] = new Array("R", "document.frm.user_confirmpassword", "Confirm Password");
	arValidate[index++] = new Array("PASSWORD", "document.frm.user_confirmpassword", "Confirm Password");
	arValidate[index++] = new Array("P", "document.frm.user_password|document.frm.user_confirmpassword", "New Password and Confirm Password must be same.");

	if (!Isvalid(arValidate)){
		return false;
	}
	return true;		
}

function validateBillingInfo()
{
	var index = 0;
	var arValidate = new Array;

	arValidate[index++] = new Array("R", "document.frm.txtbill_name", "Billing Name");
	arValidate[index++] = new Array("A", "document.frm.txtbill_name", "Billing Name");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}