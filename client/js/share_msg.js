function validate()
{
	var index = 0;
	var arValidate = new Array;
		
	if(currentshow == 1)
		arValidate[index++] = new Array("R", "document.frm.fcontent", "Facebook Share Message");
	else if(currentshow == 2)
		arValidate[index++] = new Array("R", "document.frm1.tcontent", "Twitter Share Message");
	else if(currentshow == 3)
	{	
		arValidate[index++] = new Array("R", "document.frm2.gtitle", "Google Plus Share Title");
		arValidate[index++] = new Array("R", "document.frm2.gcontent", "Google Plus Share Message");
	}	
	else if(currentshow == 4)
	{
		arValidate[index++] = new Array("R", "document.frm3.tumblrtitle", "Tumblr Share Title");
		arValidate[index++] = new Array("R", "document.frm3.tucontent", "Tumblr Share Message");
	}	
	
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;
}