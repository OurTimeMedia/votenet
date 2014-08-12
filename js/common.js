function validate(){
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("E", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("R", "document.frm.txtpassword", "password");		
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}

function validate_registration(){
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtfirst_name", "first name");
	arValidate[index++] = new Array("R", "document.frm.txtlast_name", "last name");
	arValidate[index++] = new Array("R", "document.frm.txtaddress1", "address1");
	arValidate[index++] = new Array("R", "document.frm.txtcity", "city");
	arValidate[index++] = new Array("S", "document.frm.selstate", "state");
	arValidate[index++] = new Array("R", "document.frm.txtzipcode", "zipcode");
	arValidate[index++] = new Array("R", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("E", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("P", "document.frm.txtemail|document.frm.txtconfirm_email", "Email and confirm email must match.");
	arValidate[index++] = new Array("R", "document.frm.txtpassword", "password");
	arValidate[index++] = new Array("P", "document.frm.txtpassword|document.frm.txtconfirm_password", "Password and confirm password must match.");
	arValidate[index++] = new Array("R", "document.frm.txtsecurity_code", "security code");
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}
function validate_myaccount(){
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtfirst_name", "first name");
	arValidate[index++] = new Array("R", "document.frm.txtlast_name", "last name");
	arValidate[index++] = new Array("R", "document.frm.txtaddress1", "address1");
	arValidate[index++] = new Array("R", "document.frm.txtcity", "city");
	arValidate[index++] = new Array("S", "document.frm.selstate", "state");
	arValidate[index++] = new Array("R", "document.frm.txtzipcode", "zipcode");
	arValidate[index++] = new Array("R", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("E", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("P", "document.frm.txtemail|document.frm.txtconfirm_email", "Email and confirm email must match.");
	
	arValidate[index++] = new Array("R", "document.frm.txtsecurity_code", "security code");
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}
function chkqty()
{
	//alert("in");
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("I", "document.frmcart.hdnquantity", "Quantity.");
	arValidate[index++] = new Array("G", "document.frmcart.hdnquantity", "Quantity.");
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}
function validate_change_pass() {
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.password", "Existing Password");
	arValidate[index++] = new Array("R", "document.frm.new_password", "New Password");
	arValidate[index++] = new Array("P", "document.frm.new_password|document.frm.new_password_confirm", "New password and confirm new password must match.");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}

function validate_forgot()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("E", "document.frm.txtemail", "email");
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}

var flag = true;
function showhide(new1)
{	if(flag)
	{	document.getElementById('forsame').className="formmn2";
		flag=false;	
	}
	else if(!flag)
	{	document.getElementById('forsame').className="formmn";
		flag=true;
	}
}
function validate_billing( ) {
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtbilling_firstname", "first name in billing address");
	arValidate[index++] = new Array("R", "document.frm.txtbilling_lastname", "last name in billing address");
	arValidate[index++] = new Array("R", "document.frm.txtbilling_street", "street in billing address");
	arValidate[index++] = new Array("R", "document.frm.txtbilling_city", "city in billing address");
	arValidate[index++] = new Array("S", "document.frm.selbilling_state", "state in billing address");
	arValidate[index++] = new Array("R", "document.frm.txtbilling_zip", "zip in billing address");
	arValidate[index++] = new Array("R", "document.frm.txtshipping_firstname", "first name in shipping address");
	arValidate[index++] = new Array("R", "document.frm.txtshipping_lastname", "last name in shipping address");
	arValidate[index++] = new Array("R", "document.frm.txtshipping_street", "street in shipping address");
	arValidate[index++] = new Array("R", "document.frm.txtshipping_city", "city in shipping address");
	arValidate[index++] = new Array("S", "document.frm.selshipping_state", "state in shipping address");
	arValidate[index++] = new Array("R", "document.frm.txtshipping_zip", "zip in shipping address");
	if (!Isvalid(arValidate)){
		return false;
	}	
}
function same_address ( status ) {
	if ( status == false ) {
		document.getElementById('txtshipping_firstname').value = '';	
		document.getElementById('txtshipping_lastname').value = '';	
		document.getElementById('txtshipping_street').value = '';	
		document.getElementById('txtshipping_street2').value = '';	
		document.getElementById('txtshipping_city').value = '';	
		document.getElementById('selshipping_state').value = '';	
		document.getElementById('txtshipping_zip').value = '';	
		document.getElementById('txtshipping_phone').value = '';	
	}
	if ( status == true ) {
		document.getElementById('txtshipping_firstname').value = document.getElementById('txtbilling_firstname').value;	
		document.getElementById('txtshipping_lastname').value = document.getElementById('txtbilling_lastname').value;	
		document.getElementById('txtshipping_street').value = document.getElementById('txtbilling_street').value;	
		document.getElementById('txtshipping_street2').value = document.getElementById('txtbilling_street2').value;	
		document.getElementById('txtshipping_city').value = document.getElementById('txtbilling_city').value;	
		document.getElementById('selshipping_state').value = document.getElementById('selbilling_state').value;	
		document.getElementById('txtshipping_zip').value = document.getElementById('txtbilling_zip').value;	
		document.getElementById('txtshipping_phone').value = document.getElementById('txtbilling_phone').value;	
	}
}

function validate_order ( ) {
	if ( document.getElementById('hdnaction').value == 'sample_only_order' ) {
		return true;	
	}
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtcc_name", "credit card name");
	arValidate[index++] = new Array("S", "document.frm.selcc_type", "credit card type");
	arValidate[index++] = new Array("R", "document.frm.txtcc_number", "credit card number");
	arValidate[index++] = new Array("S", "document.frm.selcc_expiry_month", "credit card expiry month");
	arValidate[index++] = new Array("S", "document.frm.selcc_expiry_year", "credit card expiry year");
	arValidate[index++] = new Array("R", "document.frm.txtcc_cv2", "CVV number");
	arValidate[index++] = new Array("H", "document.frm.chkagree", "agree to purchase agreement checkbox");
	if (!Isvalid(arValidate)){
		return false;
	}	
	document.getElementById('hdnaction').value = 'cc_process';
	return true;
}

function change_shipping_method ( ) {
	document.getElementById('hdnaction').value = 'shipping_method';
	document.getElementById('frm').submit();
}

function validate_contact(){
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtfirst_name", "name");
	arValidate[index++] = new Array("R", "document.frm.txtcompany_name", "company name");
	arValidate[index++] = new Array("R", "document.frm.txtaddress1", "address 1");
	
	if(document.frm.txtphone.value != '')
		arValidate[index++] = new Array("I", "document.frm.txtphone", "phone number");
	
	arValidate[index++] = new Array("R", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("E", "document.frm.txtemail", "email");
	
	arValidate[index++] = new Array("M", "document.frm.txtcomment|500", "Comment/Question");
	arValidate[index++] = new Array("R", "document.frm.txtsecurity_code", "security code");
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}

function validate_contact_quote(){
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtfirst_name", "first name");
	arValidate[index++] = new Array("R", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("E", "document.frm.txtemail", "email");	
	arValidate[index++] = new Array("M", "document.frm.txtcomment|500", "Comment/Question");
	arValidate[index++] = new Array("R", "document.frm.txtsecurity_code", "security code");
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}

function validate_contact_quote2(){
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtfirst_name", "first name");
	arValidate[index++] = new Array("R", "document.frm.txtcompany_name", "Business name");
	arValidate[index++] = new Array("R", "document.frm.txtaddress1", "Business Address");
	arValidate[index++] = new Array("R", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("E", "document.frm.txtemail", "email");
	arValidate[index++] = new Array("P", "document.frm.txtemail|document.frm.txtconfirm_email", "Email and confirm email must match.");
	arValidate[index++] = new Array("R", "document.frm.txtsecurity_code", "security code");
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}