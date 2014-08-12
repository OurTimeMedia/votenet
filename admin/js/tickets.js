function search_record(frm)
{
	frm.submit();
}

function validate()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtpostnotes", "Description");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}

function validation()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("S", "document.frm.selclient_id", "Client");
	arValidate[index++] = new Array("S", "document.frm.selticket_priority", "Priority");
	arValidate[index++] = new Array("S", "document.frm.selticket_type_id", "Type");
	arValidate[index++] = new Array("R", "document.frm.txtticket_title", "Title");
	arValidate[index++] = new Array("R", "document.frm.txtticket_description", "Description");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}

function validateEdit()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("S", "document.frmTicket.selticket_priority", "Priority");
	arValidate[index++] = new Array("S", "document.frmTicket.selticket_type_id", "Type");
	arValidate[index++] = new Array("R", "document.frmTicket.txtticket_title", "Title");

	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}