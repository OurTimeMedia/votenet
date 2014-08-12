
function validate()
{
	var index = 0;
	var arValidate = new Array;
	//arValidate[index++] = new Array("R", "document.frm.rdosite_config_isonline", "Site Status");
	arValidate[index++] = new Array("S", "document.frm.rdosite_config_isonline", "Site Status");
	arValidate[index++] = new Array("R", "document.frm.txtsite_config_offline_message", "Off-line Message");
	if (!Isvalid(arValidate)){
		return false;
	}

	return true;	
}