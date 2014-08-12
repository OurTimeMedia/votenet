function validate()
{
	var index = 0;
	var arValidate = new Array;
		
	arValidate[index++] = new Array("R", "document.frm.fcontent", "Facebook Share Message");
	arValidate[index++] = new Array("R", "document.frm.tcontent", "Twitter Share Message");
	arValidate[index++] = new Array("R", "document.frm.gtitle", "Google Plus Share Title");
	arValidate[index++] = new Array("R", "document.frm.gcontent", "Google Plus Share Message");
	arValidate[index++] = new Array("R", "document.frm.tumblrtitle", "Tumblr Share Title");
	arValidate[index++] = new Array("R", "document.frm.tucontent", "Tumblr Share Message");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;
}